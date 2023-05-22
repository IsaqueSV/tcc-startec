<?php
	include('../banco/conexao.php');
	session_start();

	if(isset($_POST['cnpj'])){
		$cnpj = $_POST['cnpj'];

		$sql = "SELECT * FROM tb_usuario WHERE ds_cnpj = '$cnpj'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);

		if($num > 0){
			echo "CNPJ já cadastrado";
		}else{
			echo "CNPJ disponível";
		}
	}
?>