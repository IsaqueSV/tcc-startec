<?php
	include ('../banco/conexao.php');
	session_start();
	if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
		
	if(isset($_POST['cad_nm_empresa']) AND isset($_POST['cad_email']) AND isset($_POST['cad_cnpj']) AND isset($_POST['cad_senha'])){
		if(empty($_POST['cad_nm_empresa']) OR empty($_POST['cad_email']) OR empty($_POST['cad_cnpj']) OR empty($_POST['cad_senha'])){
				header('Location: ../index.php');
		}else{
			$nome = $_POST['cad_nm_empresa'];
			$email = $_POST['cad_email'];
			$cnpj = $_POST['cad_cnpj'];
			$senha = $_POST['cad_senha'];
			$url_usuario = md5(uniqid(""));
			$sql = "INSERT INTO tb_usuario VALUES (null, 'user.jpg', 'dados/img/ft_usuarios/user.jpg', '$nome', '-', '$email', '$senha', '$cnpj', null, null, 'Descrição não declarada', '$url_usuario', null, null, null, '2', NOW())";
			if($resultado = $mysqli->query($sql)){
					
				$sql_login = "SELECT * FROM tb_usuario WHERE nm_usuario = '$nome' AND ds_email = '$email' AND ds_cnpj = '$cnpj' AND ds_senha = '$senha' AND id_nivel = '2'";
				$query_login = mysqli_query($mysqli, $sql_login);
				$row_login = mysqli_fetch_assoc($query_login);

				$_SESSION['cdUsuario'] = $row_login['cd_usuario'];
				$_SESSION['idNivel'] = $row_login['id_nivel'];
				?>
				<script>
					window.location.href="../home_empresa.php";
				</script>
				<?php
			}else{

				?>
				<script>
					alert("Ocorreu um erro ao cadastrar. Tente novamente!");
					window.location.href = "../cadastrar_empresa.php";
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}

?>