<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	if($idNivel != 3){
		?>
		<script>
			history.go(-1);
		</script>
		<?php
	}

	if(isset($_GET['see'])){
		if($_GET['see'] == ""){
			header('Location: ../index.php');
		}else{
			$idDenuncia = $_GET['see'];
			$sql = "SELECT * FROM tb_denuncia_usuario WHERE cd_denuncia_usuario = '$idDenuncia'";
			$query = mysqli_query($mysqli, $sql);
			$num = mysqli_num_rows($query);
			$row = mysqli_fetch_assoc($query);

			if($num > 0){
				$mysqli->query("DELETE FROM tb_denuncia_usuario WHERE cd_denuncia_usuario = '$idDenuncia'");
				?>
					<script>
						history.go(-1);
					</script>
				<?php
			}else{
				header('Location: ../home_adm.php');	
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>
