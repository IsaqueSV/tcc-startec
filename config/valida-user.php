<?php
	include('../banco/conexao.php');
	session_start();

	if(isset($_POST['nome'])){
		$nome = $_POST['nome'];

		$sql = "SELECT * FROM tb_usuario WHERE nm_usuario = '$nome'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);

		if($num > 0){
			echo "Nome já cadastrado";
		}else{
			echo "Nome disponível";
		}
	}
?>