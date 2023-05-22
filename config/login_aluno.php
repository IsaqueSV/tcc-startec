<?php
	include('../banco/conexao.php');
	session_start();

	if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['log_email']) AND isset($_POST['log_senha'])){
		$email = $_POST['log_email'];
		$senha = $_POST['log_senha'];

		$sql_verifica = "SELECT * FROM tb_usuario WHERE ds_email = '$email' AND ds_senha = '$senha'";
		$query_verifica = mysqli_query($mysqli, $sql_verifica);
		$num_verifica = mysqli_num_rows($query_verifica);
		$row_verifica = mysqli_fetch_assoc($query_verifica);

		if($num_verifica > 0){
			if($row_verifica['id_nivel'] == 3){
				$_SESSION['cdUsuario'] = $row_verifica['cd_usuario'];
				$_SESSION['idNivel'] = $row_verifica['id_nivel'];

				?>
					<script>
						window.location.href="../home_adm.php";
					</script>
				<?php		
			}else if($row_verifica['id_nivel'] == 1){
				$_SESSION['cdUsuario'] = $row_verifica['cd_usuario'];
				$_SESSION['idNivel'] = $row_verifica['id_nivel'];

				?>
					<script>
						window.location.href="../home_aluno.php";
					</script>
				<?php	
			}else if($row_verifica['id_nivel'] == 2){
				?>
					<script>
						alert("Estes dados não conferem. Verifique se as informações foram digitadas corretamente");
						history.go(-1);
					</script>
				<?php
			}
		}else{
			?>
				<script>
					alert("Usuário não encontrado. Verifique se todos os dados foram preenchidos corretamente");
					history.go(-1);
				</script>
			<?php
		}
	}else{
		header('Location: ../index.php');
	}
	
?>