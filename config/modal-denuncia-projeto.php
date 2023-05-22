<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['projetoDenunciado'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['projetoDenunciado'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$projetoDenunciado = $_POST['projetoDenunciado'];		
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
		#denuncia-projeto{ 
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
		$("#alerta-denuncia-projeto").hide();
		$("#alerta-cancela-projeto").hide();

		$("#btn-fecha-denuncia-projeto").click(function(){
			$("#denuncia-projeto").fadeOut();
		});
	
		$("#btn-confirma-denuncia-projeto").click(function(){
			$.ajax({
				url: "config/denunciar-projeto.php",
			    type: "POST",
				data: "projetoDenunciado=" + "<?php echo $projetoDenunciado; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>" + "&desc-denuncia="+$("#desc-denuncia-hab").val() + "&select-denuncia="+$("#select-denuncia-hab").val(),
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-denuncia-projeto").html(resposta);
				$("#alerta-denuncia-projeto").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});

		$("#btn-cancelar-denuncia-projeto").click(function(){
			$.ajax({
				url: "config/retira-denuncia-projeto.php",
			    type: "POST",
				data: "projetoDenunciado=" + "<?php echo $projetoDenunciado; ?>" + "&autor="+ "<?php echo $cdUsuario; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-cancela-projeto").html(resposta);
				$("#alerta-cancela-projeto").show();
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
	include('../banco/conexao.php');
	$sql_filtro_denuncia = "SELECT * FROM tb_pchave_denuncia";
	$query_filtro_denuncia = mysqli_query($mysqli, $sql_filtro_denuncia);

	$sql_contagem_denuncia = "SELECT * FROM tb_denuncia_projeto INNER JOIN tb_pchave_denuncia ON tb_denuncia_projeto.id_pchave_denuncia_projeto = tb_pchave_denuncia.cd_pchave_denuncia WHERE id_autor_denuncia_projeto = '$cdUsuario' AND id_denuncia_projeto = '$projetoDenunciado'";
	$query_contagem_denuncia = mysqli_query($mysqli, $sql_contagem_denuncia);
	$row_contagem_denuncia = mysqli_fetch_assoc($query_contagem_denuncia);
	$num_contagem_denuncia = mysqli_num_rows($query_contagem_denuncia);

	if($num_contagem_denuncia == 0){
		$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 		<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>Criar denúncia</h5>
							<button type='button' class='btn-close' data-bs-dismiss='denuncia-projeto' aria-label='Close' id='btn-fecha-denuncia-projeto'></button>
						</div>
			 			<div class='modal-body'>
				 			<div class='alert' role='alert' id='alerta-denuncia-projeto'></div>
			    			<div class='mb-3'>
								<label for='desc-denuncia-hab' class='form-label'>Descrição da denúncia *</label>
								<textarea class='form-control' id='desc-denuncia-hab' rows='4' maxlength='400' placeholder='Digite aqui'></textarea>
							</div>
			    			<div class='mb-3'>
								<label for='select-denuncia-des' class='form-label'>Motivo da denúncia *</label>
								<select class='form-select' aria-label='Default select example' id='select-denuncia-hab'>
				    				<option value='' selected>Selecione</option>";
				    				while($row_filtro_denuncia = mysqli_fetch_assoc($query_filtro_denuncia)){
						   $modal.="<option value='".$row_filtro_denuncia['cd_pchave_denuncia']."'>".$row_filtro_denuncia['nm_pchave_denuncia']."</option>";
				    			}
					   $modal.="</select>
							</div>
					 	</div>
					 	<div class='modal-footer'>
							<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' id='btn-confirma-denuncia-projeto'>Denunciar</button>
						</div>
					</div>
				</div>";
	}else{
		$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>Projeto denunciado</h5>
						<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-denuncia-projeto'></button>
					</div>
			 		<div class='modal-body'>
				 		<div class='alert' role='alert' id='alerta-cancela-projeto'></div>
			    		<div class='mb-3'>
							<label for='desc-denuncia-des' class='form-label'>Descrição da denúncia *</label>
							<textarea class='form-control' id='desc-denuncia-des' rows='4' maxlength='400' placeholder='".$row_contagem_denuncia['ds_denuncia_projeto']."' disabled></textarea>
						</div>
			    		<div class='mb-3'>
							<label for='select-denuncia-des' class='form-label'>Motivo da denúncia *</label>
							<select class='form-select' id='select-denuncia-des' disabled>
				    			<option value='".$row_contagem_denuncia['cd_pchave_denuncia']."' selected>".$row_contagem_denuncia['nm_pchave_denuncia']."</option>";
				    			while($row_filtro_denuncia = mysqli_fetch_assoc($query_filtro_denuncia)){
				    				$modal.="<option value='".$row_filtro_denuncia['cd_pchave_denuncia']."'>".$row_filtro_denuncia['nm_pchave_denuncia']."</option>";
				    			}

					$modal.="</select>
									</div>
					 			</div>
					 			<div class='modal-footer'>
						        	<button type='button' style='background-color: #172f54; color: white;' class='btn' id='btn-cancelar-denuncia-projeto'>Retirar denúncia</button>
						    	</div>
							</div>
						  </div>";
	}

	echo $modal;
?>