<?php
	include('../banco/conexao.php');
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	if(isset($_SESSION['cdUsuario']) AND isset($_POST['select-pesquisa']) AND isset($_POST['text-pesquisa'])){
		$cdUsuario = $_SESSION['cdUsuario'];
		$idNivel = $_SESSION['idNivel'];
		$select = $_POST['select-pesquisa'];
		$pesquisa = $_POST['text-pesquisa'];		
	}else{
		header('Location: ../index.php');
	}

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
			$("#modal-pesquisa-vaga").fadeOut();
			
			$("tr").click(function(){
				$vagaPesquisada = $(this).attr('id');

				window.location.href = "vagas.php?see="+$vagaPesquisada;
			});
		});
	</script>

	<style>
		table{
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}
		tr.vaga{
			cursor: pointer;
			color: white;
			background-color: #2a3550;
			transition: 1s ease;
		}
		tr.vaga:hover{
			opacity: 70%;
			transition: 1s ease;
		}

	</style>
</head>
</html>
<?php

	if($idNivel === 2){
		if($pesquisa === ""){
			if($select === ""){
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}else{
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' AND id_pchave_vaga = '$select' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}
		}else{
			if($select === ""){
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' AND nm_vaga like '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}else{
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' AND id_pchave_vaga = '$select' AND nm_vaga like '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}
		}
		?>
		<script>
			$("#resultado").show();
		</script>
		<?php
	}else{
		if($pesquisa === ""){
			if($select === ""){
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}else{
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}
		}else{
			if($select === ""){
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE nm_vaga like '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}else{
				$sql_pesquisa = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' AND nm_vaga like '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado_pesquisa = mysqli_query($mysqli, $sql_pesquisa);
				$num_pesquisa = mysqli_num_rows($resultado_pesquisa);

				if($num_pesquisa > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado_pesquisa)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>
					<?php
				}else{
					echo "Vaga não encontrada";
				}
			}
		}
		?>
		<script>
			$("#resultado").show();
		</script>
		<?php
	}
	/*
	if($idNivel == 2){
		if($pesquisa == ""){
			if($select == ""){
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);
				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Vaga não encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}else{
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' AND id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
							<?php
								while($row = mysqli_fetch_array($resultado)){
									?>
										<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
											<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
											<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Não há nenhuma vaga com a tag pesquisada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}
		}else{
			if($select == ""){
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE nm_vaga LIKE '%$pesquisa%' AND id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody class="myTable">
							<?php
								while($row = mysqli_fetch_array($resultado)){
									?>
										<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
											<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
											<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Nenhuma vaga foi encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}else{
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' AND nm_vaga LIKE '%$pesquisa%' AND id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['cd_usuario']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Nenhuma vaga foi encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}
		}
	}else{
		if($pesquisa == ""){
			if($select == ""){
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);
				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_contato_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Vaga não encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}else{
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
							<?php
								while($row = mysqli_fetch_array($resultado)){
									?>
										<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
											<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
											<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Não há nenhuma vaga com a tag pesquisada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}
		}else{
			if($select == ""){
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE nm_vaga LIKE '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody class="myTable">
							<?php
								while($row = mysqli_fetch_array($resultado)){
									?>
										<tr class="vaga" id="<?php echo $row['ds_url_vaga']; ?>">
											<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
											<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
											<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Nenhuma vaga foi encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}else{
				$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_pchave_vaga = '$select' AND nm_vaga LIKE '%$pesquisa%' ORDER BY cd_vaga DESC";
				$resultado = mysqli_query($mysqli, $sql);
				$num = mysqli_num_rows($resultado);

				if($num > 0){
					?>
					<table>
						<tbody id="myTable">
								<?php
								while($row = mysqli_fetch_array($resultado)){	
								?>
									
									<tr class="vaga" id="<?php echo $row['cd_usuario']; ?>">
										<td class="vaga"><?php echo $row['nm_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_pchave_vaga']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['nm_usuario']; ?></td>
										<td style="text-align: center;" class="vaga"><?php echo $row['ds_email']; ?></td>
										<td style="text-align: right;" class="vaga"><?php echo date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></td>
									</tr>
									
								<?php
								}
								?>
						</tbody>
					</table>

					<script>
						$("#resultado").show();
					</script>
					<?php
				}else{
					echo "Nenhuma vaga foi encontrada";
					?>
					<script>
						$("#resultado").show();
					</script>
					<?php
				}
			}
		}
	}
	*/
?>