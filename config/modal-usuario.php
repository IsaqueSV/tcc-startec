<?php 
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['usuarioPesquisado'])){
		if(empty($_POST['usuarioPesquisado'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		
			}
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
		#modal{ 
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
		$("#denuncia").fadeOut();
		$("#cadastrar-login").fadeOut();

		$("#btn-fecha-modal").click(function(){
			$("#modal").fadeOut();
		});

		$("#btn-denunciar").click(function(){
			$.ajax({
				url: "config/modal-denuncia-usuario.php",
				type: "POST",
				data: "usuarioPesquisado="+"<?php echo $usuarioPesquisado; ?>",
				dataType: "html"
			}).done(function(resposta){
				$("#denuncia").html(resposta);
				$("#denuncia").fadeIn();
			}).fail(function(jqXHR, textStatus ){
				console.log("Request failed: " + textStatus);
				$("#denuncia").fadeOut();
			}).always(function(){
				console.log("completou");
			});
		});

		$("#btn-alerta-cad").click(function(){
			$.ajax({
				url: "config/modal-cadastro-login.php",
				type: "POST",
				dataType: "html"
			}).done(function(resposta){
				$("#cadastrar-login").html(resposta);
				$("#cadastrar-login").fadeIn();
			}).fail(function(jqXHR, textStatus ){
				console.log("Request failed: " + textStatus);
				$("#cadastrar-login").fadeOut();
			}).always(function(){
				console.log("completou");
			});
		});

		$("#btn-alerta-cad-denuncia").click(function(){
			$.ajax({
				url: "config/modal-cadastro-login.php",
				type: "POST",
				dataType: "html"
			}).done(function(resposta){
				$("#cadastrar-login").html(resposta);
				$("#cadastrar-login").fadeIn();
			}).fail(function(jqXHR, textStatus ){
				console.log("Request failed: " + textStatus);
				$("#cadastrar-login").fadeOut();
			}).always(function(){
				console.log("completou");
			});
		});

		$(".btn-deletar-usuario-aluno").click(function(){
				$id_usuario = $(this).attr('id');

				$.ajax({
					url: "config/modal-deletar-usuario-adm.php",
					type: "POST",
					data: "idUsuario="+$id_usuario + "&nivelUsuario="+"1",
					dataType: "html"
				}).done(function(resposta){
					$("#modal-deletar-usuario-adm").html(resposta);
					$("#modal-deletar-usuario-adm").fadeIn();
					$("#modal").fadeOut();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#modal-deletar-usuario-adm").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			})

		$(".btn-deletar-usuario-empresa").click(function(){
				$id_usuario = $(this).attr('id');

				$.ajax({
					url: "config/modal-deletar-usuario-adm.php",
					type: "POST",
					data: "idUsuario="+$id_usuario + "&nivelUsuario="+"2",
					dataType: "html"
				}).done(function(resposta){
					$("#modal-deletar-usuario-adm").html(resposta);
					$("#modal-deletar-usuario-adm").fadeIn();
					$("#modal").fadeOut();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#modal-deletar-usuario-adm").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			})

	</script>
</head>
<body>
</body>
</html>

<?php
	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado'";
	$query = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($query);

	if(!isset($_SESSION['cdUsuario']) AND !isset($_SESSION['idNivel'])){
		if($row['id_nivel'] == 1){
			$sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_escolaridade ON tb_usuario.id_escolaridade = tb_escolaridade.cd_escolaridade WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '1'";
			$query_aluno = mysqli_query($mysqli, $sql_aluno);
			$row_aluno = mysqli_fetch_assoc($query_aluno);

			echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <h5 class='modal-title'>Aluno</h5>
				        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
				      </div>
				      <div class='modal-body'>
				      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
				      		<div style='width: 27%;'>
				      			<img src='".$row_aluno['path_foto_usuario']."' title='".$row_aluno['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; height: 86%; width: 100%; '>
				      			<a><button id='btn-alerta-cad' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>
				      		</div>
				      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
				      			<table>
				      				<tbody>
				      					<tr>
				      						<td>
				      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
				      						</td>
				      					</tr>
				      					<tr>
				      						<td> Username: ".$row_aluno['nm_usuario']."</td>
				      						<td> Nome completo: ".$row_aluno['nm_completo']."</td>
				      					</tr>
				      					<tr>
				      						<td> Email: ".$row_aluno['ds_email']."</td>
				      						<td> Github: ".$row_aluno['nm_github']."</td>
				      					</tr>
				      					<tr>
				      						<td> Gênero: ".$row_aluno['nm_genero']."</td>
				      						<td> Nível de escolaridade: ".$row_aluno['nm_escolaridade']."</td>
				      					</tr>
				      				</tbody>
				      			</table>
				      			Escola: ".$row_aluno['nm_etec']."<br>
				      			<br>Descrição: 
				      			<textarea class='form-control' rows='4' placeholder='".$row_aluno['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
				      		</div>
				      	</div>
				      </div>

				      <div class='modal-footer'>
				        <a><button id='btn-alerta-cad-denuncia' type='button' style='background-color: #1e7fbc; color: white;' class='btn'>Denunciar</button></a>
				      </div>
				    </div>
				  </div>";
		}
		if($row['id_nivel'] == 2){
			$sql_empresa = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '2'";
			$query_empresa = mysqli_query($mysqli, $sql_empresa);
			$row_empresa = mysqli_fetch_assoc($query_empresa);

			echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <h5 class='modal-title'>Empresa</h5>
				        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
				      </div>
				      <div class='modal-body'>
				      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
				      		<div style='width: 27%;'>
				      			<img src='".$row_empresa['path_foto_usuario']."' title='".$row_empresa['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; width: 100%; height: 86%;'>
				      			<a><button id='btn-alerta-cad' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>

				      		</div>
				      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
				      			<table>
				      				<tbody>
				      					<tr>
				      						<td>
				      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
				      						</td>
				      					</tr>
				      					<tr>
				      						<td> Nome da empresa: ".$row_empresa['nm_usuario']."</td>
				      					</tr>
				      					<tr>
				      						<td> Email: ".$row_empresa['ds_email']."</td>
				      						<td> CNPJ: ".$row_empresa['ds_cnpj']."</td>
				      					</tr>
				      					<tr>
				      						<td><br>Descrição: </td>
				      					</tr>
				      				</tbody>
				      			</table>
				      			<textarea class='form-control' rows='4' placeholder='".$row_empresa['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
				      		</div>
				      	</div>
				      </div>

				      <div class='modal-footer'>
				        <a><button id='btn-alerta-cad-denuncia' type='button' style='background-color: #1e7fbc; color: white;' class='btn'>Denunciar</button></a>
				      </div>
				    </div>
				  </div>";
		}
	}else{
		if($usuarioPesquisado == $cdUsuario){
			if($idNivel == 1){
				$sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_escolaridade ON tb_usuario.id_escolaridade = tb_escolaridade.cd_escolaridade WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '1'";
				$query_aluno = mysqli_query($mysqli, $sql_aluno);
				$row_aluno = mysqli_fetch_assoc($query_aluno);

				echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <h5 class='modal-title'>Meu perfil</h5>
				        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
				      </div>
				      <div class='modal-body'>
				      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
				      		<div style='width: 27%;'>
				      			<img src='".$row_aluno['path_foto_usuario']."' title='".$row_aluno['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; height: 86%; width: 100%; '>
				      			<a href='meu_perfil.php'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Editar perfil</button></a>
				      		</div>
				      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
				      			<table>
				      				<tbody>
				      					<tr>
				      						<td>
				      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
				      						</td>
				      					</tr>
				      					<tr>
				      						<td> Username: ".$row_aluno['nm_usuario']."</td>
				      						<td> Nome completo: ".$row_aluno['nm_completo']."</td>
				      					</tr>
				      					<tr>
				      						<td> Email: ".$row_aluno['ds_email']."</td>
				      						<td> Github: ".$row_aluno['nm_github']."</td>
				      					</tr>
				      					<tr>
				      						<td> Gênero: ".$row_aluno['nm_genero']."</td>
				      						<td> Nível de escolaridade: ".$row_aluno['nm_escolaridade']."</td>
				      					</tr>
				      				</tbody>
				      			</table>
				      			Escola: ".$row_aluno['nm_etec']."<br>
				      			<br>Descrição: 
				      			<textarea class='form-control' rows='4' placeholder='".$row_aluno['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
				      		</div>
				      	</div>
				      </div>
				    </div>
				  </div>";
			}else if($idNivel == 2){
				$sql_empresa = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '2'";
				$query_empresa = mysqli_query($mysqli, $sql_empresa);
				$row_empresa = mysqli_fetch_assoc($query_empresa);

				echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>Meu perfil</h5>
					        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
					      </div>
					      <div class='modal-body'>
					      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
					      		<div style='width: 27%;'>
					      			<img src='".$row_empresa['path_foto_usuario']."' title='".$row_empresa['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; height: 86%; width: 100%;'>
					      			<a href='meu_perfil.php'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Editar perfil</button></a>
					      		</div>
					      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
					      			<table>
					      				<tbody>
					      					<tr>
					      						<td>
					      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
					      						</td>
					      					</tr>
					      					<tr>
					      						<td> Nome da empresa: ".$row_empresa['nm_usuario']."</td>
					      					</tr>
					      					<tr>
					      						<td> Email: ".$row_empresa['ds_email']."</td>
					      						<td> CNPJ: ".$row_empresa['ds_cnpj']."</td>
					      					</tr>
					      					<tr>
					      						<td><br>Descrição: </td>
					      					</tr>
					      				</tbody>
					      			</table>
					      			<textarea class='form-control' rows='4' placeholder='".$row_empresa['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
					      		</div>
					      	</div>
					      </div>
					    </div>
					  </div>";
			}
		}else{
			if($idNivel == 3){
				if($row['id_nivel'] == 1){
					$sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_escolaridade ON tb_usuario.id_escolaridade = tb_escolaridade.cd_escolaridade WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '1'";
					$query_aluno = mysqli_query($mysqli, $sql_aluno);
					$row_aluno = mysqli_fetch_assoc($query_aluno);

					echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>Aluno</h5>
						        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
						      </div>
						      <div class='modal-body'>
						      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
						      		<div style='width: 27%;'>
						      			<img src='".$row_aluno['path_foto_usuario']."' title='".$row_aluno['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; height: 86%; width: 100%; '>
						      			<a href='perfil.php?see=".$row_aluno['ds_url_usuario']."'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>
						      		</div>
						      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
						      			<table>
						      				<tbody>
						      					<tr>
						      						<td>
						      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
						      						</td>
						      					</tr>
						      					<tr>
						      						<td> Username: ".$row_aluno['nm_usuario']."</td>
						      						<td> Nome completo: ".$row_aluno['nm_completo']."</td>
						      					</tr>
						      					<tr>
						      						<td> Email: ".$row_aluno['ds_email']."</td>
						      						<td> Github: ".$row_aluno['nm_github']."</td>
						      					</tr>
						      					<tr>
						      						<td> Gênero: ".$row_aluno['nm_genero']."</td>
						      						<td> Nível de escolaridade: ".$row_aluno['nm_escolaridade']."</td>
						      					</tr>
						      				</tbody>
						      			</table>
						      			Escola: ".$row_aluno['nm_etec']."<br>
						      			<br>Descrição: 
						      			<textarea class='form-control' rows='4' placeholder='".$row_aluno['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
						      		</div>
						      	</div>
						      </div>

						      <div class='modal-footer'>
						        <button type='button' style='background-color: #1e7fbc; color: white;' class='btn-deletar-usuario-aluno btn' id='".$row_aluno['ds_url_usuario']."' data-bs-dismiss='modal'>Deletar</button>
						      </div>
						    </div>
						  </div>";
				}else if($row['id_nivel'] == 2){
					$sql_empresa = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '2'";
					$query_empresa = mysqli_query($mysqli, $sql_empresa);
					$row_empresa = mysqli_fetch_assoc($query_empresa);

					echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>Empresa</h5>
						        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
						      </div>
						      <div class='modal-body'>
						      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
						      		<div style='width: 27%;'>
						      			<img src='".$row_empresa['path_foto_usuario']."' title='".$row_empresa['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; width: 100%; height: 86%;'>
						      			<a href='perfil.php?see=".$row_empresa['ds_url_usuario']."'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>

						      		</div>
						      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
						      			<table>
						      				<tbody>
						      					<tr>
						      						<td>
						      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
						      						</td>
						      					</tr>
						      					<tr>
						      						<td> Nome da empresa: ".$row_empresa['nm_usuario']."</td>
						      					</tr>
						      					<tr>
						      						<td> Email: ".$row_empresa['ds_email']."</td>
						      						<td> CNPJ: ".$row_empresa['ds_cnpj']."</td>
						      					</tr>
						      					<tr>
						      						<td><br>Descrição: </td>
						      					</tr>
						      				</tbody>
						      			</table>
						      			<textarea class='form-control' rows='4' placeholder='".$row_empresa['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
						      		</div>
						      	</div>
						      </div>

						      <div class='modal-footer'>
						        <button type='button' style='background-color: #1e7fbc; color: white;' class='btn-deletar-usuario-empresa btn' id='".$row_empresa['ds_url_usuario']."' data-bs-dismiss='modal'>Deletar</button>
						      </div>
						    </div>
						  </div>";
				} 
			}else{
				if($row['id_nivel'] == 1){
					$sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_escolaridade ON tb_usuario.id_escolaridade = tb_escolaridade.cd_escolaridade WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '1'";
					$query_aluno = mysqli_query($mysqli, $sql_aluno);
					$row_aluno = mysqli_fetch_assoc($query_aluno);

					echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>Aluno</h5>
						        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
						      </div>
						      <div class='modal-body'>
						      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
						      		<div style='width: 27%;'>
						      			<img src='".$row_aluno['path_foto_usuario']."' title='".$row_aluno['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; height: 86%; width: 100%; '>
						      			<a href='perfil.php?see=".$row_aluno['ds_url_usuario']."'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>
						      		</div>
						      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
						      			<table>
						      				<tbody>
						      					<tr>
						      						<td>
						      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
						      						</td>
						      					</tr>
						      					<tr>
						      						<td> Username: ".$row_aluno['nm_usuario']."</td>
						      						<td> Nome completo: ".$row_aluno['nm_completo']."</td>
						      					</tr>
						      					<tr>
						      						<td> Email: ".$row_aluno['ds_email']."</td>
						      						<td> Github: ".$row_aluno['nm_github']."</td>
						      					</tr>
						      					<tr>
						      						<td> Gênero: ".$row_aluno['nm_genero']."</td>
						      						<td> Nível de escolaridade: ".$row_aluno['nm_escolaridade']."</td>
						      					</tr>
						      				</tbody>
						      			</table>
						      			Escola: ".$row_aluno['nm_etec']."<br>
						      			<br>Descrição: 
						      			<textarea class='form-control' rows='4' placeholder='".$row_aluno['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
						      		</div>
						      	</div>
						      </div>

						      <div class='modal-footer'>
						        <button type='button' style='background-color: #1e7fbc; color: white;' class='btn' data-bs-dismiss='modal' id='btn-denunciar'>Denunciar</button>
						      </div>
						    </div>
						  </div>";
				}else if($row['id_nivel'] == 2){
					$sql_empresa = "SELECT * FROM tb_usuario WHERE cd_usuario = '$usuarioPesquisado' AND id_nivel = '2'";
				$query_empresa = mysqli_query($mysqli, $sql_empresa);
				$row_empresa = mysqli_fetch_assoc($query_empresa);

				echo "<div class='modal-dialog-centered modal-dialog modal-xl'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>Empresa</h5>
					        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-modal'></button>
					      </div>
					      <div class='modal-body'>
					      	<div style='width: 100%; display: flex; border: 2px solid #DCDCDC; border-radius: 8px; padding: 1%;'>
					      		<div style='width: 27%;'>
					      			<img src='".$row_empresa['path_foto_usuario']."' title='".$row_empresa['nm_usuario']."' class='img-thumbnail' style='border: 2px solid #DCDCDC; width: 100%; height: 86%;'>
					      			<a href='perfil.php?see=".$row_empresa['ds_url_usuario']."'><button id='editar_perfil' style='text-decoration: none; color: black; background-color: #F0F0F0; border: 1px solid #DCDCDC; width: 100%; margin-top: 3%;' type='button' class='btn'>Ver mais</button></a>

					      		</div>
					      		<div style='width: 72%; margin-left: 1%; border: 2px solid #DCDCDC; border-radius: 8px; padding:2%;'>
					      			<table>
					      				<tbody>
					      					<tr>
					      						<td>
					      							<label for='inputEmail4' class='form-label h5'>Dados pessoais</label>
					      						</td>
					      					</tr>
					      					<tr>
					      						<td> Nome da empresa: ".$row_empresa['nm_usuario']."</td>
					      					</tr>
					      					<tr>
					      						<td> Email: ".$row_empresa['ds_email']."</td>
					      						<td> CNPJ: ".$row_empresa['ds_cnpj']."</td>
					      					</tr>
					      					<tr>
					      						<td><br>Descrição: </td>
					      					</tr>
					      				</tbody>
					      			</table>
					      			<textarea class='form-control' rows='4' placeholder='".$row_empresa['ds_descricao']."' style='width: 100%; background-color: white; border: 2px solid #DCDCDC; resize: none;' disabled></textarea>
					      		</div>
					      	</div>
					      </div>

					      <div class='modal-footer'>
					        <button type='button' style='background-color: #1e7fbc; color: white;' class='btn' data-bs-dismiss='modal' id='btn-denunciar'>Denunciar</button>
					      </div>
					    </div>
					  </div>";
				}
			}
		}
	}
?>