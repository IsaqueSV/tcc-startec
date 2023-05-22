<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['projetoCurtido'])){
		if(empty($_POST['autor']) OR empty($_POST['projetoCurtido'])){
		}else{
			$autor = $_POST['autor'];
			$projetoCurtido = $_POST['projetoCurtido'];

			$sql_projeto_curtido = "SELECT * FROM tb_projeto WHERE cd_projeto = '$projetoCurtido'";
			$query_projeto_curtido = mysqli_query($mysqli, $sql_projeto_curtido);
			$row_projeto_curtido = mysqli_fetch_assoc($query_projeto_curtido);
			$autorDoProjeto = $row_projeto_curtido['id_autor_projeto'];

			$sql_verifica = "SELECT * FROM tb_curtida_projeto WHERE id_curtida_projeto = '$projetoCurtido' AND id_autor_curtida_projeto = '$autor'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$num_verifica = mysqli_num_rows($query_verifica);

			if($num_verifica > 0){
				$sql_deleta = "DELETE FROM tb_curtida_projeto WHERE id_curtida_projeto = '$projetoCurtido' AND id_autor_curtida_projeto = '$autor'";
				$query_deleta = mysqli_query($mysqli, $sql_deleta);
			}else{
				$sql_insere = "INSERT INTO tb_curtida_projeto VALUES (null, '$autor', '$projetoCurtido', '$autorDoProjeto', NOW())";
				$query_insere = mysqli_query($mysqli, $sql_insere);
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>