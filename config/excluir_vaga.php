<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_GET['see'])){
		if($_GET['see'] == ""){
			header('Location: ../index.php');
		}else{
			$url = $_GET['see'];

			if($idNivel == 2){
				$sql = "SELECT * FROM tb_vaga WHERE ds_url_vaga = '$url' AND id_autor_vaga = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdVaga = $row['cd_vaga'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_candidato WHERE id_vaga = '$cdVaga' AND id_autor_vaga_candidato = '$cdUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_vaga WHERE id_curtida_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_denuncia_vaga WHERE id_denuncia_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_comentario_vaga WHERE id_comentario_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_vaga WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");

					if($idNivel == 2){
						header('Location: ../vagas_empresa.php');	
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 2){
						header('Location: ../editar_vaga.php?see='.$_GET['see']);	
					}else{
						header('Location: ../index.php');
					}	
				}	
			}else if($idNivel == 3){
				$sql = "SELECT * FROM tb_vaga WHERE ds_url_vaga = '$url'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdVaga = $row['cd_vaga'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_candidato WHERE id_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_curtida_vaga WHERE id_curtida_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_denuncia_vaga WHERE id_denuncia_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_comentario_vaga WHERE id_comentario_vaga = '$cdVaga'");
					$mysqli->query("DELETE FROM tb_vaga WHERE cd_vaga = '$cdVaga'");

					if($idNivel == 3){
						header('Location: ../vagas_adm.php');
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 3){
						header('Location: ../vagas_adm.php');
					}else{
						header('Location: ../index.php');
					}	
				}
			}else{
				header('Location: ../index.php');
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>