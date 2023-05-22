<?php
	header('Content-Type: text/html; charset=utf-8');
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['nome-vaga']) AND isset($_POST['select-pchave']) AND isset($_POST['localizacao']) AND isset($_POST['select-horario']) AND isset($_POST['email']) AND isset($_POST['telefone']) AND isset($_POST['descricao'])){
		if(empty($_POST['nome-vaga']) OR empty($_POST['select-pchave']) OR empty($_POST['localizacao']) OR empty($_POST['select-horario']) OR empty($_POST['email']) OR empty($_POST['descricao'])){
			header('Location: ../index.php');
		}else{
			$nome = $_POST['nome-vaga'];
			$localizacao = $_POST['localizacao'];
			$horario = $_POST['select-horario'];
			$email = $_POST['email'];
			$telefone = $_POST['telefone'];
			$descricao = $_POST['descricao'];
			$idAutor = $_SESSION['cdUsuario'];
			$pchave = $_POST['select-pchave'];
			$url_vaga = md5(uniqid(""));

			if($telefone == ""){
				$telefone = "Não declarado";
			}

			$sql = "INSERT INTO tb_vaga VALUES (null, '$nome', '$localizacao', '$horario', '$email', '$telefone', '$descricao', '$url_vaga', '$idAutor', '$pchave', NOW())";
			if($query = $mysqli->query($sql)){
				?>
				<script>
					window.location.href = "../vagas_empresa.php";
				</script>
				<?php
			}else{
				?>
				<script>
					alert("Ops, ocorreu um erro. Tente novamente!");
					history.go(-1);
				</script>
				<?php
			}
		}
	}else{
		header('Location: index.php');
	}
?>