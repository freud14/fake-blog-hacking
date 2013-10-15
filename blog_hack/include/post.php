<?php
    if(!(isset($_GET['id']) && intval($_GET['id'])))
    {
        header('Location: ./index.php');
    }
    
    if(isset($_POST['comment']) && !empty($_POST['comment'])) {
        $sql = "INSERT INTO
                    comment
                        (user_id,
                        post_id,
                        comment)
                VALUES
                    (".$_SESSION['id'] .",".
                    intval($_GET['id']).", '" .
                    mysql_real_escape_string($_POST['comment'])."');";
        mysql_query($sql);
    }

    $sql = "SELECT
                post.id,
                user.login,
                post.title,
                post.message
            FROM
                post
                    JOIN user
                        ON post.user_id = user.id
            WHERE
                post.id = " . intval($_GET['id']) . "
            ORDER BY
                post.id DESC
            LIMIT
                10;";
    
    $post_query = mysql_query($sql);
    
    if (mysql_num_rows($post_query) == 0) {
        header('Location: ./index.php');
    }
    
    $post_row = mysql_fetch_array($post_query);    
    
    $sql = "SELECT
                comment.id,
                user.login,
                comment.comment
            FROM
                comment
                    JOIN user
                        ON  comment.user_id = user.id and
                            comment.post_id = " . intval($_GET['id']) . "
            ORDER BY
                comment.id;";
    
    $comment_query = mysql_query($sql);       
                
?>

<div class="contenu">
    <h2><a href="index.php?page=post&id=<?php echo $post_row['id']; ?>"><?php echo $post_row['title']; ?></a></h2>
    <div class="txt"><?php echo $post_row['message']; ?></div>
    <div class="signature"><?php echo $post_row['login']; ?></div>
    
    <?php while ($comment_row = mysql_fetch_array($comment_query)) { ?>
            
            <div class="comment">
                <div class="hr"></div>
                <div class="txt"><?php echo $comment_row['comment']; ?></div>
                <div class="signature"><?php echo $comment_row['login']; ?></div>
            </div>
    
    <?php } ?>
    
    
    
    <?php if($_SESSION['level'] >= 2) {?>
        <div class="hr"></div>
        <form method="post" action="">
        <div class="txt">Commentaire: <br /><textarea cols="50" rows="10" name="comment"></textarea><br /><input type="submit" value="Envoyer le commentaire" /></div>
        </form>
    <?php } ?>
    
    <div class="bas_bloc"></div>
</div>















