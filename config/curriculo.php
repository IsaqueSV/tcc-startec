<?php
	header('Content-Type: text/html; charset=utf-8');
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
		if($idNivel == 2){
			header("Location: ../home_empresa.php");
		}else{
			if(isset($_POST['foto']) AND isset($_POST['nome']) AND isset($_POST['email']) AND isset($_POST['cargo']) AND isset($_POST['select-pchave']) AND isset($_POST['nascimento']) AND isset($_POST['select-estado-civil']) AND isset($_POST['ddd']) AND isset($_POST['telefone']) AND isset($_POST['select-cidade']) AND isset($_POST['cep']) AND isset($_POST['select-etec']) AND isset($_POST['select-genero'])){
				if(empty($_POST['foto']) OR empty($_POST['nome']) OR empty($_POST['email']) OR empty($_POST['cargo']) OR empty($_POST['select-pchave']) OR empty($_POST['nascimento']) OR empty($_POST['select-estado-civil']) OR empty($_POST['ddd']) OR empty($_POST['telefone']) OR empty($_POST['select-cidade']) OR empty($_POST['cep']) OR empty($_POST['select-etec']) OR empty($_POST['select-genero'])){
					header('Location: ../index.php');
				}else{
					$foto = $_POST['foto'];
					$nome = $_POST['nome'];
					$email = $_POST['email'];
					$cargo = $_POST['cargo'];
					$pchave = $_POST['select-pchave'];
					$nascimento = $_POST['nascimento'];
					$estado_civil = $_POST['select-estado-civil'];
					$ddd = $_POST['ddd'];
					$telefone = $_POST['telefone'];
					$numero = $ddd . $telefone;
					$cidade = $_POST['select-cidade'];
					$cep = $_POST['cep'];
					$etec = $_POST['select-etec'];
					$genero = $_POST['select-genero'];
					$idiomas = $_POST['idiomas'];
					$qualidades = $_POST['qualidades'];
					$cursos = $_POST['cursos'];
					$idAutor = $cdUsuario;
					$url_curriculo = md5(uniqid(""));

					if($idiomas == ""){
						$idiomas = "Campo não preenchido pelo usuário";
					}if($qualidades == ""){
						$qualidades = "Campo não preenchido pelo usuário";
					}if($cursos == ""){
						$cursos = "Campo não preenchido pelo usuário";
					}

					$pega1 = "SELECT cd_etec FROM tb_etec WHERE nm_etec ='$etec'";
					$query1 = mysqli_query($mysqli, $pega1);
					$row1 = mysqli_fetch_assoc($query1);

					$pega2 = "SELECT cd_genero FROM tb_genero WHERE nm_genero ='$genero'";
					$query2 = mysqli_query($mysqli, $pega2);
					$row2 = mysqli_fetch_assoc($query2);
						
					$cdEtec = $row1['cd_etec'];
					$cdGenero = $row2['cd_genero'];

					$sql_insere = "INSERT INTO tb_curriculo VALUES (null, '-', '$foto', '$nome', '$email', '$cargo', '$nascimento', '$numero', '$idiomas', '$qualidades', '$cursos', '$url_curriculo', '$idAutor', '$estado_civil', '$cidade', '$cep', '$cdEtec', '$pchave', '$cdGenero', NOW())";
					if($resultado = $mysqli->query($sql_insere)){
						?>
						<script>
							window.location.href = "../curriculo_aluno.php";
						</script>
						<?php
					}else{
						echo $mysqli->error;
					}	
				}
			}else{
				header('Location: ../index.php');
			}
		}
	
?>