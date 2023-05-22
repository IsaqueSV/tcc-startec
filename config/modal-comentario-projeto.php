<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['projetoComentado'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['projetoComentado'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$projetoComentado = $_POST['projetoComentado'];		
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
		#modal-comentario-projeto{ 
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

		textarea{
			resize: none;
		}
	</style>
	<script>
	$(document).ready(function(){
		$("#alerta-comentario-projeto").hide();

		$("#btn-fecha-comentario-projeto").click(function(){
			$("#modal-comentario-projeto").fadeOut();
		})
	
		$("#btn-confirma-comentario-projeto").click(function(){
			$.ajax({
				url: "config/comentar-projeto.php",
			    type: "POST",
				data: "projetoComentado=" + "<?php echo $projetoComentado; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>" + "&desc-comentario="+$("#desc-comentario").val(),
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-comentario-projeto").html(resposta);
				$("#alerta-comentario-projeto").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});
	});
	</script>
</head>
<body>
</body>
</html>

<?php 
		echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 		<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>Criar comentário</h5>
							<button type='button' class='btn-close' data-bs-dismiss='modal-comentario-projeto' aria-label='Close' id='btn-fecha-comentario-projeto'></button>
						</div>
			 			<div class='modal-body'>
				 			<div class='alert' role='alert' id='alerta-comentario-projeto'></div>
			    			<div class='mb-3'>
								<textarea class='form-control' id='desc-comentario' rows='4' maxlength='400' placeholder='Digite aqui'></textarea>
							</div>
					 	</div>
					 	<div class='modal-footer'>
							<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' id='btn-confirma-comentario-projeto'>Publicar</button>
						</div>
					</div>
				</div>";
?>