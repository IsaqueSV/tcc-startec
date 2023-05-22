<?php
	include('../banco/conexao.php');
	session_start();

	if(isset($_POST['email']) AND isset($_POST['idNivel'])){
		$email = $_POST['email'];
		$idNivel = $_POST['idNivel'];

		$sql = "SELECT * FROM tb_usuario WHERE ds_email = '$email'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);

		if($num > 0){
			$sql_verifica = "SELECT * FROM tb_usuario WHERE ds_email = '$email' AND id_nivel = '$idNivel'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$num_verifica = mysqli_num_rows($query_verifica);

			if($num_verifica > 0){

			}else{
				if($email == 'equipelotustcc@gmail.com'){

				}else{
					echo "Email indisponível";
				}
			}
		}else{
			echo "Email não cadastrado";
		}
	}
?>