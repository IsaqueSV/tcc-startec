<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idVaga'])){
		if(empty($_POST['idVaga'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		

				if($idNivel != 3){
					header('Location: ../index.php');
				}
			}
			$idVaga = $_POST['idVaga'];	
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
		#modal-deletar-vaga-adm{ 
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
		$("#btn-fecha-modal-deletar-vaga-adm").click(function(){
			$("#modal-deletar-vaga-adm").fadeOut();
		});

		$("#btn-deletar-vaga-confirmar").click(function(){
			window.location.href = "config/excluir_vaga.php?see="+"<?php echo $idVaga; ?>";
		});
	});

	</script>
</head>
<body>
</body>
</html>
<?php 
		$sql_vaga = "SELECT * FROM tb_vaga WHERE ds_url_vaga = '$idVaga'";
		$query_vaga = mysqli_query($mysqli, $sql_vaga);
		$row_vaga = mysqli_fetch_assoc($query_vaga);

	$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'> Você tem certeza? </h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-vaga-adm'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='col-md-12 style='margin-right: 2%;'>
							<label class='alert'>
								Essa ação não pode ser desfeita. Isso excluirá permanentemente a vaga <b>".$row_vaga['nm_vaga']."</b>, seus comentários, curtidas e denuncias.<br>
							</label>
						</div>
					</div>
					<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
						<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-vaga-confirmar'>Confirmar</button>
					</div>
				</div>
			</div>";

	echo $modal;
?>