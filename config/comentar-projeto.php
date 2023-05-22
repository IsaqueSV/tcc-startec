<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
		if(isset($_POST['autor']) AND isset($_POST['projetoComentado']) AND isset($_POST['desc-comentario'])){
			if(empty($_POST['autor']) OR empty($_POST['projetoComentado']) OR empty($_POST['desc-comentario'])){
				?>
				<script>
					history.go(-1);
				</script>
				<?php
			}else{
				$comentado = $_POST['projetoComentado'];
				$autor = $_POST['autor'];
				$comentario = $_POST['desc-comentario'];

				$sql_projeto_comentado = "SELECT * FROM tb_projeto WHERE cd_projeto = '$comentado'";
				$query_projeto_comentado = mysqli_query($mysqli, $sql_projeto_comentado);
				$row_projeto_comentado = mysqli_fetch_assoc($query_projeto_comentado);
				$autorDoProjeto = $row_projeto_comentado['id_autor_projeto'];

				$sql_comenta = "INSERT INTO tb_comentario_projeto VALUES (null, '$comentario', '$autor', '$comentado', '$autorDoProjeto', NOW())";
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