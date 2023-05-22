<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_FILES['foto']) OR isset($_POST['nome-usuario']) OR isset($_POST['nome-completo']) OR isset($_POST['email']) OR isset($_POST['github']) OR isset($_POST['descricao']) OR $_POST['select-genero-vazio']){
		if($_FILES['foto']['name'] == ""){
			$foto = "";
		}else{
			$pasta = "../dados/img/ft_usuarios/";
			$foto = $_FILES['foto'];
			$nomeDoArquivo = $_FILES['foto']['name'];
			$novoNomeDoArquivo = uniqid();
			$extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
			$path = $pasta.$novoNomeDoArquivo.".".$extensao;
			$outro = "dados/img/ft_usuarios/".$novoNomeDoArquivo.".".$extensao;
		
			if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg"){
				?>
				<script>
					alert("Verifique se você inseriu uma imagem com uma das seguintes extensões: jpg, png, jpeg)");
					history.go(-1);
				</script>
				<?php
			}else{
				$deu_certo = move_uploaded_file($foto['tmp_name'], $path);

				$sql_curriculo = "SELECT * FROM tb_curriculo WHERE id_autor_curriculo = '$cdUsuario'";
				$query_curriculo = mysqli_query($mysqli, $sql_curriculo);
				$num_curriculo = mysqli_num_rows($query_curriculo);

				if($num_curriculo > 0){
					if($deu_certo){
						$mysqli->query("UPDATE tb_usuario SET nm_foto_usuario = '$nomeDoArquivo', path_foto_usuario = '$outro' WHERE cd_usuario = '$cdUsuario'");
						$mysqli->query("UPDATE tb_curriculo SET nm_foto_curriculo = '$nomeDoArquivo', path_foto_curriculo = '$outro' WHERE id_autor_curriculo = '$cdUsuario'");
						?>
						<script>
							window.location.href = "../meu_perfil.php";
						</script>
						<?php
					}else{
						?>
						<script>
							alert("Ops, ocorreu um erro! Revise se todas informações preenchidas e tente novamente");
							history.go(-1);
						</script>
						<?php
					}
				}else{
					if($deu_certo){
						$mysqli->query("UPDATE tb_usuario SET nm_foto_usuario = '$nomeDoArquivo', path_foto_usuario = '$outro' WHERE cd_usuario = '$cdUsuario'");
						?>
						<script>
							window.location.href = "../meu_perfil.php";
						</script>
						<?php
					}else{
						?>
						<script>
							alert("Ops, ocorreu um erro! Revise se todas informações preenchidas e tente novamente");
							history.go(-1);
						</script>
						<?php
					}
				}			
			}
		}

		if($_POST['nome-usuario']  == ""){
			$nome_usuario = "";
		}else{
			$nome_usuario = $_POST['nome-usuario'];
			$mysqli->query("UPDATE tb_usuario SET nm_usuario = '$nome_usuario' WHERE cd_usuario = '$cdUsuario'");
		}

		if($_POST['nome-completo']  == ""){
			$nome_completo = "";
		}else{
			$nome_completo = $_POST['nome-completo'];
			$mysqli->query("UPDATE tb_usuario SET nm_completo = '$nome_completo' WHERE cd_usuario = '$cdUsuario'");
			$mysqli->query("UPDATE tb_curriculo SET nm_completo_curriculo = '$nome_completo' WHERE id_autor_curriculo = '$cdUsuario'");
		}

		if($_POST['email']  == ""){
			$email = "";
		}else{
			$email = $_POST['email'];
			$pos = strpos($email, "@");
			$pos2 = strpos($email, ".com");

			if($pos == true AND $pos2 == true){
				$sql_email = "SELECT * FROM tb_usuario WHERE ds_email = '$email'";
				$query_email = mysqli_query($mysqli, $sql_email);
				$num_email = mysqli_num_rows($query_email);

				if($num_email > 0){
					?>
					<script>
						alert("Este email já esta em uso");
					</script>
					<?php
				}else{
					$mysqli->query("UPDATE tb_usuario SET ds_email = '$email' WHERE cd_usuario = '$cdUsuario'");
					if($idNivel == 2){
						$mysqli->query("UPDATE tb_vaga SET ds_contato_email = '$email' WHERE id_autor_vaga = '$cdUsuario'");
					}else{
						$mysqli->query("UPDATE tb_curriculo SET ds_contato_email = '$email' WHERE id_autor_curriculo = '$cdUsuario'");
					}
				}
			}
		}

		if($_POST['github']  == ""){
			$mysqli->query("UPDATE tb_usuario SET nm_github = 'Não declarado', ds_github_url = null WHERE cd_usuario = '$cdUsuario'");
			$mysqli->query("UPDATE tb_projeto SET ds_github = 'Diretório Github do projeto não declarado' WHERE id_autor_projeto = '$cdUsuario'");
			$mysqli->query("DELETE FROM tb_projeto WHERE ds_site = 'Domínio do projeto não declarado' AND ds_github = 'Diretório Github do projeto não declarado' AND arquivos = '0' AND id_autor_projeto = '$cdUsuario'");
		}else{
			$nm_git = $_POST['github'];
			$ds_git = "https://github.com/".$_POST['github'];

			$sql_git = "SELECT * FROM tb_usuario WHERE nm_github = '$nm_git'";
			$query_git = mysqli_query($mysqli, $sql_git);
			$num_git = mysqli_num_rows($query_git);
			if($num_git > 0){
				?>
				<script>
					alert("Esta conta Github já esta em uso");
				</script>
				<?php
			}else{
				$mysqli->query("UPDATE tb_usuario SET nm_github = '$nm_git', ds_github_url = '$ds_git' WHERE cd_usuario = '$cdUsuario'");
			}
		}

		if($_POST['select-genero-vazio']  == ""){

		}else{
			$genero = $_POST['select-genero-vazio'];

			$mysqli->query("UPDATE tb_usuario SET id_genero = '$genero' WHERE cd_usuario = '$cdUsuario'");
			$mysqli->query("UPDATE tb_curriculo SET id_genero_curriculo = '$genero' WHERE id_autor_curriculo = '$cdUsuario'");
		}

		if($_POST['descricao']  == ""){
			$mysqli->query("UPDATE tb_usuario SET ds_descricao = 'Descrição não declarada' WHERE cd_usuario = '$cdUsuario'");
		}else{
			$descricao = $_POST['descricao'];
			$mysqli->query("UPDATE tb_usuario SET ds_descricao = '$descricao' WHERE cd_usuario = '$cdUsuario'");
		}

		header('Location: ../meu_perfil.php');
	}else{
		header('Location: ../index.php');
	}

?>
