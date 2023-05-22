a<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($cdUsuario) AND isset($idNivel) AND isset($_GET['see'])){
		if($_GET['see'] == ""){
			header('Location: ../index.php');
		}else{
			$arq = $_GET['see'];
			$sql = "SELECT * FROM tb_arquivo WHERE id_autor_arquivo = '$cdUsuario' AND cd_arquivo = '$arq'";
			$query = mysqli_query($mysqli, $sql);
			$num = mysqli_num_rows($query);
			$row = mysqli_fetch_assoc($query);

			if($num > 0){
				$cdProjeto = $row['id_projeto_arquivo'];
				$sql_deleta = "DELETE FROM tb_arquivo WHERE cd_arquivo = '$arq'";
				if($resultado = $mysqli->query($sql_deleta)){
					$sql_conta = "SELECT * FROM tb_arquivo WHERE id_autor_arquivo = '$cdUsuario' AND id_projeto_arquivo = '$cdProjeto'";
					if($resultado_conta = $mysqli->query($sql_conta)){
						$num_conta = mysqli_num_rows($resultado_conta);
						$mysqli->query("UPDATE tb_projeto SET arquivos = '$num_conta' WHERE id_autor_projeto = '$cdUsuario' AND cd_projeto = '$cdProjeto'");		
					}
				}
				?>
					<script>
						history.go(-1);
					</script>
				<?php
			}else{
				header('Location: ../index.php');
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>