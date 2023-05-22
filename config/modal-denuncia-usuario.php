<?php
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['usuarioPesquisado'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['usuarioPesquisado'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$usuarioPesquisado = $_POST['usuarioPesquisado'];		
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
		#denuncia{ 
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
		$("#alerta-denuncia").hide();
		$("#alerta-cancela").hide();

		$("#btn-fecha-denuncia").click(function(){
			$("#denuncia").fadeOut();
		});

		$("#btn-confirmar-denuncia").click(function(){
			$.ajax({
				url: "config/denunciar-usuario.php",
			    type: "POST",
				data: "usuarioPesquisado=" + "<?php echo $usuarioPesquisado; ?>" + "&autor="+ "<?php echo $_SESSION['cdUsuario']; ?>" + "&desc-denuncia="+$("#desc-denuncia-hab").val() + "&select-denuncia="+$("#select-denuncia-hab").val(),
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-denuncia").html(resposta);
				$("#alerta-denuncia").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});

		$("#btn-cancelar-denuncia").click(function(){
			$.ajax({
				url: "config/retira-denuncia-usuario.php",
			    type: "POST",
				data: "usuarioPesquisado=" + "<?php echo $usuarioPesquisado; ?>" + "&autor="+ "<?php echo $_SESSION['cdUsuario']; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#alerta-cancela").html(resposta);
				$("#alerta-cancela").show();
			}).fail(function(jqXHR, textStatus){
			    console.log("Request failed: " + textStatus);
			}).always(function(){
			    console.log("completou");
			});
		});
	</script>
</head>
<body>
</body>
</html>

<?php 
	include('../banco/conexao.php');

	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado'";
	$query = mysqli_query($mysqli, $sql);
	$num = mysqli_num_rows($query);
	$row = mysqli_fetch_assoc($query);

	if($num > 0){
		$autor = $_SESSION['cdUsuario'];
		$result_denuncia = "SELECT * FROM tb_pchave_denuncia";
		$resultado_denuncia = mysqli_query($mysqli, $result_denuncia);

		$sql_contagem = "SELECT * FROM tb_denuncia_usuario INNER JOIN tb_pchave_denuncia ON tb_denuncia_usuario.id_pchave_denuncia_usuario = tb_pchave_denuncia.cd_pchave_denuncia WHERE id_autor_denuncia_usuario = '$autor' AND id_denuncia_usuario = '$usuarioPesquisado'";
		$query_contagem = mysqli_query($mysqli, $sql_contagem);
		$row_contagem = mysqli_fetch_assoc($query_contagem);
		$num_contagem = mysqli_num_rows($query_contagem);

		if($num_contagem > 0){
			$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>Usuário denunciado</h5>
						<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-denuncia'></button>
					</div>
			 		<div class='modal-body'>
				 		<div class='alert' role='alert' id='alerta-cancela'></div>
			    		<div class='mb-3'>
							<label for='desc-denuncia-des' class='form-label'>Descrição da denúncia *</label>
							<textarea class='form-control' id='desc-denuncia-des' rows='4' maxlength='400' placeholder='".$row_contagem['ds_denuncia_usuario']."' style='resize: none;' disabled></textarea>
						</div>
			    		<div class='mb-3'>
							<label for='select-denuncia-des' class='form-label'>Motivo da denúncia *</label>
							<select class='form-select' aria-label='Default select example' id='select-denuncia-des' disabled>
				    			<option value='".$row_contagem['cd_pchave_denuncia']."' selected>".$row_contagem['nm_pchave_denuncia']."</option>";
				    			while($row_denuncia = mysqli_fetch_assoc($resultado_denuncia)){
				    				$modal.="<option value='".$row_denuncia['cd_pchave_denuncia']."'>".$row_denuncia['nm_pchave_denuncia']."</option>";
				    			}

					$modal.="</select>
									</div>
					 			</div>
					 			<div class='modal-footer'>
						        	<button type='button' style='background-color: #172f54; color: white;' class='btn' data-bs-dismiss='modal' id='btn-cancelar-denuncia'>Retirar denúncia</button>
						    	</div>
							</div>
						  </div>";	
		}if($num_contagem == 0){
			$modal = "<div class='modal-dialog-centered modal-dialog modal-xl'>
			 	<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'>Criar denúncia</h5>
						<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-denuncia'></button>
					</div>
			 		<div class='modal-body'>
				 		<div class='alert' role='alert' id='alerta-denuncia'></div>
			    		<div class='mb-3'>
							<label for='desc-denuncia-hab' class='form-label'>Descrição da denúncia *</label>
							<textarea class='form-control' id='desc-denuncia-hab' rows='4' maxlength='400' placeholder='Digite aqui' style='resize: none;'></textarea>
						</div>
			    		<div class='mb-3'>
							<label for='select-denuncia-des' class='form-label'>Motivo da denúncia *</label>
							<select class='form-select' aria-label='Default select example' id='select-denuncia-hab'>
				    			<option value='' selected>Selecione</option>";
				    			while($row_denuncia = mysqli_fetch_assoc($resultado_denuncia)){
				    				$modal.="<option value='".$row_denuncia['cd_pchave_denuncia']."'>".$row_denuncia['nm_pchave_denuncia']."</option>";
				    			}

					$modal.="</select>
									</div>
					 			</div>
					 			<div class='modal-footer'>
						        	<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' data-bs-dismiss='modal' id='btn-confirmar-denuncia'>Denunciar</button>
						    	</div>
							</div>
						  </div>";
		}

		echo $modal;
	}
	
?>