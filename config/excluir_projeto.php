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

			if($idNivel == 1){
				$sql = "SELECT * FROM tb_projeto WHERE ds_url_projeto = '$url' AND id_autor_projeto = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdProjeto = $row['cd_projeto'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_arquivo WHERE id_projeto_arquivo = '$cdProjeto' AND id_autor_arquivo = '$cdUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_curtida_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_comentario_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_projeto WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");

					if($idNivel == 1){
						header('Location: ../projetos_aluno.php');	
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 1){
						header('Location: ../editar_projeto.php?see='.$_GET['see']);	
					}else{
						header('Location: ../index.php');
					}	
				}	
			}else if($idNivel == 3){
				$sql = "SELECT * FROM tb_projeto WHERE ds_url_projeto = '$url'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdProjeto = $row['cd_projeto'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_arquivo WHERE id_projeto_arquivo = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_curtida_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_comentario_projeto = '$cdProjeto'");
					$mysqli->query("DELETE FROM tb_projeto WHERE cd_projeto = '$cdProjeto'");

					if($idNivel == 3){
						header('Location: ../projetos_adm.php');
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 3){
						header('Location: ../projetos_adm.php');
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
