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
			$("#modal").fadeOut();
			
			$("tr").click(function(){
				$usuarioPesquisado = $(this).attr('id');

				$.ajax({
						url: "config/modal-usuario.php",
						type: "POST",
						data: "usuarioPesquisado="+$usuarioPesquisado,
						dataType: "html"
					}).done(function(resposta){
						$("#modal").html(resposta);
						$("#modal").fadeIn();

					}).fail(function(jqXHR, textStatus ){
						console.log("Request failed: " + textStatus);
						$("#modal").fadeOut();

					}).always(function(){
						console.log("completou");
					});
				});
		});
	</script>
	<style>
		table{
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}
		tr.user{
			cursor: pointer;
			color: white;
			background-color: #2a3550;
			transition: 1s ease;
		}
		tr.user:hover{
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
		if($_POST['select-pesquisa'] == " "){
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
			$sql_pesquisa = "SELECT * FROM tb_usuario INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE NOT id_nivel = '3' ORDER BY cd_usuario DESC";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_usuario INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE id_nivel = '$select' ORDER BY cd_usuario DESC";
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
									<tr class="user" id="<?php echo $row['cd_usuario']; ?>">
										<td class="user"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: justify;" class="user"><?php echo $row['nm_completo']; ?></td>
										<td style="text-align: justify;" class="user"><?php echo $row['ds_email']; ?></td>
										<td style="text-align: right;" class="user"><?php echo $row['nm_nivel']; ?></td>
									</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Usuário não encontrado";
		}
	}else{
		if($select === 0){
			$sql_pesquisa = "SELECT * FROM tb_usuario INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE NOT id_nivel = '3' AND nm_usuario LIKE '%$pesquisa%'";
			$query_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
		}else{
			$sql_pesquisa = "SELECT * FROM tb_usuario INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE id_nivel = '$select' AND nm_usuario LIKE '%$pesquisa%'";
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
									<tr class="user" id="<?php echo $row['cd_usuario']; ?>">
										<td class="user"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: justify;" class="user"><?php echo $row['nm_completo']; ?></td>
										<td style="text-align: justify;" class="user"><?php echo $row['ds_email']; ?></td>
										<td style="text-align: right;" class="user"><?php echo $row['nm_nivel']; ?></td>
									</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}else{
			echo "Usuário não encontrado";
		}
	}
	?>
	<script>
		$("#resultado").show();
	</script>
	<?php
?>