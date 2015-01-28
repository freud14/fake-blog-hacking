<?php
	$result = mysql_query("SELECT * FROM accepted_user_agent WHERE user_agent = '".$_SERVER['HTTP_USER_AGENT']."'");
	$count = mysql_num_rows($result);
	
	if($count == 0) { ?>
			<div class="contenu">
				<h2>Utilisation d'un navigateur non supporté</h2>
				<div class="txt">
					Le navigateur que vous utilisez présentement n'est pas supporté par notre blog. Ceci peut causer quelques bugs. Ce message disparaîtra lorsque vous aurez un bon navigateur.
				</div>
				<div class="bas_bloc"></div>
			</div>
<?php
	}
?>

		</div>
	</body>
</html>
