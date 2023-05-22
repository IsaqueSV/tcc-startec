<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
		if(isset($_POST['autor']) AND isset($_POST['vagaComentada']) AND isset($_POST['desc-comentario'])){
			if(empty($_POST['autor']) OR empty($_POST['vagaComentada']) OR empty($_POST['desc-comentario'])){
				?>
				<script>
					history.go(-1);
				</script>
				<?php
			}else{
				$comentado = $_POST['vagaComentada'];
				$autor = $_POST['autor'];
				$comentario = $_POST['desc-comentario'];

				$sql_vaga_comentada = "SELECT * FROM tb_vaga WHERE cd_vaga = '$comentado'";
				$query_vaga_comentada = mysqli_query($mysqli, $sql_vaga_comentada);
				$row_vaga_comentada = mysqli_fetch_assoc($query_vaga_comentada);
				$autorDaVaga = $row_vaga_comentada['id_autor_vaga'];

				$sql_comenta = "INSERT INTO tb_comentario_vaga VALUES (null, '$comentario', '$autor', '$comentado', '$autorDaVaga', NOW())";
				if($resultado_comenta = $mysqli->query($sql_comenta)){
					echo "";	
				}else{
					?>
					<script>
						alert("Ocorreu um erro!");
						history.go(-1);
					</script>
					<?php
				}
			}
		}else{
			header('Location: ../index.php');
		}
	
?>