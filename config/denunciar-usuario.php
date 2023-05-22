<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['autor']) AND isset($_POST['usuarioPesquisado']) AND isset($_POST['desc-denuncia'])){
		if(empty($_POST['autor']) OR empty($_POST['usuarioPesquisado']) OR empty($_POST['desc-denuncia']) OR empty($_POST['select-denuncia'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-denuncia").removeClass("alert-success");
				$("#alerta-denuncia").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['usuarioPesquisado'];
			$descricao = $_POST['desc-denuncia'];
			$select = $_POST['select-denuncia'];
			
			$sql = "INSERT INTO tb_denuncia_usuario VALUES (null, '$descricao', '$select', '$autor', '$denunciado', NOW())";
			if($resultado = $mysqli->query($sql)){
					echo "Denuncia realizada com sucesso!";
					?>
					<script>
						$("#alerta-denuncia").removeClass("alert-danger");
						$("#alerta-denuncia").addClass("alert-success");
						$("#desc-denuncia-hab").attr('disabled', '');
						$("#select-denuncia-hab").attr('disabled', '');
						$("#btn-cofirmar-denuncia").attr('disabled', '');
						$("#denuncia").delay(2000).fadeOut();
					</script>
					<?php	
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-denuncia").removeClass("alert-success");
					$("#alerta-denuncia").addClass("alert-danger");
					$("#desc-denuncia-hab").attr('disabled', '');
					$("#select-denuncia-hab").attr('disabled', '');
					$("#btn-cofirmar-denuncia").attr('disabled', '');
					$("#denuncia").delay(2000).fadeOut();
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>