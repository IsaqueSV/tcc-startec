<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['usuarioPesquisado'])){
		if(empty($_POST['autor']) OR empty($_POST['usuarioPesquisado'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela").removeClass("alert-success");
				$("#alerta-cancela").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['usuarioPesquisado'];

			$sql_deleta = "DELETE FROM tb_denuncia_usuario WHERE id_denuncia_usuario = '$denunciado' AND id_autor_denuncia_usuario = '$autor'";
			if($resultado = $mysqli->query($sql_deleta)){
				echo "Denuncia deletada com sucesso!";
				?>
				<script>
					$("#alerta-cancela").removeClass("alert-danger");
					$("#alerta-cancela").addClass("alert-success");
					$("#btn-cancelar-denuncia").attr('disabled', '');
					$("#denuncia").delay(2000).fadeOut();
					
				</script>
				<?php
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-cancela").removeClass("alert-success");
					$("#alerta-cancela").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>