<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_POST['autor']) AND isset($_POST['vagaDenunciada']) AND isset($_POST['desc-denuncia']) AND isset($_POST['select-denuncia'])){
		if(empty($_POST['autor']) OR empty($_POST['vagaDenunciada']) OR empty($_POST['desc-denuncia']) OR empty($_POST['select-denuncia'])){
			echo "Preencha todos os dados";
			?>
			<script>
				$("#alerta-denuncia-vaga").removeClass("alert-success");
				$("#alerta-denuncia-vaga").addClass("alert-danger");
			</script>
			<?php
		}else{
			$autor = $_POST['autor'];
			$denunciado = $_POST['vagaDenunciada'];
			$descricao = $_POST['desc-denuncia'];
			$select = $_POST['select-denuncia'];
			
			$sql_vaga_denunciada = "SELECT * FROM tb_vaga WHERE cd_vaga = '$denunciado'";
			$query_vaga_denunciada = mysqli_query($mysqli, $sql_vaga_denunciada);
			$row_vaga_denunciada = mysqli_fetch_assoc($query_vaga_denunciada);
			$autorDaVaga = $row_vaga_denunciada['id_autor_vaga'];

			$sql = "INSERT INTO tb_denuncia_vaga VALUES (null, '$descricao', '$select', '$autor', '$denunciado', '$autorDaVaga', NOW())";
			if($resultado = $mysqli->query($sql)){
				$sql_denuncias = "SELECT * FROM tb_denuncia_vaga WHERE id_denuncia_vaga = '$denunciado'";
				if($query_denuncias = $mysqli->query($sql_denuncias)){
					echo "Denuncia realizada com sucesso!";
					?>
					<script>
						$("#alerta-denuncia-vaga").removeClass("alert-danger");
						$("#alerta-denuncia-vaga").addClass("alert-success");
						$("#desc-denuncia-hab").attr('disabled', '');
						$("#select-denuncia-hab").attr('disabled', '');
						$("#btn-cofirmar-denuncia-vaga").attr('disabled', '');
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
						$("#alerta-denuncia-vaga").removeClass("alert-success");
						$("#alerta-denuncia-vaga").addClass("alert-danger");
					</script>
					<?php
				}
			}else{
				echo "Ocorreu um erro!";
				?>
				<script>
					$("#alerta-denuncia-vaga").removeClass("alert-success");
					$("#alerta-denuncia-vaga").addClass("alert-danger");
				</script>
				<?php
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>