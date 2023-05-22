<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idUsuario'])){
		if(empty($_POST['idUsuario'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		

				if($idNivel != 3){
					header('Location: ../index.php');
				}
			}
			$idUsuario = $_POST['idUsuario'];
			$nivelUsuario = $_POST['nivelUsuario'];
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
		#modal-deletar-usuario-adm{ 
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
		$("#btn-fecha-modal-deletar-usuario-adm").click(function(){
			$("#modal-deletar-usuario-adm").fadeOut();
		});

		$("#btn-deletar-usuario-confirmar").click(function(){
			window.location.href = "config/excluir_usuario.php?see="+"<?php echo $idUsuario; ?>";
		});
	});

	</script>
</head>
<body>
</body>
</html>
<?php 
		$sql_usuario = "SELECT * FROM tb_usuario INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE ds_url_usuario = '$idUsuario' AND id_nivel = '$nivelUsuario'";
		$query_usuario = mysqli_query($mysqli, $sql_usuario);
		$row_usuario = mysqli_fetch_assoc($query_usuario);

		if($nivelUsuario == 1){
			$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'> Você tem certeza? </h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-usuario-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente o usuário <b>".$row_usuario['nm_usuario']."</b>, seu currículo, projetos e outros dados atrelados ao mesmo.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-usuario-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
		}else if($nivelUsuario == 2){
			$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'> Você tem certeza? </h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-usuario-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente o usuário <b>".$row_usuario['nm_usuario']."</b>, suas vagas, projetos curtidos e outros dados atrelados ao mesmo.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-usuario-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
		}else{
			
		}

		echo $modal;
?>