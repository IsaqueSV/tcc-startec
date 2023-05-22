<?php
	include('../banco/conexao.php');
	session_start();

	if(isset($_POST['email'])){
		$email = $_POST['email'];

		$sql = "SELECT * FROM tb_usuario WHERE ds_email = '$email'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);

		if($num > 0){
			echo "Email já cadastrado";
		}else{
			echo "Email disponível";
		}
	}
?>