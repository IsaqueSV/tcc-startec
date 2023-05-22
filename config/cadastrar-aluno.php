<?php
	include ('../banco/conexao.php');
	session_start();
	if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['cad_nm_usuario']) AND isset($_POST['cad_nm_completo']) AND isset($_POST['cad_email']) AND isset($_POST['cad_senha']) AND isset($_POST['cad_etec'])){
		if(empty($_POST['cad_nm_usuario']) OR empty($_POST['cad_nm_completo']) OR empty($_POST['cad_email']) OR empty($_POST['cad_senha']) OR empty($_POST['cad_etec'])){
			header('Location: ../index.php');
		}else{
			$user = $_POST['cad_nm_usuario'];
			$nome = $_POST['cad_nm_completo'];
			$email = $_POST['cad_email'];
			$senha = $_POST['cad_senha'];
			$etec = $_POST['cad_etec'];
			$url_usuario = md5(uniqid(""));

			$sql = "INSERT INTO tb_usuario VALUES (null, 'user.jpg', 'dados/img/ft_usuarios/user.jpg', '$user', '$nome', '$email', '$senha', null, 'Não declarado', null, 'Descrição não declarada', '$url_usuario', 5, '$etec', 7, 1, NOW())";
			
			if($resultado = $mysqli->query($sql)){
				$sql_login = "SELECT * FROM tb_usuario WHERE ds_email = '$email' AND nm_usuario = '$user' AND id_nivel = '1'";
				$query_login = mysqli_query($mysqli, $sql_login);
				$row_login = mysqli_fetch_assoc($query_login);

				$_SESSION['cdUsuario'] = $row_login['cd_usuario'];
				$_SESSION['idNivel'] = $row_login['id_nivel'];
				?>
				<script>
					window.location.href="../home_aluno.php";
				</script>
				<?php
			}else{
				?>
				<script>
					alert("Ocorreu um erro ao cadastrar. Tente novamente!");
					window.location.href = "../cadastrar_aluno.php";
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}

?>