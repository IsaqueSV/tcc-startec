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
				$sql = "SELECT * FROM tb_curriculo WHERE ds_url_curriculo = '$url' AND id_autor_curriculo = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdCurriculo = $row['cd_curriculo'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_curtida_curriculo WHERE id_curtida_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_denuncia_curriculo WHERE id_denuncia_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_comentario_curriculo WHERE id_comentario_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_candidato WHERE id_candidato = '$cdUsuario'");
					$mysqli->query("DELETE FROM tb_curriculo WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");

					if($idNivel == 1){
						header('Location: ../curriculo_aluno.php');	
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 1){
						header('Location: ../editar_curriculo.php?see='.$_GET['see']);	
					}else{
						header('Location: ../index.php');
					}	
				}	
			}else if($idNivel == 3){
				$sql = "SELECT * FROM tb_curriculo WHERE ds_url_curriculo = '$url'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdCurriculo = $row['cd_curriculo'];
				$idAutorCurriculo = $row['id_autor_curriculo'];

				if($num > 0){
					$mysqli->query("DELETE FROM tb_curtida_curriculo WHERE id_curtida_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_denuncia_curriculo WHERE id_denuncia_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_comentario_curriculo WHERE id_comentario_curriculo = '$cdCurriculo'");
					$mysqli->query("DELETE FROM tb_candidato WHERE id_candidato = '$idAutorCurriculo'");
					$mysqli->query("DELETE FROM tb_curriculo WHERE cd_curriculo = '$cdCurriculo'");

					if($idNivel == 3){
						header('Location: ../curriculos_adm.php');
					}else{
						header('Location: ../index.php');
					}
				}else{
					if($idNivel == 3){
						header('Location: ../curriculos_adm.php');
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
