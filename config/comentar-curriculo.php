<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['autor']) AND isset($_POST['curriculoComentado']) AND isset($_POST['desc-comentario'])){
		if(empty($_POST['autor']) OR empty($_POST['curriculoComentado']) OR empty($_POST['desc-comentario'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-comentario-curriculo").removeClass("alert-success");
				$("#alerta-comentario-curriculo").addClass("alert-danger");
			</script>
			<?php
		}else{
			$comentado = $_POST['curriculoComentado'];
			$autor = $_POST['autor'];
			$comentario = $_POST['desc-comentario'];

			$sql_curriculo_comentado = "SELECT * FROM tb_curriculo WHERE cd_curriculo = '$comentado'";
			$query_curriculo_comentado = mysqli_query($mysqli, $sql_curriculo_comentado);
			$row_curriculo_comentado = mysqli_fetch_assoc($query_curriculo_comentado);
			$autorDoCurriculo = $row_curriculo_comentado['id_autor_curriculo'];

			$sql_comenta = "INSERT INTO tb_comentario_curriculo VALUES (null, '$comentario', '$autor', '$comentado', '$autorDoCurriculo', NOW())";
			if($resultado_comenta = $mysqli->query($sql_comenta)){
				echo "Comentário postado com sucesso!";
				?>
				<script>
					$("#alerta-comentario-curriculo").removeClass("alert-danger");
					$("#alerta-comentario-curriculo").addClass("alert-success");
					$("#desc-comentario").attr('disabled', '');
					$("#btn-cofirmar-comentario-curriculo").attr('disabled', '');
					$("#modal-comentario-curriculo").delay(2000).fadeOut();
					setTimeout(function() {
						window.location.reload(1);
					}, 2000);
				</script>
				<?php	
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-comentario-curriculo").removeClass("alert-success");
					$("#alerta-comentario-curriculo").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}

?>