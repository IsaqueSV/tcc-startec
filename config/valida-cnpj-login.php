<?php
	include('../banco/conexao.php');
	session_start();

	if(isset($_POST['cnpj']) AND isset($_POST['idNivel'])){
		$cnpj = $_POST['cnpj'];
		$idNivel = $_POST['idNivel'];

		$sql = "SELECT * FROM tb_usuario WHERE ds_cnpj = '$cnpj'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);

		if($num > 0){

		}else{
			echo "CNPJ não cadastrado";
		}
	}
?>