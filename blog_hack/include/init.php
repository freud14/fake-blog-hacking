<?php 

	session_start();

	$link = mysqli_connect( "", "admin_hack", "torototo", "test_hack" ) or die("Error " . mysqli_error($link));

	$link->set_charset("utf8");

?>
