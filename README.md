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

## Form validation vulnerability

First of all, there is a form validation vulnerability in the subscription form. What you have to do is to submit the first form with "Level 1" account and then you arrive on a second page that is a hidden form. If you check the source, you'll see that there is a `type` field and a `total` field. So if you check in the first form for the values, you'll see that the value for the level 2 is 2. But here's the trick, you have to modify the `type` field in the second form with a value of 3 instead of 1 or 2 and you must not modify the `total` field. Then, you submit the hidden for you normally should be able to comment on blog article.
