<?php 
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	
	if(isset($_SESSION['cdUsuario']) AND isset($_POST['vagaPesquisada'])){
		if(empty($_SESSION['cdUsuario']) OR empty($_POST['vagaPesquisada'])){
			header('Location: ../index.php');	
		}else{
			$cdUsuario = $_SESSION['cdUsuario'];
			$vagaPesquisada = $_POST['vagaPesquisada'];
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
		#modal-pesquisa-vaga{ 
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
		$("#denuncia-vaga").fadeOut();
		$("#pchave-vaga").fadeOut();

		$("#btn-fecha-modal").click(function(){
			$("#modal-pesquisa-vaga").fadeOut();
		});

		$("#btn-denunciar").click(function(){
			$.ajax({
				url: "config/modal-denuncia-vaga.php",
				type: "POST",
				data: "vagaPesquisada="+"<?php echo $vagaPesquisada; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#denuncia-vaga").html(resposta);
				$("#denuncia-vaga").fadeIn();
			}).fail(function(jqXHR, textStatus ){
				console.log("Request failed: " + textStatus);
				$("#denuncia-vaga").fadeOut();
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
	$sql = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE cd_vaga = '$vagaPesquisada'";
	$query = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($query);

	echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <h5 class='modal-title'>Vaga</h5>
		        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
		      </div>
		      <div class='modal-body'>
		      	<div style='width: 100%; border: 2px solid #DCDCDC; border-radius: 8px; padding: 3%;'>
			    	<table>
			    		<tbody>
			    			<tr>
				    			<td>
				    			Título: ".$row['nm_vaga']."
				    			</td>
				    			<td style='text-align: right'>
				    				".date("d/m/Y H:i", strtotime($row['created_vaga']))."
				    			</td>
			    			</tr>
			    			<tr>
			    				<td>
				    			Tag principal: ".$row['nm_pchave_vaga']."
				    			</td>
			    			</tr>
			    			<tr>	

			    			</tr>
			    		</tbody>
			    	</table>
			    </div>
			  </div>
			  <div class='modal-footer'>
			    <button type='button' style='background-color: #1e7fbc; color: white;' class='btn' data-bs-dismiss='modal' id='btn-denunciar'>Denunciar</button>
			  </div>
			</div>
		</div>";
	
?>