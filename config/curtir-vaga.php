<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['vagaCurtida'])){
		if(empty($_POST['autor']) OR empty($_POST['vagaCurtida'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela").removeClass("alert-success");
				$("#alerta-cancela").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$vagaCurtida = $_POST['vagaCurtida'];

			$sql_vaga_curtida = "SELECT * FROM tb_vaga WHERE cd_vaga = '$vagaCurtida'";
			$query_vaga_curtida = mysqli_query($mysqli, $sql_vaga_curtida);
			$row_vaga_curtida = mysqli_fetch_assoc($query_vaga_curtida);
			$autorDaVaga = $row_vaga_curtida['id_autor_vaga'];

			$sql_verifica = "SELECT * FROM tb_curtida_vaga WHERE id_curtida_vaga = '$vagaCurtida' AND id_autor_curtida_vaga = '$autor'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$num_verifica = mysqli_num_rows($query_verifica);

			if($num_verifica > 0){
				$sql_deleta = "DELETE FROM tb_curtida_vaga WHERE id_curtida_vaga = '$vagaCurtida' AND id_autor_curtida_vaga = '$autor'";
				$query_deleta = mysqli_query($mysqli, $sql_deleta);
			}else{
				$sql_insere = "INSERT INTO tb_curtida_vaga VALUES (null, '$autor', '$vagaCurtida', '$autorDaVaga', NOW())";
				$query_insere = mysqli_query($mysqli, $sql_insere);
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>