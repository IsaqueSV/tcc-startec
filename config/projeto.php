<?php 
	include('../banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: ../index.php');
	}

	$idAutor = $_SESSION['cdUsuario'];

	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$idAutor'";
	$query = mysqli_query($mysqli, $sql);
	$row_usuario = mysqli_fetch_assoc($query);

	if(isset($_POST['nome-projeto']) AND isset($_POST['select-pchave'])){
		if(empty($_POST['nome-projeto']) OR empty($_POST['select-pchave'])){
			?>
			<script>
				history.go(-1);
			</script>
			<?php
		}else{
			$titulo = $_POST['nome-projeto'];
			$url_projeto = md5(uniqid(""));

			if($_POST['desc-projeto'] == ""){
				$descricao = "Descrição não declarada";
			}else{
				$descricao = $_POST['desc-projeto'];
			}

			if($_POST['github-diretorio'] == ""){
				$github = "Diretório Github do projeto não declarado";
			}else{
				if($_POST['github-diretorio'] == "Não declarado"){
					$github = "Diretório Github do projeto não declarado";
				}else{
					$github = "https://github.com/".$row_usuario['nm_github']."/".$_POST['github-diretorio'];
				} 
			}

			if($_POST['site-url'] == ""){
				$site = "Domínio do projeto não declarado";
			}else{
				$site = "https://".$_POST['site-url'];
			}
				
			foreach ($_FILES['arquivo']['name'] as $chave => $nome){
				if($nome == ""){
					$arquivos =  "Nenhum arquivo foi declarado";
				}else{
					$arquivos = "tem arquivo";
				}
			}
				
			if($arquivos == "Nenhum arquivo foi declarado" AND $github == "Diretório Github do projeto não declarado" AND $site == "Domínio do projeto não declarado"){
				?>
				<script>
					alert("Você deve preencher ao menos um dos seguintes campos: Diretório Github, Url do projeto ou Arquivo");
					history.go(-1);
				</script>
				<?php
			}else{
				$pchave = $_POST['select-pchave'];
				$sql = "SELECT * FROM tb_projeto";
				$query = mysqli_query($mysqli, $sql);

				if($github == "Diretório Github do projeto não declarado"){
					$sql_projeto = "INSERT INTO tb_projeto VALUES (null, '$titulo', '$descricao', '$site', 'Diretório Github do projeto não declarado', '$url_projeto', '$idAutor', '$pchave', '0', NOW())";
				}else{
					$sql_projeto = "INSERT INTO tb_projeto VALUES (null, '$titulo', '$descricao', '$site', '$github', '$url_projeto', '$idAutor', '$pchave', '0', NOW())";
				}

				if($resultado = $mysqli->query($sql_projeto)){
					$sql_consulta = "SELECT * FROM tb_projeto WHERE id_autor_projeto = '$idAutor' ORDER BY cd_projeto DESC LIMIT 1";
					$query_consulta = mysqli_query($mysqli, $sql_consulta);

					if($busca = mysqli_fetch_row($query_consulta)){
						$cdProjeto = $busca[0];
						if($arquivos == "tem arquivo"){
				    		foreach ($_FILES['arquivo']['name'] as $chave => $nome){
							
					    		$extensoes_permitidas = array('.zip','.rar');
					    		$extensao = strrchr($nome, '.');
					    		if(in_array($extensao, $extensoes_permitidas) === true){

									$novoNome = time() . "_" . $nome;
									move_uploaded_file($_FILES['arquivo']['tmp_name'][$chave], '../dados/arquivos/' . $novoNome);
									$caminho = 'dados/arquivos/' . $novoNome;
									
									mysqli_query($mysqli, "INSERT INTO tb_arquivo VALUES (null, '$nome', '$caminho', '$extensao', '$idAutor', '$cdProjeto', NOW())");

									$sql_arquivos = "SELECT * FROM tb_arquivo WHERE id_autor_arquivo = '$idAutor' AND id_projeto_arquivo = '$cdProjeto'";
									$query_arquivos = mysqli_query($mysqli, $sql_arquivos);
									$num_arquivos = mysqli_num_rows($query_arquivos);
									mysqli_query($mysqli, "UPDATE tb_projeto SET arquivos = '$num_arquivos' WHERE id_autor_projeto = '$idAutor'");
									?>
									<script>
										window.location.href = "../projetos_aluno.php";
									</script>
									<?php
								}
							}
						}else{
							?>
							<script>
								window.location.href = "../projetos_aluno.php";
							</script>
							<?php
						}
					}
			    }
			}
		}
	}else{
		?>
		<script>
			history.go(-1);
		</script>
		<?php
	}
?>