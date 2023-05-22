<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['projetoDenunciado'])){
		if(empty($_POST['autor']) OR empty($_POST['projetoDenunciado'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela-projeto").removeClass("alert-success");
				$("#alerta-cancela-projeto").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['projetoDenunciado'];

			$sql_deleta = "DELETE FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '$denunciado' AND id_autor_denuncia_projeto = '$autor'";
			if($resultado = $mysqli->query($sql_deleta)){
				echo "Denuncia deletada com sucesso!";
				?>
				<script>
					$("#alerta-cancela-projeto").removeClass("alert-danger");
					$("#alerta-cancela-projeto").addClass("alert-success");
					$("#btn-cancelar-denuncia-projeto").attr('disabled', '');
					$("#denuncia-projeto").delay(2000).fadeOut();
						setTimeout(function() {
							window.location.reload(1);
						}, 2000);
				</script>
				<?php
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-cancela-projeto").removeClass("alert-success");
					$("#alerta-cancela-projeto").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>