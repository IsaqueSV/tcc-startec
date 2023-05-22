<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['idPchaveVaga']) AND isset($_SESSION['idNivel'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['idPchaveVaga']) OR empty($_SESSION['idNivel'])){
			header('Location: ../index.php');	
		}else{
			$idPchaveVaga = $_POST['idPchaveVaga'];
			$cdUsuario = $_SESSION['cdUsuario'];
			$idUsuario = $_SESSION['idNivel'];		
		}
	}else{
		header('Location: ../index.php');
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		#pchave-vaga{ 
			background: rgb(49,149,179);
			background: linear-gradient(90deg, rgba(49,149,179,1) 0%, rgba(107,38,148,1) 80%, rgba(126,12,140,1) 100%);background: rgb(49,149,179);
			background: linear-gradient(90deg, rgba(49,149,179,1) 0%, rgba(107,38,148,1) 80%, rgba(126,12,140,1) 100%);
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			background-blend-mode: darken;
		}

		div.modal-content{
			border: 1px solid;
		}
	</style>
	<script>
	$(document).ready(function(){
		$("#btn-fecha-pchave-vaga").click(function(){
			$("#pchave-vaga").fadeOut();
		});
	});
	</script>
</head>
<body>
</body>
</html>

<?php 
	include('../banco/conexao.php');

	$sql_curriculos = "SELECT * FROM tb_curriculo WHERE id_pchave_curriculo = '$idPchaveVaga'";
	$query_curriculos = mysqli_query($mysqli, $sql_curriculos);

	$sql_pchave_curriculo = "SELECT * FROM tb_pchave_curriculo WHERE cd_pchave_curriculo = '$idPchaveVaga'";
	$query_pchave_curriculo = mysqli_query($mysqli, $sql_pchave_curriculo);
	$row_pchave_curriculo = mysqli_fetch_assoc($query_pchave_curriculo);

	if($idUsuario == 1){
		$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>".$row_pchave_curriculo['nm_pchave_curriculo']."</h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-pchave-vaga'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='mb-3'>
							<label for='desc-pchave-vaga' class='form-label'>Descrição</label>
							<textarea class='form-control' id='desc-pchave-vaga' rows='4' placeholder='".$row_pchave_curriculo['ds_pchave_curriculo']."' style='background-color: #F0F0F0;' disabled></textarea>
						</div>
					</div>";
		$modal .= "</div>
		</div>";

	}if($idUsuario == 2){
		$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>".$row_pchave_curriculo['nm_pchave_curriculo']."</h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-pchave-vaga'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='mb-3'>
							<label for='desc-pchave-vaga' class='form-label'>Descrição</label>
							<textarea class='form-control' id='desc-pchave-vaga' rows='4' placeholder='".$row_pchave_curriculo['ds_pchave_curriculo']."' style='background-color: #F0F0F0;' disabled></textarea>
						</div>
					</div>
					<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
						<label style='margin-bottom: 1%;'>Curriculos relacionados</label><br>
						<div class='spans'>";
							while($row_curriculos = mysqli_fetch_assoc($query_curriculos)){
							   	$modal.="<a href='curriculos.php?see=".$row_curriculos['ds_url_curriculo']." '><button id='pchave' style='border-radius: 10px; color: black; background-color: #F0F0F0; margin-right: 1%; margin-bottom: 1%; border: 1px solid #DCDCDC;' type='button' class='btn btn-light'>".$row_curriculos['nm_completo_curriculo']."</button></a>";
					    	}
			$modal .= "</div>
			</div>
			</div>
		</div>";
	
	}
	
	echo $modal;
?>