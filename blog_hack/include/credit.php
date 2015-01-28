<?php
if (!(isset($_POST['login'])&&
	isset($_POST['pass']) 	&&
	isset($_POST['email']) 	&&
	isset($_POST['type']) 	&&
	!empty($_POST['login'])	&&
	!empty($_POST['pass'])	&&
	!empty($_POST['type'])	&&
	!empty($_POST['email']))) {
		header('Location: ./index.php?page=subscribe');
	}
	
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$email = $_POST['email'];
	$type = $_POST['type'];
	
	if (isset($_POST['total']) && $_POST['total'] == 15684) {
		//Insertion dans la BD
		$query = "INSERT INTO user (login, password, email, level) VALUES (
					'" . mysql_real_escape_string($login) . "',
					'" . md5($pass) . "',
					'" . mysql_real_escape_string($email) . "',
					" . intval($type) . ");";
		
		$query = mysql_query($query);
	?>
		<div class="contenu">
			<h2></h2>
			<div class="txt">Merci d'avoir été enregistré gratuitement<br /> <a href="index.php">Page d'accueil<a/></div>
			<div class="bas_bloc"></div>
		</div>	
		
	<?php } else { 
		$message = "";
		if (isset($_POST['total'])) {
			$message = "Vous êtes pauvre, veuillez vous inscrire gratuitement !";		
		}?> 
	
			<div class="contenu">
				<h2>Valider le compte</h2>
				<div class="txt">
					<?php echo $message; ?>
					<form method="POST" action="">
						<input type="hidden" name="login" value="<?php echo htmlspecialchars($login); ?>" />
						<input type="hidden" name="pass" value="<?php echo htmlspecialchars($pass); ?>" />
						<input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
						<input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>" />
						
						<?php if ($type == 1) { ?>
						<input type="hidden" name="total" value="15684" />
						Gratuit !!, Valider pour soummettre en tant que liseur. <br />
						<?php } else { ?>
						<input type="hidden" name="total" value="78325" />
						Vous devez déboursé un montant total de 999.99$ pour avoir accès au niveau 2.
						<table id="form">
							<tr>
								<td>Carte de crédit: (Si payant)</td><td><input type="text" name="credit" /></td>
							</tr>
						</table>
						<?php } ?>

						<input type="submit" value="Valider" />
					</form>
				</div>
				<div class="bas_bloc"></div>
			</div>		
	<?php } ?>
