<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Blog BitDucks</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="fr" />
		<link rel="stylesheet" href="design/style.css" type="text/css" title="Style" />
	</head>
	<body>
		<div id="page">
				<div class="header">
					<h1></h1>
					<ul id="menu">
					    <?php  if(isset($_SESSION['id']) && $_SESSION['id'] > 0) { ?>
						<li><a href="index.php">Accueil</a></li>
						<li><a href="index.php?page=profile">Mon profil</a></li>
						<li><a href="index.php?page=members">Liste des membres</a></li>
						<li><a href="index.php?page=logout">Déconnexion</a></li>
						<?php } ?>
					</ul>
				</div>
