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
			$("#modal-pesquisa-curriculo").fadeOut();
			
			$("tr").click(function(){
				$curriculoPesquisado = $(this).attr('id');

				window.location.href = "curriculos.php?see="+$curriculoPesquisado;
			});

		});
	</script>
	<style>
		table{
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}
		tr.curriculo{
			cursor: pointer;
			color: white;
			background-color: #2a3550;
			transition: 1s ease;
		}
		tr.curriculo:hover{
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
	
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_POST['select-pesquisa']) AND isset($_POST['text-pesquisa'])){
		if(isset($_SESSION['cdUsuario'])){
			$cdUsuario = $_SESSION['cdUsuario'];
		}
		if($_POST['select-pesquisa'] === " "){
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
			$sql_pesquisa = "SELECT * FROM tb_curriculo INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo ORDER BY cd_curriculo DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_curriculo INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo WHERE id_pchave_curriculo = '$select' ORDER BY cd_curriculo DESC";
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
								<tr class="curriculo" id="<?php echo $row['ds_url_curriculo']; ?>">
									<td class="curriculo"><?php echo $row['nm_completo_curriculo']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['nm_pchave_curriculo']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['ds_contato_email']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['ds_cargo']; ?></td>
									<td style="text-align: right;" class="curriculo"><?php echo date("d/m/Y H:i", strtotime($row['created_curriculo'])); ?></td>
								</tr>
							<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Currículo não encontrado";
		}
	}else{
		if($select === 0){
			$sql_pesquisa = "SELECT * FROM tb_curriculo INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo WHERE nm_completo_curriculo LIKE '%$pesquisa%' ORDER BY cd_curriculo DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_curriculo INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo WHERE nm_completo_curriculo LIKE '%$pesquisa%' AND id_pchave_curriculo = '$select' ORDER BY cd_curriculo DESC";
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
								<tr class="curriculo" id="<?php echo $row['ds_url_curriculo']; ?>">
									<td class="curriculo"><?php echo $row['nm_completo_curriculo']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['nm_pchave_curriculo']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['ds_contato_email']; ?></td>
									<td style="text-align: center;" class="curriculo"><?php echo $row['ds_cargo']; ?></td>
									<td style="text-align: right;" class="curriculo"><?php echo date("d/m/Y H:i", strtotime($row['created_curriculo'])); ?></td>
								</tr>	
							<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Currículo não encontrado";
		}
	}

	?>
	<script>
		$("#resultado").show();
	</script>
	<?php
?>