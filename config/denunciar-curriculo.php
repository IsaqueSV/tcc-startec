<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['curriculoDenunciado']) AND isset($_POST['desc-denuncia'])){
		if(empty($_POST['autor']) OR empty($_POST['curriculoDenunciado']) OR empty($_POST['desc-denuncia']) OR empty($_POST['select-denuncia'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-denuncia-curriculo").removeClass("alert-success");
				$("#alerta-denuncia-curriculo").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['curriculoDenunciado'];
			$descricao = $_POST['desc-denuncia'];
			$select = $_POST['select-denuncia'];

			$sql_curriculo_denunciado = "SELECT * FROM tb_curriculo WHERE cd_curriculo = '$denunciado'";
			$query_curriculo_denunciado = mysqli_query($mysqli, $sql_curriculo_denunciado);
			$row_curriculo_denunciado = mysqli_fetch_assoc($query_curriculo_denunciado);
			$autorDoCurriculo = $row_curriculo_denunciado['id_autor_curriculo'];

			$sql = "INSERT INTO tb_denuncia_curriculo VALUES (null, '$descricao', '$select', '$autor', '$denunciado', '$autorDoCurriculo', NOW())";
			if($resultado = $mysqli->query($sql)){
				$sql_denuncias = "SELECT * FROM tb_denuncia_curriculo WHERE id_denuncia_curriculo = '$denunciado'";
				if($query_denuncias = $mysqli->query($sql_denuncias)){
					echo "Denuncia realizada com sucesso!";
					?>
					<script>
						$("#alerta-denuncia-curriculo").removeClass("alert-danger");
						$("#alerta-denuncia-curriculo").addClass("alert-success");
						$("#desc-denuncia-hab").attr('disabled', '');
						$("#select-denuncia-hab").attr('disabled', '');
						$("#btn-cofirmar-denuncia-curriculo").attr('disabled', '');
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
						$("#alerta-denuncia-curriculo").removeClass("alert-success");
						$("#alerta-denuncia-curriculo").addClass("alert-danger");
					</script>
					<?php
				}
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-denuncia-curriculo").removeClass("alert-success");
					$("#alerta-denuncia-curriculo").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>