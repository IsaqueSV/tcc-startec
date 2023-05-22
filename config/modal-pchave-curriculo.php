<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['idPchaveCurriculo'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['idPchaveCurriculo'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$idPchaveCurriculo = $_POST['idPchaveCurriculo'];		
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
		#pchave-curriculo{ 
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
		$("#btn-fecha-pchave-curriculo").click(function(){
			$("#pchave-curriculo").fadeOut();
		});
	});
	</script>
</head>
<body>
</body>
</html>

<?php 
	include('../banco/conexao.php');
	$sql_pchave_curriculo = "SELECT * FROM tb_pchave_curriculo WHERE cd_pchave_curriculo = '$idPchaveCurriculo'";
	$query_pchave_curriculo = mysqli_query($mysqli, $sql_pchave_curriculo);
	$row_pchave_curriculo = mysqli_fetch_assoc($query_pchave_curriculo);

	echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>".$row_pchave_curriculo['nm_pchave_curriculo']."</h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-pchave-curriculo'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='mb-3'>
							<label for='desc-pchave-curriculo' class='form-label'>Descrição</label>
							<textarea class='form-control' id='desc-pchave-curriculo' rows='4' placeholder='".$row_pchave_curriculo['ds_pchave_curriculo']."' style='background-color: #F0F0F0;' disabled></textarea>
						</div>
					</div>
				</div>";
?>