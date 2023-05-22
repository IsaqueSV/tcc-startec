<?php 
	$mysqli = new mysqli('localhost', 'root', '', 'db_startec');
	mysqli_set_charset($mysqli, 'utf8');
	if($mysqli->connect_errno){
		echo $mysqli->connect->error;
	}
?>