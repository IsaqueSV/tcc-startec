<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['nome-projeto']) OR isset($_POST['select-pchave']) OR isset($_POST['desc-projeto']) OR isset($_POST['github-diretorio']) OR isset($_POST['site-url'])){
		if(isset($_GET['see'])){
			if($_GET['see'] == ""){
				header('Location: ../index.php');
			}else{
				$url = $_GET['see'];
				$sql = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario WHERE ds_url_projeto = '$url' AND id_autor_projeto = '$cdUsuario'";
				$query = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($query);
				$row = mysqli_fetch_assoc($query);
				$cdProjeto = $row['cd_projeto'];

				if($num > 0){
					if($_POST['nome-projeto'] == ""){
						$nome_projeto = "";
					}else{
						$nome_projeto = $_POST['nome-projeto'];
						$mysqli->query("UPDATE tb_projeto SET nm_projeto = '$nome_projeto' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}

					if($_POST['select-pchave'] == ""){
						$select_pchave = "";
					}else{
						$select_pchave = $_POST['select-pchave'];
						$mysqli->query("UPDATE tb_projeto SET id_pchave_projeto = '$select_pchave' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}

					if($_POST['desc-projeto'] == ""){
						$desc = "";
						$mysqli->query("UPDATE tb_projeto SET ds_projeto = 'Descrição não declarada' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}else{
						$desc = $_POST['desc-projeto'];
						$mysqli->query("UPDATE tb_projeto SET ds_projeto = '$desc' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}

					if($_POST['github-diretorio'] == "Diretório Github do projeto não declarado"){
						$mysqli->query("UPDATE tb_projeto SET ds_github = 'Diretório Github do projeto não declarado' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}else{
						if($_POST['github-diretorio'] == ""){
							$diretorio = "";
							$mysqli->query("UPDATE tb_projeto SET ds_github = 'Diretório Github do projeto não declarado' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
						}else{
							$diretorio = "https://github.com/".$row['nm_github']."/".$_POST['github-diretorio'];
							$mysqli->query("UPDATE tb_projeto SET ds_github = '$diretorio' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
						}
					}

					if($_POST['site-url'] == ""){
						$site = "";
						$mysqli->query("UPDATE tb_projeto SET ds_site = 'Domínio do projeto não declarado' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}else{
						$site = "https://".$_POST['site-url'];
						$mysqli->query("UPDATE tb_projeto SET ds_site = '$site' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
					}

					foreach ($_FILES['arquivo']['name'] as $chave => $nome){
						if($nome == ""){

						}else{
							$extensoes_permitidas = array('.zip','.rar');
							$extensao = strrchr($nome, '.');
							if(in_array($extensao, $extensoes_permitidas) === true){
								$novoNome = time() . "_" . $nome;
								move_uploaded_file($_FILES['arquivo']['tmp_name'][$chave], '../dados/arquivos/' . $novoNome);
								$caminho = 'dados/arquivos/' . $novoNome;
															
								mysqli_query($mysqli, "INSERT INTO tb_arquivo VALUES (null, '$nome', '$caminho', '$extensao', '$cdUsuario', '$cdProjeto', NOW())");
								$sql_arquivos = "SELECT * FROM tb_arquivo WHERE id_autor_arquivo = '$cdUsuario' AND id_projeto_arquivo = '$cdProjeto'";
								$query_arquivos = mysqli_query($mysqli, $sql_arquivos);
								$num_arquivos = mysqli_num_rows($query_arquivos);
								mysqli_query($mysqli, "UPDATE tb_projeto SET arquivos = '$num_arquivos' WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");
							}
						}
					}

					$sql_verifica = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario WHERE ds_url_projeto = '$url' AND id_autor_projeto = '$cdUsuario'";
					$query_verifica = mysqli_query($mysqli, $sql_verifica);
					$row_verifica = mysqli_fetch_assoc($query_verifica);

					if($row_verifica['ds_github'] == "Diretório Github do projeto não declarado" AND $row_verifica['ds_site'] == "Domínio do projeto não declarado" AND $row_verifica['arquivos'] == 0){

						$mysqli->query("DELETE FROM tb_arquivo WHERE id_projeto_arquivo = '$cdProjeto' AND id_autor_arquivo = '$cdUsuario'");
						$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_curtida_projeto = '$cdProjeto'");
						$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '$cdProjeto'");
						$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_comentario_projeto = '$cdProjeto'");
						$mysqli->query("DELETE FROM tb_projeto WHERE cd_projeto = '$cdProjeto' AND id_autor_projeto = '$cdUsuario'");

						header('Location: ../projetos_aluno.php');
					}else{
						header('Location: ../projetos_aluno.php');
						//header('Location: ../editar_projeto.php?see='.$_GET['see']);	
					}

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
