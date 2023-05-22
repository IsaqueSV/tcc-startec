<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['comentarioEdita']) AND isset($_POST['comentario'])){
		if(empty($_POST['autor']) OR empty($_POST['comentarioEdita']) OR empty($_POST['comentario'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-resultado-comentario-curriculo").removeClass("alert-success");
				$("#alerta-resultado-comentario-curriculo").removeClass("alert-warning");
				$("#alerta-resultado-comentario-curriculo").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$comentarioEdita = $_POST['comentarioEdita'];
			$comentario = $_POST['comentario'];

			$sql_verifica = "SELECT * FROM tb_comentario_curriculo WHERE cd_comentario_curriculo = '$comentarioEdita' AND id_autor_comentario_curriculo = '$autor'";
			$query_verifica = mysqli_query($mysqli, $sql_verifica);
			$row_verifica = mysqli_fetch_assoc($query_verifica);

			if($comentario == $row_verifica['ds_comentario_curriculo']){
				echo "Para que o comentário seja alterado é necessário que você escreva algo diferente";
				?>
				<script>
					$("#alerta-resultado-comentario-curriculo").removeClass("alert-success");
					$("#alerta-resultado-comentario-curriculo").removeClass("alert-danger");
					$("#alerta-resultado-comentario-curriculo").addClass("alert-warning");
				</script>
				<?php
			}else{
				$sql_comentario = "UPDATE tb_comentario_curriculo SET ds_comentario_curriculo = '$comentario' WHERE cd_comentario_curriculo = '$comentarioEdita' AND id_autor_comentario_curriculo = '$autor'";
				if($resultado_comentario = $mysqli->query($sql_comentario)){
					$mysqli->query("UPDATE tb_comentario_curriculo SET created_comentario_curriculo = NOW() WHERE cd_comentario_curriculo = '$comentarioEdita' AND id_autor_comentario_curriculo = '$autor'");

					echo "Comentário atualizado com sucesso!";
					?>
					<script>
						$("#alerta-resultado-comentario-curriculo").removeClass("alert-danger");
						$("#alerta-resultado-comentario-curriculo").removeClass("alert-warning");
						$("#alerta-resultado-comentario-curriculo").addClass("alert-success");
						$("#btn-fecha-edita-comentario-curriculo").attr('disabled', '');
						$("#btn-deletar-edita-comentario-curriculo").attr('disabled', '');
						$("#btn-confirma-edita-comentario-curriculo").attr('disabled', '');
						$("#comentario").attr('disabled', '');
						$("#modal-edita-comentario-curriculo").delay(2000).fadeOut();
						setTimeout(function() {
							window.location.reload(1);
						}, 2000);
					</script>
					<?php
				}else{
					echo "Ocorreu um erro!";
					?>
					<script>
						$("#alerta-resultado-comentario-curriculo").removeClass("alert-success");
						$("#alerta-resultado-comentario-curriculo").removeClass("alert-warning");
						$("#alerta-resultado-comentario-curriculo").addClass("alert-danger");
					</script>
					<?php
				}
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>