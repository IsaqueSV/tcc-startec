<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['curriculoDenunciado'])){
		if(empty($_POST['autor']) OR empty($_POST['curriculoDenunciado'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela-curriculo").removeClass("alert-success");
				$("#alerta-cancela-curriculo").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['curriculoDenunciado'];

			$sql_deleta = "DELETE FROM tb_denuncia_curriculo WHERE id_denuncia_curriculo = '$denunciado' AND id_autor_denuncia_curriculo = '$autor'";
			if($resultado = $mysqli->query($sql_deleta)){
				echo "Denuncia deletada com sucesso!";
				?>
				<script>
					$("#alerta-cancela-curriculo").removeClass("alert-danger");
					$("#alerta-cancela-curriculo").addClass("alert-success");
					$("#btn-cancelar-denuncia-curriculo").attr('disabled', '');
					$("#denuncia-curriculo").delay(2000).fadeOut();
						setTimeout(function() {
							window.location.reload(1);
						}, 2000);
				</script>
				<?php
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-cancela-curriculo").removeClass("alert-success");
					$("#alerta-cancela-curriculo").addClass("alert-danger");
				</script>
				<?php
			}
		}	
	}else{
		header('Location: ../index.php');
	}
	
?>