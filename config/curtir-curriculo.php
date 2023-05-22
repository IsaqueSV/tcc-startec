<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['curriculoCurtido'])){
		if(empty($_POST['autor']) OR empty($_POST['curriculoCurtido'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela").removeClass("alert-success");
				$("#alerta-cancela").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$curriculoCurtido = $_POST['curriculoCurtido'];

			$sql_curriculo_curtido = "SELECT * FROM tb_curriculo WHERE cd_curriculo = '$curriculoCurtido'";
			$query_curriculo_curtido = mysqli_query($mysqli, $sql_curriculo_curtido);
			$row_curriculo_curtido = mysqli_fetch_assoc($query_curriculo_curtido);
			$autorDoCurriculo = $row_curriculo_curtido['id_autor_curriculo'];

			$sql_verifica = "SELECT * FROM tb_curtida_curriculo WHERE id_curtida_curriculo = '$curriculoCurtido' AND id_autor_curtida_curriculo = '$autor'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$num_verifica = mysqli_num_rows($query_verifica);

			if($num_verifica > 0){
				$sql_deleta = "DELETE FROM tb_curtida_curriculo WHERE id_curtida_curriculo = '$curriculoCurtido' AND id_autor_curtida_curriculo = '$autor'";
				$query_deleta = mysqli_query($mysqli, $sql_deleta);
			}else{
				$sql_insere = "INSERT INTO tb_curtida_curriculo VALUES (null, '$autor', '$curriculoCurtido', '$autorDoCurriculo', NOW())";
				$query_insere = mysqli_query($mysqli, $sql_insere);
			}
		}
	}else{
		header('Location: ../index.php');
	}
	
?>