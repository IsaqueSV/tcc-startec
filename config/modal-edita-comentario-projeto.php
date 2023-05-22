<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['comentarioEdita'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['comentarioEdita'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$comentarioEdita = $_POST['comentarioEdita'];		
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
		#modal-edita-comentario-projeto{ 
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
		$("#alerta-resultado-comentario-projeto").hide();

		$("#btn-fecha-edita-comentario-projeto").click(function(){
			$("#modal-edita-comentario-projeto").fadeOut();
		})

		$("#btn-confirma-edita-comentario-projeto").click(function(){
			$.ajax({
				url: "config/editar-comentario-projeto.php",
			    type: "POST",
				data: "comentarioEdita=" + "<?php echo $comentarioEdita; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>" + "&comentario="+$("#comentario").val(),
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-resultado-comentario-projeto").html(resposta);
				$("#alerta-resultado-comentario-projeto").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});

		$("#btn-deletar-edita-comentario-projeto").click(function(){
			$.ajax({
				url: "config/deletar-comentario-projeto.php",
			    type: "POST",
				data: "comentarioEdita=" + "<?php echo $comentarioEdita; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-resultado-comentario-projeto").html(resposta);
				$("#alerta-resultado-comentario-projeto").show();
				setTimeout(function() {
				  window.location.reload(1);
				}, 2000);
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
	$sql_comentario = "SELECT * FROM tb_comentario_projeto WHERE cd_comentario_projeto = '$comentarioEdita' AND id_autor_comentario_projeto = '$cdUsuario'";
	$query_comentario = mysqli_query($mysqli, $sql_comentario);
	$row_comentario = mysqli_fetch_assoc($query_comentario);

	echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
	 		<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Editar comentário</h5>
					<button type='button' class='btn-close' data-bs-dismiss='modal-edita-comentario-projeto' aria-label='Close' id='btn-fecha-edita-comentario-projeto'></button>
				</div>
	 			<div class='modal-body'>
		 			<div class='alert' role='alert' id='alerta-resultado-comentario-projeto'></div>
	    			<div class='mb-3'>
						<textarea class='form-control' id='comentario' rows='4' maxlength='400' placeholder='Digite aqui'>".$row_comentario['ds_comentario_projeto']."</textarea>
					</div>
			 	</div>
			 	<div class='modal-footer'>
					<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' id='btn-deletar-edita-comentario-projeto'>Deletar</button>
					<button type='button' style='background-color: #172f54; color: white;' class='btn' id='btn-confirma-edita-comentario-projeto'>Alterar</button>
				</div>
			</div>
		</div>";
?>