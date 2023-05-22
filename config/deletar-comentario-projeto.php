<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['comentarioEdita'])){
		if(empty($_POST['autor']) OR empty($_POST['comentarioEdita'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-resultado-comentario-projeto").removeClass("alert-success");
				$("#alerta-resultado-comentario-projeto").removeClass("alert-warning");
				$("#alerta-resultado-comentario-projeto").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$comentarioEdita = $_POST['comentarioEdita'];

			$sql_deleta = "DELETE FROM tb_comentario_projeto WHERE cd_comentario_projeto = '$comentarioEdita' AND id_autor_comentario_projeto = '$autor'";
			if($resultado_deleta = $mysqli->query($sql_deleta)){
				echo "Comentário deletado com sucesso!";
				?>
				<script>
					$("#alerta-resultado-comentario-projeto").removeClass("alert-danger");
					$("#alerta-resultado-comentario-projeto").removeClass("alert-warning");
					$("#alerta-resultado-comentario-projeto").addClass("alert-success");
					$("#btn-fecha-edita-comentario-projeto").attr('disabled', '');
					$("#btn-deletar-edita-comentario-projeto").attr('disabled', '');
					$("#btn-confirma-edita-comentario-projeto").attr('disabled', '');
					$("#comentario").attr('disabled', '');
					$("#modal-edita-comentario-projeto").delay(2000).fadeOut();
					setTimeout(function() {
					  window.location.reload(1);
					}, 2000);
				</script>
				<?php
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-resultado-comentario-projeto").removeClass("alert-success");
					$("#alerta-resultado-comentario-projeto").removeClass("alert-warning");
					$("#alerta-resultado-comentario-projeto").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>