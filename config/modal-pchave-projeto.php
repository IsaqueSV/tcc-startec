<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idPchaveProjeto'])){
		if(empty($_POST['idPchaveProjeto'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		
			}
			$idPchaveProjeto = $_POST['idPchaveProjeto'];	
		}
	}else{
		header('Location: ../index.php');
	}

	$sql_projetos = "SELECT * FROM tb_projeto WHERE id_pchave_projeto = '$idPchaveProjeto'";
	$query_projetos = mysqli_query($mysqli, $sql_projetos);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		button#pchave{
			transition: 0.5s ease;
		}

		#pchave-projeto{ 
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
		$("#btn-fecha-pchave-projeto").click(function(){
			$("#pchave-projeto").fadeOut();
		});
	});
	</script>
</head>
<body>
</body>
</html>

<?php 
	include('../banco/conexao.php');
	$sql_pchave_projeto = "SELECT * FROM tb_pchave_projeto WHERE cd_pchave_projeto = '$idPchaveProjeto'";
	$query_pchave_projeto = mysqli_query($mysqli, $sql_pchave_projeto);
	$row_pchave_projeto = mysqli_fetch_assoc($query_pchave_projeto);

	$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>".$row_pchave_projeto['nm_pchave_projeto']."</h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-pchave-projeto'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='mb-3'>
							<label for='desc-pchave-projeto' class='form-label'>Descrição</label>
							<textarea class='form-control' id='desc-pchave-projeto' rows='4' placeholder='".$row_pchave_projeto['ds_pchave_projeto']."' style='background-color: #F0F0F0;' disabled></textarea>
						</div>
					</div>
					<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
						<label style='margin-bottom: 1%;'>Projetos relacionados</label><br>
						<div class='spans'>";
							while($row_projetos = mysqli_fetch_assoc($query_projetos)){
							   	$modal.="<a href='projetos.php?see=".$row_projetos['ds_url_projeto']." '><button id='pchave' style='border-radius: 10px; color: black; background-color: #F0F0F0; margin-right: 1%; margin-bottom: 1%; border: 1px solid #DCDCDC;' type='button' class='btn btn-light'>".$row_projetos['nm_projeto']."</button></a>";
					    	}
			$modal .= "</div>
			</div>
			</div>
		</div>";

	echo $modal;
?>