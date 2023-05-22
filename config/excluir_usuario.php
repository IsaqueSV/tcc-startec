<?php
	include('../banco/conexao.php');
	session_start();
	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}
	if($idNivel != 3){
		?>
		<script>
			history.go(-1);
		</script>
		<?php
	}

	if(isset($_GET['see'])){
		if($_GET['see'] == ""){
			header('Location: ../index.php');
		}else{
			$url = $_GET['see'];
			$sql = "SELECT * FROM tb_usuario WHERE ds_url_usuario = '$url'";
			$query = mysqli_query($mysqli, $sql);
			$num = mysqli_num_rows($query);
			$row = mysqli_fetch_assoc($query);
			$idUsuario = $row['cd_usuario'];
			$nivelUsuario = $row['id_nivel'];

			if($num > 0){
				if($nivelUsuario == 1){
					$mysqli->query("DELETE FROM tb_arquivo WHERE id_autor_arquivo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_autor_curtida_projeto = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_autor_denuncia_projeto = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_autor_comentario_projeto = '$idUsuario'");					
					$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_autor_projeto_curtido = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_autor_projeto_denunciado = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_autor_projeto_comentado = '$idUsuario'");

					$mysqli->query("DELETE FROM tb_denuncia_usuario WHERE id_autor_denuncia_usuario = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_usuario WHERE id_denuncia_usuario = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_curriculo WHERE id_autor_curtida_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_curriculo WHERE id_autor_denuncia_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_curriculo WHERE id_autor_comentario_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_curriculo WHERE id_autor_curriculo_curtido = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_curriculo WHERE id_autor_curriculo_denunciado = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_curriculo WHERE id_autor_curriculo_comentado = '$idUsuario'");

					$mysqli->query("DELETE FROM tb_curtida_vaga WHERE id_autor_curtida_vaga = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_vaga WHERE id_autor_denuncia_vaga = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_vaga WHERE id_autor_comentario_vaga = '$idUsuario'");

					$mysqli->query("DELETE FROM tb_candidato WHERE id_candidato = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_projeto WHERE id_autor_projeto = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_curriculo WHERE id_autor_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_usuario WHERE cd_usuario = '$idUsuario'");	

					header('Location: ../alunos_adm.php');
				}else if($nivelUsuario == 2){
					$mysqli->query("DELETE FROM tb_curtida_projeto WHERE id_autor_curtida_projeto = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_projeto WHERE id_autor_denuncia_projeto = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_projeto WHERE id_autor_comentario_projeto = '$idUsuario'");
					
					$mysqli->query("DELETE FROM tb_curtida_curriculo WHERE id_autor_curtida_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_curriculo WHERE id_autor_denuncia_curriculo = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_curriculo WHERE id_autor_comentario_curriculo = '$idUsuario'");

					$mysqli->query("DELETE FROM tb_curtida_vaga WHERE id_autor_curtida_vaga = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_vaga WHERE id_autor_denuncia_vaga = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_vaga WHERE id_autor_comentario_vaga = '$idUsuario'");
					
					$mysqli->query("DELETE FROM tb_candidato WHERE id_autor_vaga_candidato = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_curtida_vaga WHERE id_autor_vaga_curtida = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_vaga WHERE id_autor_vaga_denunciada = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_comentario_vaga WHERE id_autor_vaga_comentada = '$idUsuario'");

					$mysqli->query("DELETE FROM tb_denuncia_usuario WHERE id_autor_denuncia_usuario = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_denuncia_usuario WHERE id_denuncia_usuario = '$idUsuario'");
					
					$mysqli->query("DELETE FROM tb_vaga WHERE id_autor_vaga = '$idUsuario'");
					$mysqli->query("DELETE FROM tb_usuario WHERE cd_usuario = '$idUsuario'");

					header('Location: ../empresa_adm.php');
				}else{
					header('Location: ../index.php');
				}
				
			}else{
				header('Location: ../home_adm.php');	
			}
		}
	}else{
		header('Location: ../index.php');
	}
?>
