<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idCurriculo'])){
		if(empty($_POST['idCurriculo'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		

				if($idNivel != 3){
					header('Location: ../index.php');
				}
			}
			$idCurriculo = $_POST['idCurriculo'];	
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
		#modal-deletar-curriculo-adm{ 
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
		$("#btn-fecha-modal-deletar-curriculo-adm").click(function(){
			$("#modal-deletar-curriculo-adm").fadeOut();
		});

		$("#btn-deletar-curriculo-confirmar").click(function(){
			window.location.href = "config/excluir_curriculo.php?see="+"<?php echo $idCurriculo; ?>";
		});
	});

	</script>
</head>
<body>
</body>
</html>
<?php 
		$sql_curriculo = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario WHERE ds_url_curriculo = '$idCurriculo'";
		$query_curriculo = mysqli_query($mysqli, $sql_curriculo);
		$row_curriculo = mysqli_fetch_assoc($query_curriculo);

	$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'> Você tem certeza? </h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-curriculo-adm'></button>
					</div>
			 		<div class='modal-body'>
			    		<div class='col-md-12 style='margin-right: 2%;'>
							<label class='alert'>
								Essa ação não pode ser desfeita. Isso excluirá permanentemente o currículo de <b>".$row_curriculo['nm_usuario']."</b>, seus comentários, vagas candidatadas, curtidas e denuncias.<br>
							</label>
						</div>
					</div>
					<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
						<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-curriculo-confirmar'>Confirmar</button>
					</div>
				</div>
			</div>";

	echo $modal;
?>