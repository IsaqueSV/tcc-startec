<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if($_SESSION['cdUsuario'] == "" OR $_SESSION['idNivel'] == ""){
		header('Location: ../index.php');
	}else{
		session_destroy();
		header('Location: ../index.php');
	}
	
?>