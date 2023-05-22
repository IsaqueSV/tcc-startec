<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['vagaDenunciada'])){
		if(empty($_POST['autor']) OR empty($_POST['vagaDenunciada'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-cancela-vaga").removeClass("alert-success");
				$("#alerta-cancela-vaga").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['vagaDenunciada'];

			$sql_deleta = "DELETE FROM tb_denuncia_vaga WHERE id_denuncia_vaga = '$denunciado' AND id_autor_denuncia_vaga = '$autor'";
			if($resultado = $mysqli->query($sql_deleta)){
				echo "Denuncia deletada com sucesso!";
				?>
				<script>
					$("#alerta-cancela-vaga").removeClass("alert-danger");
					$("#alerta-cancela-vaga").addClass("alert-success");
					$("#btn-cancelar-denuncia-vaga").attr('disabled', '');
					$("#denuncia-vaga").delay(2000).fadeOut();
						setTimeout(function() {
							window.location.reload(1);
						}, 2000);
				</script>
				<?php
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-cancela-vaga").removeClass("alert-success");
					$("#alerta-cancela-vaga").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>