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
		#modal-edita-comentario-curriculo{ 
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
		$("#alerta-resultado-comentario-curriculo").hide();

		$("#btn-fecha-edita-comentario-curriculo").click(function(){
			$("#modal-edita-comentario-curriculo").fadeOut();
		})

		$("#btn-confirma-edita-comentario-curriculo").click(function(){
			$.ajax({
				url: "config/editar-comentario-curriculo.php",
			    type: "POST",
				data: "comentarioEdita=" + "<?php echo $comentarioEdita; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>" + "&comentario="+$("#comentario").val(),
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-resultado-comentario-curriculo").html(resposta);
				$("#alerta-resultado-comentario-curriculo").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});

		$("#btn-deletar-edita-comentario-curriculo").click(function(){
			$.ajax({
				url: "config/deletar-comentario-curriculo.php",
			    type: "POST",
				data: "comentarioEdita=" + "<?php echo $comentarioEdita; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-resultado-comentario-curriculo").html(resposta);
				$("#alerta-resultado-comentario-curriculo").show();
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
	$sql_comentario = "SELECT * FROM tb_comentario_curriculo WHERE cd_comentario_curriculo = '$comentarioEdita' AND id_autor_comentario_curriculo = '$cdUsuario'";
	$query_comentario = mysqli_query($mysqli, $sql_comentario);
	$row_comentario = mysqli_fetch_assoc($query_comentario);

	echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
	 		<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Editar comentário</h5>
					<button type='button' class='btn-close' data-bs-dismiss='modal-edita-comentario-curriculo' aria-label='Close' id='btn-fecha-edita-comentario-curriculo'></button>
				</div>
	 			<div class='modal-body'>
		 			<div class='alert' role='alert' id='alerta-resultado-comentario-curriculo'></div>
	    			<div class='mb-3'>
						<textarea class='form-control' id='comentario' rows='4' maxlength='400' placeholder='Digite aqui'>".$row_comentario['ds_comentario_curriculo']."</textarea>
					</div>
			 	</div>
			 	<div class='modal-footer'>
					<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' id='btn-deletar-edita-comentario-curriculo'>Deletar</button>
					<button type='button' style='background-color: #172f54; color: white;' class='btn' id='btn-confirma-edita-comentario-curriculo'>Alterar</button>
				</div>
			</div>
		</div>";
?>