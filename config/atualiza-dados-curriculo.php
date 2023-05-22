<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['cargo']) OR isset($_POST['select-pchave']) OR isset($_POST['select-estado-civil']) OR isset($_POST['ddd']) OR isset($_POST['telefone']) OR isset($_POST['select-cidade']) OR isset($_POST['cep']) OR isset($_POST['idiomas']) OR isset($_POST['qualidades']) OR isset($_POST['cursos'])){
		if(isset($_GET['see'])){
			if($_GET['see'] == ""){
				header('Location: ../index.php');
			}else{
				$url = $_GET['see'];
				$sql = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario WHERE ds_url_curriculo = '$url' AND id_autor_curriculo = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdCurriculo = $row['cd_curriculo'];

				if($num > 0){
					if($_POST['cargo'] == ""){
						$cargo = "";
					}else{
						$cargo = $_POST['cargo'];
						$mysqli->query("UPDATE tb_curriculo SET ds_cargo = '$cargo' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['select-pchave'] == ""){
						$select_pchave = "";
					}else{
						$select_pchave = $_POST['select-pchave'];
						$mysqli->query("UPDATE tb_curriculo SET id_pchave_curriculo = '$select_pchave' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['select-estado-civil'] == ""){
						$select_estado = "";
					}else{
						$select_estado = $_POST['select-estado-civil'];
						$mysqli->query("UPDATE tb_curriculo SET id_estado_civil = '$select_estado' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['ddd'] == ""){
						$ddd = "";
					}else{
						$ddd = $_POST['ddd'];
						$telefone = $ddd.$_POST['telefone'];
						$mysqli->query("UPDATE tb_curriculo SET ds_contato_telefone = '$telefone' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['select-cidade'] == ""){
						$cidade = "";
					}else{
						$cidade = $_POST['select-cidade'];
						$mysqli->query("UPDATE tb_curriculo SET id_municipio = '$cidade' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['cep'] == ""){
						$cep = "";
					}else{
						$cep = $_POST['cep'];
						$mysqli->query("UPDATE tb_curriculo SET ds_cep = '$cep' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['idiomas'] == ""){
						$idiomas = "";
						$mysqli->query("UPDATE tb_curriculo SET ds_idioma = 'Campo não preenchido pelo usuário' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}else{
						$idiomas = $_POST['idiomas'];
						$mysqli->query("UPDATE tb_curriculo SET ds_idioma = '$idiomas' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['qualidades'] == ""){
						$qualidades = "";
						$mysqli->query("UPDATE tb_curriculo SET ds_qualidade = 'Campo não preenchido pelo usuário' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}else{
						$qualidades = $_POST['qualidades'];
						$mysqli->query("UPDATE tb_curriculo SET ds_qualidade = '$qualidades' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					if($_POST['cursos'] == ""){
						$cursos = "";
						$mysqli->query("UPDATE tb_curriculo SET ds_curso = 'Campo não preenchido pelo usuário' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}else{
						$cursos = $_POST['cursos'];
						$mysqli->query("UPDATE tb_curriculo SET ds_curso = '$cursos' WHERE cd_curriculo = '$cdCurriculo' AND id_autor_curriculo = '$cdUsuario'");
					}

					header('Location: ../curriculo_aluno.php');
					//header('Location: ../editar_curriculo.php?see='.$_GET['see']);

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

	/*
	*/
?>
