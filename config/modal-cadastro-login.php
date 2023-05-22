<?php
	include('../banco/conexao.php');
	session_start();
	if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		#cadastrar-login{ 
			background: rgba(0, 0, 0, 0.7);
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
		$("#btn-fecha-cadastrar-login").click(function(){
			$("#cadastrar-login").fadeOut();
		});
		$("#btn-link-aluno").click(function(){
			window.location.href = "cadastrar_aluno.php";
		});
		$("#btn-link-empresa").click(function(){
			window.location.href = "cadastrar_empresa.php";
		});
	</script>
</head>
<body>
</body>
</html>

<?php 
	include('../banco/conexao.php');
	
	echo "<div class='modal-dialog-centered modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='btn-fecha-cadastrar-login'></button>
				</div>
				<div class='modal-body'>
					Esta ação só pode ser realizada por usuários cadastrados. Se quiser prosseguir crie uma conta ou, se já possuir uma, efetue login
				</div>
				<div class='modal-footer'>
					<button type='button' style='background-color: #1e7fbc; color: white;' class='btn' data-bs-dismiss='modal' id='btn-link-aluno'>Aluno</button>
					<button type='button' style='background-color: #172f54; color: white;' class='btn' data-bs-dismiss='modal' id='btn-link-empresa'>Empresa</button>
				</div>
			</div>
		</div>";	
?>