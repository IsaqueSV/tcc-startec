<?php
	include('../banco/conexao.php');
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
	<!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
	<!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
	<!-- Jquery Mask <script src="css/local/js/jquery.mask.min.js"></script> -->
	<!-- CSS --><link rel="stylesheet" href="css/navbar.css">
	<!-- CSS --><link rel="stylesheet" href="css/geral.css">
	<!-- CSS --><link rel="stylesheet" href="css/footer.css">
	<script>
		$(document).ready(function(){
			$("#modal-pesquisa-projeto").fadeOut();
			
			$("tr").click(function(){
				$projetoPesquisado = $(this).attr('id');

				window.location.href = "projetos.php?see="+$projetoPesquisado;
			});

		});
	</script>
	<style>
		table{
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}
		tr.projeto{
			cursor: pointer;
			color: white;
			background-color: #2a3550;
			transition: 1s ease;
		}
		tr.projeto:hover{
			opacity: 70%;
			transition: 1s ease;
		}
	</style>
</head>
</html>
<?php 
	include('../banco/conexao.php');
	session_start();
	date_default_timezone_set('America/Sao_Paulo');

	if(isset($_POST['select-pesquisa']) AND isset($_POST['text-pesquisa'])){
		if(isset($_SESSION['cdUsuario'])){
			$cdUsuario = $_SESSION['cdUsuario'];
		}
		if($_POST['select-pesquisa'] == ""){
			$select = 0;
		}else{
			$select = $_POST['select-pesquisa'];
		}

		$pesquisa = $_POST['text-pesquisa'];	
	}else{
		header('Location: ../index.php');
	}

	if($pesquisa === ""){
		if($select === 0){
			$sql_pesquisa = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto ORDER BY cd_projeto DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto WHERE id_pchave_projeto = '$select' ORDER BY cd_projeto DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}

		$num_pesquisa = mysqli_num_rows($query_pesquisa);
		if($num_pesquisa > 0){
			?>
				<table>
					<tbody id="myTable">
						<?php
							while($row = mysqli_fetch_array($query_pesquisa)){
								?>
									<tr class="projeto" id="<?php echo $row['ds_url_projeto']; ?>">
										<td class="projeto"><?php echo $row['nm_projeto']; ?></td>
										<td style="text-align: center;" class="projeto"><?php echo $row['nm_pchave_projeto']; ?></td>
										<td style="text-align: center;" class="projeto"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="projeto"><?php echo $row['ds_email']; ?></td>
										<td style="text-align: right;" class="projeto"><?php echo date("d/m/Y H:i", strtotime($row['created_projeto'])); ?></td>
									</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Projeto não encontrado";
		}
	}else{
		if($select === 0){
			$sql_pesquisa = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto WHERE nm_projeto LIKE '%$pesquisa%' ORDER BY cd_projeto DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
			$num_pesquisa = mysqli_num_rows($query_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto WHERE nm_projeto LIKE '%$pesquisa%' AND id_pchave_projeto = '$select' ORDER BY cd_projeto DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
			$num_pesquisa = mysqli_num_rows($query_pesquisa);
		}

		if($num_pesquisa > 0){
			?>
				<table>
					<tbody id="myTable">
						<?php
							while($row = mysqli_fetch_array($query_pesquisa)){	
							?>
								<tr class="projeto" id="<?php echo $row['ds_url_projeto']; ?>">
									<td class="projeto"><?php echo $row['nm_projeto']; ?></td>
									<td style="text-align: center;" class="projeto"><?php echo $row['nm_pchave_projeto']; ?></td>
									<td style="text-align: center;" class="projeto"><?php echo $row['nm_usuario']; ?></td>
									<td style="text-align: center;" class="projeto"><?php echo $row['ds_email']; ?></td>
									<td style="text-align: right;" class="projeto"><?php echo date("d/m/Y H:i", strtotime($row['created_projeto'])); ?></td>
								</tr>
								
							<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Projeto não encontrado";
		}
	}

	?>
	<script>
		$("#resultado").show();
	</script>
	<?php
?>