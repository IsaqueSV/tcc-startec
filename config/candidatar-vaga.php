<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
		
	if(isset($_POST['autor']) AND isset($_POST['vagaCandidato'])){
		if(empty($_POST['autor']) OR empty($_POST['vagaCandidato'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela").removeClass("alert-success");
				$("#alerta-cancela").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$vagaCandidato = $_POST['vagaCandidato'];
			$autor_vaga = $_POST['autorVaga'];

			$sql_verifica = "SELECT * FROM tb_candidato WHERE id_vaga = '$vagaCandidato' AND id_candidato = '$autor'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$num_verifica = mysqli_num_rows($query_verifica);

			if($num_verifica > 0){
				$sql_deleta = "DELETE FROM tb_candidato WHERE id_vaga = '$vagaCandidato' AND id_candidato = '$autor'";
				$query_deleta = mysqli_query($mysqli, $sql_deleta);
			}else{
				$sql_insere = "INSERT INTO tb_candidato VALUES (null, '$autor', '$vagaCandidato', '$autor_vaga', NOW())";
				$query_insere = mysqli_query($mysqli, $sql_insere);
			}
		}
	}else{
		header('Location: ../index.php');
	}

?>