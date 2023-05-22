<?php
    include('banco/conexao.php');
    session_start();

    if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
        if($_SESSION['cdUsuario'] == "" OR $_SESSION['idNivel'] == ""){
            header('Location: ../index.php');
        }else{
            $cdUsuario = $_SESSION['cdUsuario'];
            $idNivel = $_SESSION['idNivel'];

            if($idNivel == 1){
                $sql = "SELECT * FROM tb_usuario INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE cd_usuario = '$cdUsuario' AND id_nivel = '$idNivel'";
                $query = mysqli_query($mysqli, $sql);
                $row = mysqli_fetch_assoc($query);    
            }else if($idNivel == 2){
                $sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario' AND id_nivel = '$idNivel'";
                $query = mysqli_query($mysqli, $sql);
                $row = mysqli_fetch_assoc($query);    
            }else{
                $sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario' AND id_nivel = '$idNivel'";
                $query = mysqli_query($mysqli, $sql);
                $row = mysqli_fetch_assoc($query);    
            }
            
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Meu perfil</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
                <!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
                <!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
                <!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
                <!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
                <!-- Jquery Mask <script src="css/local/js/jquery.mask.min.js"></script> -->
                <!-- CSS --><link rel="stylesheet" href="css/navbar.css">
                <!-- CSS --><link rel="stylesheet" href="css/geral.css">
                <!-- CSS --><link rel="stylesheet" href="css/footer.css">
                <script>
                    function PreviewImage(){
                        var oFReader = new FileReader();
                        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

                        oFReader.onload = function (oFREvent) {
                            document.getElementById("uploadPreview").src = oFREvent.target.result;
                        };
                    };

                </script>
            </head>
            <body>
                <?php
                    if($idNivel == 1){
                        $curriculo = "SELECT * FROM tb_curriculo WHERE id_autor_curriculo = '$cdUsuario'";
                        $query_curriculo = mysqli_query($mysqli, $curriculo);
                        $num_curriculo = mysqli_num_rows($query_curriculo);
                        $row_curriculo = mysqli_fetch_assoc($query_curriculo);

                        $projetos = "SELECT * FROM tb_projeto WHERE id_autor_projeto = '$cdUsuario'";
                        $query_projetos = mysqli_query($mysqli, $projetos);
                        $num_projetos = mysqli_num_rows($query_projetos);

                        $projetos_curtidos = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cdUsuario'";
                        $query_projetos_curtidos = mysqli_query($mysqli, $projetos_curtidos);
                        $num_projetos_curtidos = mysqli_num_rows($query_projetos_curtidos);

                        $vagas_curtidas = "SELECT * FROM tb_curtida_vaga INNER JOIN tb_vaga ON tb_curtida_vaga.id_curtida_vaga = tb_vaga.cd_vaga WHERE id_autor_curtida_vaga = '$cdUsuario'";
                        $query_vagas_curtidas = mysqli_query($mysqli, $vagas_curtidas);
                        $num_vagas_curtidas = mysqli_num_rows($query_vagas_curtidas);

                        $sql_genero = "SELECT * FROM tb_genero WHERE cd_genero = 1 OR cd_genero = 2 OR cd_genero = 3 OR cd_genero = 4";
                        $query_genero = mysqli_query($mysqli, $sql_genero);

                        $img_caminho = $row['path_foto_usuario'];
                        ?>
                            <nav class="navbar" id="nav-topo">
                                <div class="container-fluid" id="div-topo">
                                    <a class="navbar-brand" href="home_aluno.php" id="a-topo">
                                        STAR TEC
                                    </a>
                                    <ul class="nav justify-content-end" id="ul-topo">
                                        <li class="nav-item" id="li-topo">
                                            <a class="nav-link" title="Meu perfil" id="li-a" href="meu_perfil.php" style="padding-right: 0; padding-left: 0;">
                                                <img src="<?php echo $img_caminho; ?>" id="li-img" class="rounded-circle" style="margin: 0; width: 40px; height: 40px;">
                                            </a>
                                        </li>
                                        <li class="nav-item" id="li-topo">
                                            <a class="nav-link" href="config/finaliza-sessao.php" id="a-sair" style="margin-left: 35px; margin-bottom: 0; margin-top: 15px;">Sair</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>

                            <form method="post" action="config/atualiza-dados-perfil.php" enctype="multipart/form-data">
                                 <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 2%; margin-top: 2%; border-radius: 3px;"> 
                                    <div class="banner">
                                        <label for="uploadImage">
                                               <img src="<?php echo $row['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                        </label>
                                        <input id="uploadImage" accept=".jpg,.png" type="file" name="foto" onchange="PreviewImage();" style="display: none;" disabled>
                                    </div>
                                    
                                    <div id="dados">
                                        <div class="row">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="nome-usuario" style="margin-bottom: 1%;">Nome de usuário:</label>
                                                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row['nm_usuario']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="nome-completo" style="margin-bottom: 1%;">Nome completo:</label>
                                                <input type="text" class="form-control" name="nome-completo" id="nome-completo" value="<?php echo $row['nm_completo']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['ds_email']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="github" style="margin-bottom: 1%;">Conta Github:</label>
                                                <?php
                                                    if($row['nm_github'] == "Não declarado"){
                                                        ?>
                                                            <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row['nm_github']; ?>" readonly style="background-color: white;">
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row['nm_github']; ?>" readonly value="<?php echo $row['nm_github']; ?>" style="background-color: white;">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade2" style="margin-right: 1%;">
                                                <label for="select-genero" class="form-label" style="margin-bottom: 1%;">Gênero:</label>
                                                <input type="text" id="text-genero-vazio" name="text-genero-vazio" class="form-select" value="<?php echo $row['nm_genero']; ?>" readonly>
                                                            
                                                <select id="select-genero-vazio" style="display: none;" name="select-genero-vazio" class="form-select" readonly>
                                                    <option value="<?php echo $row['cd_genero']; ?>" selected><?php echo $row['nm_genero']; ?></option>
                                                        <?php
                                                            while($row_chave = mysqli_fetch_assoc($query_genero)){
                                                            ?>
                                                                <option value="<?php echo $row_chave['cd_genero']; ?>"><?php echo $row_chave['nm_genero']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                            <div id="metade3" style="margin-left: 1%;">
                                                <label for="select-etec" class="form-label" style="margin-bottom: 1%;">ETEC frequentada:</label>
                                                <input type="text" id="select-etec" name="select-etec" class="form-control" value="<?php echo $row['nm_etec']; ?>" style="background-color: white;" readonly>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                            <?php
                                                if($row['ds_descricao'] == "Descrição não declarada"){
                                                ?>
                                                    <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="<?php echo $row['ds_descricao']; ?>" style="background-color: white;"></textarea>
                                                <?php
                                                }else{
                                                ?>
                                                    <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Escreva um pouco sobre você" style="background-color: white;"><?php echo $row['ds_descricao']; ?></textarea>
                                                <?php
                                                }
                                            ?>
                                        </div>

                                        <div class="row" style="margin-top: 2%;">
                                            <div id="met1" style="padding: 0; width: 100%;">
                                                <a id="btn-editar-perfil" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">Editar perfil</a>
                                                <div class="caixa-opc" style="display: none;">
                                                    <a id="btn-cancelar-alteracoes" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">Cancelar</a>
                                                    <input type="submit" value="Salvar alterações" id="btn-salvar-alteracoes" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <script>
                                        $("#criar-curriculo-btn").click(function(){
                                            window.location.href = "criar_curriculo.php";
                                        });
                                        $("#btn-editar-perfil").click(function(){
                                            $("#btn-editar-perfil").css("display", "none");
                                            $(".caixa-opc").css("display", "flex");
                                            $("#nome-completo").css("background-color", "");
                                            $("#select-etec").css("background-color", "");
                                            $("#select-genero").css("background-color", "");
                                            $("#text-genero-vazio").css("display", "none");
                                            $("#select-genero-vazio").css("display", "");
                                            document.getElementById('uploadImage').removeAttribute('disabled');
                                            document.getElementById('nome-usuario').removeAttribute('readonly');
                                            document.getElementById('email').removeAttribute('readonly');
                                            document.getElementById('github').removeAttribute('readonly');
                                            document.getElementById('descricao-text').removeAttribute('readonly');
                                        });
                                        $("#btn-cancelar-alteracoes").click(function(){
                                            $("#btn-editar-perfil").css("display", "");
                                            $(".caixa-opc").css("display", "none");
                                            $("#nome-completo").css("background-color", "white");
                                            $("#select-etec").css("background-color", "white");
                                            $("#select-genero").css("background-color", "white");
                                            $("#text-genero-vazio").css("display", "");
                                            $("#select-genero-vazio").css("display", "none");
                                            document.getElementById('uploadImage').setAttribute('disabled', '');
                                            document.getElementById('select-genero-vazio').setAttribute('readonly', '');
                                            document.getElementById('nome-usuario').setAttribute('readonly', '');
                                            document.getElementById('email').setAttribute('readonly', '');
                                            document.getElementById('github').setAttribute('readonly', '');
                                            document.getElementById('descricao-text').setAttribute('readonly', '');
                                        });
                                    </script>

                                    <div style="width: 80%; margin-left: 10%; margin-right: 10%; display: flex; margin-top: 4%; margin-bottom: 3%;">
                                        <?php
                                            if($num_curriculo > 0){
                                                ?>
                                                    <div id="met1" style="padding: 0; width: 70%;">
                                                        <input type="text" class="btn btn-light" style="border-radius: 0; border-top-left-radius: 3px; border-bottom-left-radius: 3px; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="MEU CURRÍCULO" readonly>
                                                    </div>
                                                    <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                        <a href="curriculos.php?see=<?php echo $row_curriculo['ds_url_curriculo']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Visualizar</a>
                                                        <a href="editar_curriculo.php?see=<?php echo $row_curriculo['ds_url_curriculo']; ?>" class="btn btn-light" style="border-radius: 0; border-top-right-radius: 3px; border-bottom-right-radius: 3px; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Editar</a>
                                                    </div>
                                                <?php
                                            }else{
                                                ?>
                                                    <div id="met1" style="padding: 0; width: 100%;">
                                                        <a href="criar_curriculo.php" class="btn btn-light" style="border-radius: 0; background-color: white; border: 1px solid #DCDCDC; width: 100%; padding-top: 20px; padding-bottom: 20px;">Criar currículo</a>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>

                                <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                    <div class="titulo" style="margin-bottom: 0.5%;">
                                        Meus projetos
                                    </div>
                                        <?php
                                            if($num_projetos > 0){
                                                while($row_projetos = mysqli_fetch_assoc($query_projetos)){
                                                    ?>
                                                    <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex;">
                                                        <div id="met1" style="padding: 0; width: 70%;">
                                                            <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_projetos['nm_projeto']; ?>" readonly>
                                                        </div>
                                                        <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                            <a href="editar_projeto.php?see=<?php echo $row_projetos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Editar</a>
                                                            <a href="config/excluir_projeto.php?see=<?php echo $row_projetos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Excluir</a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                    <div id="met1" style="padding: 0; width: 100%;">
                                                        <label class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Você não possui nenhum projeto</label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    <div class="criar" style="width: 100%;">
                                        <a href="criar_projeto.php" class="btn btn-light" style="text-decoration: none; color: black; height: 50px; border: 1px solid #DCDCDC; border-radius: 0; width: 100%; padding-top: 10px;">Criar projeto</a>
                                    </div>   
                                </div>

                                <div class="curtidas" style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding: 1%; border-radius: 3px;">
                                    <div class="projetos_curtidos_esquerda">
                                        <?php
                                            if($num_projetos_curtidos > 0){
                                                ?>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                        Projetos curtidos
                                                    </div>
                                                    <?php
                                                        while($row_projetos_curtidos = mysqli_fetch_assoc($query_projetos_curtidos)){
                                                            ?>
                                                                <div class="lin" style="display: flex;">    
                                                                    <div id="met1" style="padding: 0; width: 70%; ">
                                                                        <label class="btn btn-light" style="border-radius: 0; background-color: white; border: 1px solid #DCDCDC; width: 100%;"><?php echo $row_projetos_curtidos['nm_projeto']; ?></label>
                                                                    </div>
                                                                    <div id="met2" style="padding: 0; width: 30%;">
                                                                        <a href="projetos.php?see=<?php echo $row_projetos_curtidos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                <?php
                                            }else{
                                                ?>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                        Projetos curtidos
                                                    </div>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; color: gray;">
                                                        Você ainda não curtiu nenhum projeto
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="vagas_curtidas_direita">
                                        <?php
                                            if($num_vagas_curtidas > 0){
                                                ?>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                        Vagas curtidas
                                                    </div>
                                                    <?php
                                                        while($row_vagas_curtidas = mysqli_fetch_assoc($query_vagas_curtidas)){
                                                            ?>
                                                                <div class="lin" style="display: flex;">    
                                                                    <div id="met1" style="padding: 0; width: 70%;">
                                                                        <label class="btn btn-light" style="border-radius: 0; background-color: white; border: 1px solid #DCDCDC; width: 100%;"><?php echo $row_vagas_curtidas['nm_vaga']; ?></label>
                                                                    </div>
                                                                    <div id="met2" style="padding: 0; width: 30%;">
                                                                        <a href="vagas.php?see=<?php echo $row_vagas_curtidas['ds_url_vaga']; ?>" class="btn btn-light" style="border-radius: 0; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                <?php
                                            }else{
                                                ?>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 0.5%;">
                                                        Vagas curtidas
                                                    </div>
                                                    <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 0.5%; color: gray;">
                                                        Você ainda não curtiu nenhuma vaga
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </form>
                            
                            <style>
                                div.banner{
                                    width: 96%;
                                    height: 220px;
                                    margin: 3% 2% 7% 2%;
                                    border: 1px solid white;
                                    border-radius: 4px;
                                    background-color: black;
                                }
                                div.banner img{
                                    width: 200px;
                                    height: 200px;
                                    margin-top: 30%;
                                    margin-left: 30%;
                                    border: 2px solid;
                                }
                                div.row{
                                    width: 96%;
                                    display: flex;
                                    margin-left: 2%;
                                    margin-right: 2%;
                                    padding: 0;
                                }
                                div.row div#metade{
                                    width: 49%;
                                    padding: 0;
                                }
                                div.row div#metade2{
                                    width: 45%;
                                    padding: 0;
                                }
                                div.row div#metade3{
                                    width: 53%;
                                    padding: 0;
                                }
                                div.projetos{
                                    width: 96%;
                                    margin: 2% 2% 5% 2%;
                                }
                                div.projetos div.titulo{
                                    border: 1px solid #DCDCDC;
                                    padding-top: 1%;
                                    padding-bottom: 1%;
                                    text-align: center;
                                }
                                div.curtidas{
                                    width: 96%;
                                    margin: 2% 2% 5% 2%;
                                    display: flex;
                                }
                                div.curtidas div.projetos_curtidos_esquerda{
                                    width: 49%;
                                    margin-right: 1%;
                                }
                                div.curtidas div.vagas_curtidas_direita{
                                    width: 49%;
                                    margin-left: 1%;
                                }
                            </style>
                        <?php
                    }else if($idNivel == 2){
                            $vagas = "SELECT * FROM tb_vaga WHERE id_autor_vaga = '$cdUsuario'";
                            $query_vagas = mysqli_query($mysqli, $vagas);
                            $num_vagas = mysqli_num_rows($query_vagas);

                            $projetos_curtidos = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cdUsuario'";
                            $query_projetos_curtidos = mysqli_query($mysqli, $projetos_curtidos);
                            $num_projetos_curtidos = mysqli_num_rows($query_projetos_curtidos);

                            $curriculos_curtidos = "SELECT * FROM tb_curtida_curriculo INNER JOIN tb_curriculo ON tb_curtida_curriculo.id_curtida_curriculo = tb_curriculo.cd_curriculo WHERE id_autor_curtida_curriculo = '$cdUsuario'";
                            $query_curriculos_curtidos = mysqli_query($mysqli, $curriculos_curtidos);
                            $num_curriculos_curtidos = mysqli_num_rows($query_curriculos_curtidos);

                            $img_caminho = $row['path_foto_usuario'];
                            ?>
                                <nav class="navbar" id="nav-topo">
                                    <div class="container-fluid" id="div-topo">
                                        <a class="navbar-brand" href="home_aluno.php" id="a-topo">
                                            STAR TEC
                                        </a>
                                        <ul class="nav justify-content-end" id="ul-topo">
                                            <li class="nav-item" id="li-topo">
                                                <a class="nav-link" title="Meu perfil" id="li-a" href="meu_perfil.php" style="padding-right: 0; padding-left: 0;">
                                                    <img src="<?php echo $img_caminho; ?>" id="li-img" class="rounded-circle" style="margin: 0; width: 40px; height: 40px;">
                                                </a>
                                            </li>
                                            <li class="nav-item" id="li-topo">
                                                <a class="nav-link" href="config/finaliza-sessao.php" id="a-sair" style="margin-left: 35px; margin-bottom: 0; margin-top: 15px;">Sair</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>

                                <form method="post" action="config/atualiza-dados-perfil.php" enctype="multipart/form-data">
                                    <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 2%; margin-top: 2%; border-radius: 3px;"> 
                                        <div class="banner">
                                            <label for="uploadImage">
                                                   <img src="<?php echo $row['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                            </label>
                                            <input id="uploadImage" accept=".jpg,.png" type="file" name="foto" onchange="PreviewImage();" style="display: none;" disabled>
                                        </div>
                                        
                                        <div id="dados">
                                            <div class="row">
                                                <div id="metade" style="width: 100%;">
                                                    <label for="nome-usuario" style="margin-bottom: 0.5%;">Nome da empresa:</label>
                                                    <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row['nm_usuario']; ?>" readonly style="background-color: white;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1%;">
                                                <div id="metade" style="margin-right: 1%;">
                                                    <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['ds_email']; ?>" readonly style="background-color: white;">
                                                </div>
                                                <div id="metade" style="margin-left: 1%;">
                                                    <label for="cnpj" style="margin-bottom: 1%;">CNPJ:</label>
                                                    <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="<?php echo $row['ds_cnpj']; ?>" readonly style="background-color: white;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1%;">
                                                <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                                <?php
                                                    if($row['ds_descricao'] == "Descrição não declarada"){
                                                    ?>
                                                        <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="<?php echo $row['ds_descricao']; ?>" style="background-color: white;"></textarea>
                                                    <?php
                                                    }else{
                                                    ?>
                                                        <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Escreva um pouco sobre você" style="background-color: white;"><?php echo $row['ds_descricao']; ?></textarea>
                                                    <?php
                                                    }
                                                ?>
                                            </div>

                                            <div class="row" style="margin-top: 2%;">
                                                <div id="met1" style="padding: 0; width: 100%;">
                                                    <a id="btn-editar-perfil" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">Editar perfil</a>
                                                    <div class="caixa-opc" style="display: none;">
                                                        <a id="btn-cancelar-alteracoes" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">Cancelar</a>
                                                        <input type="submit" value="Salvar alterações" id="btn-salvar-alteracoes" class="btn btn-light" style="border-radius: 0; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <script>
                                            $("#btn-editar-perfil").click(function(){
                                                $("#btn-editar-perfil").css("display", "none");
                                                $(".caixa-opc").css("display", "flex");
                                                $("#cnpj").css("background-color", "");
                                                document.getElementById('uploadImage').removeAttribute('disabled');
                                                document.getElementById('nome-usuario').removeAttribute('readonly');
                                                document.getElementById('email').removeAttribute('readonly');
                                                document.getElementById('descricao-text').removeAttribute('readonly');
                                            });
                                            $("#btn-cancelar-alteracoes").click(function(){
                                                $("#btn-editar-perfil").css("display", "");
                                                $(".caixa-opc").css("display", "none");
                                                $("#cnpj").css("background-color", "white");
                                                document.getElementById('uploadImage').setAttribute('disabled', '');
                                                document.getElementById('nome-usuario').setAttribute('readonly', '');
                                                document.getElementById('email').setAttribute('readonly', '');
                                                document.getElementById('descricao-text').setAttribute('readonly', '');
                                            });
                                        </script>
                                  <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                        <div class="titulo" style="margin-bottom: 0.5%;">
                                            Minhas vagas
                                        </div>
                                            <?php
                                                if($num_vagas > 0){
                                                    while($row_vagas = mysqli_fetch_assoc($query_vagas)){
                                                        ?>
                                                        <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex;">
                                                            <div id="met1" style="padding: 0; width: 70%;">
                                                                <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_vagas['nm_vaga']; ?>" readonly>
                                                            </div>
                                                            <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                                <a href="editar_vaga.php?see=<?php echo $row_vagas['ds_url_vaga']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Editar</a>
                                                                <a href="config/excluir_vaga.php?see=<?php echo $row_vagas['ds_url_vaga']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 50%;">Excluir</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                        <div id="met1" style="padding: 0; width: 100%;">
                                                            <label class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Você não possui nenhuma vaga</label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        <div class="criar" style="width: 100%;">
                                            <a href="criar_vaga.php" class="btn btn-light" style="text-decoration: none; color: black; height: 50px; border: 1px solid #DCDCDC; border-radius: 0; width: 100%; padding-top: 10px;">Criar vaga</a>
                                        </div>   
                                    </div>

                                    <div class="curtidas" style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding: 1%; border-radius: 3px;">
                                        <div class="projetos_curtidos_esquerda">
                                            <?php
                                                if($num_projetos_curtidos > 0){
                                                    ?>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                            Projetos curtidos
                                                        </div>
                                                        <?php
                                                            while($row_projetos_curtidos = mysqli_fetch_assoc($query_projetos_curtidos)){
                                                                ?>
                                                                    <div class="lin" style="display: flex;">    
                                                                        <div id="met1" style="padding: 0; width: 70%; ">
                                                                            <label class="btn btn-light" style="border-radius: 0; background-color: white; border: 1px solid #DCDCDC; width: 100%;"><?php echo $row_projetos_curtidos['nm_projeto']; ?></label>
                                                                        </div>
                                                                        <div id="met2" style="padding: 0; width: 30%;">
                                                                            <a href="projetos.php?see=<?php echo $row_projetos_curtidos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                            Projetos curtidos
                                                        </div>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; color: gray;">
                                                            Você ainda não curtiu nenhum projeto
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="vagas_curtidas_direita">
                                            <?php
                                                if($num_curriculos_curtidos > 0){
                                                    ?>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 1%;">
                                                            Currículos curtidos
                                                        </div>
                                                        <?php
                                                            while($row_curriculos_curtidos = mysqli_fetch_assoc($query_curriculos_curtidos)){
                                                                ?>
                                                                    <div class="lin" style="display: flex;">    
                                                                        <div id="met1" style="padding: 0; width: 70%;">
                                                                            <label class="btn btn-light" style="border-radius: 0; background-color: white; border: 1px solid #DCDCDC; width: 100%;"><?php echo $row_curriculos_curtidos['nm_completo_curriculo']; ?></label>
                                                                        </div>
                                                                        <div id="met2" style="padding: 0; width: 30%;">
                                                                            <a href="curriculos.php?see=<?php echo $row_curriculos_curtidos['ds_url_curriculo']; ?>" class="btn btn-light" style="border-radius: 0; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 0.5%;">
                                                            Currículos curtidos
                                                        </div>
                                                        <div class="titulo" style="border: 1px solid #DCDCDC; padding-top: 1%;padding-bottom: 1%; text-align: center; margin-bottom: 0.5%; color: gray;">
                                                            Você ainda não curtiu nenhum currículo
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                
                                <style>
                                    div.banner{
                                        width: 96%;
                                        height: 220px;
                                        margin: 3% 2% 7% 2%;
                                        border: 1px solid white;
                                        border-radius: 4px;
                                        background-color: black;
                                    }
                                    div.banner img{
                                        width: 200px;
                                        height: 200px;
                                        margin-top: 30%;
                                        margin-left: 30%;
                                        border: 2px solid;
                                    }
                                    div.row{
                                        width: 96%;
                                        display: flex;
                                        margin-left: 2%;
                                        margin-right: 2%;
                                        padding: 0;
                                    }
                                    div.row div#metade{
                                        width: 49%;
                                        padding: 0;
                                    }
                                    div.row div#metade2{
                                        width: 45%;
                                        padding: 0;
                                    }
                                    div.row div#metade3{
                                        width: 53%;
                                        padding: 0;
                                    }
                                    div.projetos{
                                        width: 96%;
                                        margin: 2% 2% 5% 2%;
                                    }
                                    div.projetos div.titulo{
                                        border: 1px solid #DCDCDC;
                                        padding-top: 1%;
                                        padding-bottom: 1%;
                                        text-align: center;
                                    }
                                    div.curtidas{
                                        width: 96%;
                                        margin: 2% 2% 5% 2%;
                                        display: flex;
                                    }
                                    div.curtidas div.projetos_curtidos_esquerda{
                                        width: 49%;
                                        margin-right: 1%;
                                    }
                                    div.curtidas div.vagas_curtidas_direita{
                                        width: 49%;
                                        margin-left: 1%;
                                    }
                                </style>
                            <?php
                    }else{
                        
                    }
                ?>
            </body>
            </html>
            <?php
        }
    }
?>