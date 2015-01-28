<?php
if(isset($_POST['login']) && isset($_POST['pass']) && !empty($_POST['login']) && !empty($_POST['pass'])) {
    $sql = "SELECT id, level FROM user WHERE login = '" . $_POST['login'] . "' AND password = '" . md5($_POST['pass']) ."';";
    
    $query = mysql_query($sql);
    $result = mysql_fetch_array($query);
    
    if($result !== false) {
        $_SESSION['id'] =  $result['id'];
        $_SESSION['level'] =  $result['level'];
        header("Location: index.php?page=home");
    }
    else {
?>
    <div class="contenu" id="connexion">
        <h2>Connexion refusée</h2>
        <div class="txt">
            Le nom d'utilisateur ou le mot de passe est invalide. <a href="index.php?page=login">Recommencer?</a>
        </div>
        <div class="bas_bloc"></div>
    </div>
<?php
    }
}
else {
?>

    <div class="contenu" id="connexion">
        <h2>Connexion</h2>
        <div class="txt">
            <form method="post" action="">
			<table id="form">
				<tr>
					<td>Nom d'utilisateur: </td><td><input type="text" name="login" /></td>
				</tr>
				<tr>
					<td>Password: </td><td><input type="password" name="pass" /></td>
				</tr>
			</table>
                <input type="submit" value="Connexion" />
            </form>
            <a href="index.php?page=subscribe">Inscription</a>
        </div>
        <div class="bas_bloc"></div>
    </div>

<?php

}
?>
