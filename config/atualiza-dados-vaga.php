<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['nome-vaga']) OR isset($_POST['select-pchave']) OR isset($_POST['localizacao']) OR isset($_POST['select-horario']) OR isset($_POST['email']) OR isset($_POST['telefone']) OR isset($_POST['descricao'])){
		if(isset($_GET['see'])){
			if($_GET['see'] == ""){
				header('Location: ../index.php');
			}else{
				$url = $_GET['see'];
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario WHERE ds_url_vaga = '$url' AND id_autor_vaga = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdVaga = $row['cd_vaga'];

				if($num > 0){
					if($_POST['nome-vaga'] == ""){
						$nome_vaga = "";
					}else{
						$nome_vaga = $_POST['nome-vaga'];
						$mysqli->query("UPDATE tb_vaga SET nm_vaga = '$nome_vaga' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}

					if($_POST['select-pchave'] == ""){
						$select_pchave = "";
					}else{
						$select_pchave = $_POST['select-pchave'];
						$mysqli->query("UPDATE tb_vaga SET id_pchave_curriculo = '$select_pchave' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}

					if($_POST['localizacao'] == ""){
						$localizacao = "";
					}else{
						$localizacao = $_POST['localizacao'];
						$mysqli->query("UPDATE tb_vaga SET ds_localizacao = '$localizacao' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}

					if($_POST['select-horario'] == ""){
						$select_horario = "";
					}else{
						$select_horario = $_POST['select-horario'];
						$mysqli->query("UPDATE tb_vaga SET id_pchave_vaga = '$select_horario' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}

					if($_POST['telefone'] == ""){
						$telefone = "Não declarado";
						$mysqli->query("UPDATE tb_vaga SET ds_contato_telefone = '$telefone' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}else{
						$telefone = $_POST['telefone'];
						$mysqli->query("UPDATE tb_vaga SET ds_contato_telefone = '$telefone' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}

					if($_POST['descricao'] == ""){
						$desc = "";
						$mysqli->query("UPDATE tb_vaga SET ds_vaga = 'Descrição não declarada' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}else{
						$desc = $_POST['descricao'];
						$mysqli->query("UPDATE tb_vaga SET ds_vaga = '$desc' WHERE cd_vaga = '$cdVaga' AND id_autor_vaga = '$cdUsuario'");
					}


					header('Location: ../vagas_empresa.php');
					//header('Location: ../editar_vaga.php?see='.$_GET['see']);
				}else{
					header('Location: ../index.php');
				}
			}
		}else{
			header('Location: ../index.php');
		}
	}else{
		header('Location: ../index.php');
	}
?>
