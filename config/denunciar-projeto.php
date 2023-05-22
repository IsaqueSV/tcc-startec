<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	if(isset($_POST['autor']) AND isset($_POST['projetoDenunciado']) AND isset($_POST['desc-denuncia']) AND isset($_POST['select-denuncia'])){
		if(empty($_POST['autor']) OR empty($_POST['projetoDenunciado']) OR empty($_POST['desc-denuncia']) OR empty($_POST['select-denuncia'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-denuncia-projeto").removeClass("alert-success");
				$("#alerta-denuncia-projeto").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['projetoDenunciado'];
			$descricao = $_POST['desc-denuncia'];
			$select = $_POST['select-denuncia'];
			
			$sql_projeto_denunciado = "SELECT * FROM tb_projeto WHERE cd_projeto = '$denunciado'";
			$query_projeto_denunciado = mysqli_query($mysqli, $sql_projeto_denunciado);
			$row_projeto_denunciado = mysqli_fetch_assoc($query_projeto_denunciado);
			$autorDoProjeto = $row_projeto_denunciado['id_autor_projeto'];

			$sql = "INSERT INTO tb_denuncia_projeto VALUES (null, '$descricao', '$select', '$autor', '$denunciado', '$autorDoProjeto', NOW())";
			if($resultado = $mysqli->query($sql)){
				$sql_denuncias = "SELECT * FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '$denunciado'";
				if($query_denuncias = $mysqli->query($sql_denuncias)){
					echo "Denuncia realizada com sucesso!";
					?>
					<script>
						$("#alerta-denuncia-projeto").removeClass("alert-danger");
						$("#alerta-denuncia-projeto").addClass("alert-success");
						$("#desc-denuncia-hab").attr('disabled', '');
						$("#select-denuncia-hab").attr('disabled', '');
						$("#btn-cofirmar-denuncia-projeto").attr('disabled', '');
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
						$("#alerta-denuncia-projeto").removeClass("alert-success");
						$("#alerta-denuncia-projeto").addClass("alert-danger");
					</script>
					<?php
				}
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-denuncia-projeto").removeClass("alert-success");
					$("#alerta-denuncia-projeto").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>