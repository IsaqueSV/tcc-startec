<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idDenuncia'])){
		if(empty($_POST['idDenuncia'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		

				if($idNivel != 3){
					header('Location: ../index.php');
				}
				$idDenuncia = $_POST['idDenuncia'];
				$nivelMotivo = $_POST['nivelMotivo'];
			}
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
		#modal-visualizar-motivo-adm{ 
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
		$("#btn-fecha-modal-visualizar-motivo-adm").click(function(){
			$("#modal-visualizar-motivo-adm").fadeOut();
		});
	});

	</script>
</head>
<body>
</body>
</html>
<?php
	if($nivelMotivo == 1){
		// usuario

		$sql_denuncia = "SELECT * FROM tb_denuncia_usuario INNER JOIN tb_pchave_denuncia ON tb_denuncia_usuario.id_pchave_denuncia_usuario = tb_pchave_denuncia.cd_pchave_denuncia WHERE cd_denuncia_usuario = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-visualizar-motivo-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<div class='mb-3'>
									<textarea class='form-control' id='desc-pchave-projeto' rows='4' placeholder='".$row_denuncia['ds_denuncia_usuario']."' style='background-color: #F0F0F0; color: black;' disabled></textarea>
									<select style='margin-top: 1.5%; color: gray;' class='form-select' id='select-denuncia' disabled>
						    			<option value='".$row_denuncia['cd_pchave_denuncia']."' selected>".$row_denuncia['nm_pchave_denuncia']."</option>
									</select>
								</div>

							</div>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 2){
		// projeto

		$sql_denuncia = "SELECT * FROM tb_denuncia_projeto INNER JOIN tb_pchave_denuncia ON tb_denuncia_projeto.id_pchave_denuncia_projeto = tb_pchave_denuncia.cd_pchave_denuncia WHERE cd_denuncia_projeto = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-visualizar-motivo-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<div class='mb-3'>
									<textarea class='form-control' id='desc-pchave-projeto' rows='4' placeholder='".$row_denuncia['ds_denuncia_projeto']."' style='background-color: #F0F0F0; color: black;' disabled></textarea>
									<select style='margin-top: 1.5%; color: gray;' class='form-select' id='select-denuncia' disabled>
						    			<option value='".$row_denuncia['cd_pchave_denuncia']."' selected>".$row_denuncia['nm_pchave_denuncia']."</option>
									</select>
								</div>

							</div>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 3){
		// curriculo

		$sql_denuncia = "SELECT * FROM tb_denuncia_curriculo INNER JOIN tb_pchave_denuncia ON tb_denuncia_curriculo.id_pchave_denuncia_curriculo = tb_pchave_denuncia.cd_pchave_denuncia WHERE cd_denuncia_curriculo = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-visualizar-motivo-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<div class='mb-3'>
									<textarea class='form-control' id='desc-pchave-projeto' rows='4' placeholder='".$row_denuncia['ds_denuncia_curriculo']."' style='background-color: #F0F0F0; color: black;' disabled></textarea>
									<select style='margin-top: 1.5%; color: gray;' class='form-select' id='select-denuncia' disabled>
						    			<option value='".$row_denuncia['cd_pchave_denuncia']."' selected>".$row_denuncia['nm_pchave_denuncia']."</option>
									</select>
								</div>

							</div>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 4){
		// vaga

		$sql_denuncia = "SELECT * FROM tb_denuncia_vaga INNER JOIN tb_pchave_denuncia ON tb_denuncia_vaga.id_pchave_denuncia_vaga = tb_pchave_denuncia.cd_pchave_denuncia WHERE cd_denuncia_vaga = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-visualizar-motivo-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<div class='mb-3'>
									<textarea class='form-control' id='desc-pchave-projeto' rows='4' placeholder='".$row_denuncia['ds_denuncia_vaga']."' style='background-color: #F0F0F0; color: black;' disabled></textarea>
									<select style='margin-top: 1.5%; color: gray;' class='form-select' id='select-denuncia' disabled>
						    			<option value='".$row_denuncia['cd_pchave_denuncia']."' selected>".$row_denuncia['nm_pchave_denuncia']."</option>
									</select>
								</div>

							</div>
						</div>
					</div>
				</div>";
	}else{

	}

	echo $modal;
?>