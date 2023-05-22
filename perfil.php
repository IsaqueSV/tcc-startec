<?php
    include('banco/conexao.php');
    session_start();

    if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel']) AND isset($_GET['see'])){
        if($_GET['see'] == "" OR $_SESSION['cdUsuario'] == "" OR $_SESSION['idNivel'] == ""){
            header('Location: index.php');
        }else{
            $cdUsuario = $_SESSION['cdUsuario'];
            $idNivel = $_SESSION['idNivel'];
            $url = $_GET['see'];

            $sql_usuario_pesquisado = "SELECT * FROM tb_usuario WHERE ds_url_usuario = '$url'";
            $query_usuario_pesquisado = mysqli_query($mysqli, $sql_usuario_pesquisado);
            $num_usuario_pesquisado = mysqli_num_rows($query_usuario_pesquisado);
            $row_usuario_pesquisado = mysqli_fetch_assoc($query_usuario_pesquisado);

            $confere = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
            $confere_query = mysqli_query($mysqli, $confere);
            $row_confere = mysqli_fetch_assoc($confere_query);

            if($row_confere['ds_url_usuario'] == $url){
                header('Location: meu_perfil.php');
            }

            if($num_usuario_pesquisado > 0){
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Perfil - <?php echo $row_usuario_pesquisado['nm_usuario']; ?></title>
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
                            margin: 2% 2% 0 2%;
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
                    <script>                    
                        $("#denuncia").fadeOut();
                        $("#modal-deletar-usuario-adm").fadeOut();

                        $("#btn-fecha-modal").click(function(){
                            $("#modal").fadeOut();
                        });

                    </script>
                </head>
                <body>

                <?php
                if($idNivel == 1){
                    $sql = "SELECT * FROM tb_usuario INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_nivel ON tb_usuario.id_nivel = tb_nivel.cd_nivel WHERE cd_usuario = '$cdUsuario' AND id_nivel = '$idNivel'";
                    $query = mysqli_query($mysqli, $sql);
                    $row = mysqli_fetch_assoc($query);

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

                        <nav class="nav nav-pills nav-justified" id="nav-navega">
                            <a class="nav-link p-3" id="a-navega-a" href="sobre_aluno.php">Quem somos</a>
                            <a class="nav-link p-3" id="a-navega-b" href="projetos_aluno.php">Projetos</a>
                            <a class="nav-link p-3" id="a-navega-c" href="escolas_aluno.php">Escolas</a>
                            <a class="nav-link p-3" id="a-navega-d" href="vagas_aluno.php">Vagas</a>
                            <a class="nav-link p-3" id="a-navega-e" href="curriculo_aluno.php">Meu currículo</a>
                            <a class="nav-link p-3" id="a-navega-f" href="ajuda_aluno.php">Ajuda</a>
                        </nav>

                        <?php
                            if($row_usuario_pesquisado['id_nivel'] == 1){
                                $sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec WHERE ds_url_usuario = '$url'";
                                $query_aluno = mysqli_query($mysqli, $sql_aluno);
                                $row_aluno = mysqli_fetch_assoc($query_aluno);

                                $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];
                                $projetos = "SELECT * FROM tb_projeto WHERE id_autor_projeto = '$cd_usuario_pesquisado'";

                                $query_projetos = mysqli_query($mysqli, $projetos);
                                $num_projetos = mysqli_num_rows($query_projetos);
                                ?>
                                <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">    
                                    <div class="banner">
                                        <label for="uploadImage">
                                            <img src="<?php echo $row_aluno['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                        </label>
                                    </div>
                                    <div id="dados">
                                        <div class="row">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="nome-usuario" style="margin-bottom: 1%;">Nome de usuário:</label>
                                                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_aluno['nm_usuario']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="nome-completo" style="margin-bottom: 1%;">Nome completo:</label>
                                                <input type="text" class="form-control" name="nome-completo" id="nome-completo" value="<?php echo $row_aluno['nm_completo']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_aluno['ds_email']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="github" style="margin-bottom: 1%;">Conta Github:</label>
                                                    <?php
                                                        if($row_aluno['nm_github'] == "Não declarado"){
                                                            ?>
                                                                <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                            <?php
                                                        }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade2" style="margin-right: 1%;">
                                                <label for="select-genero" class="form-label" style="margin-bottom: 1%;">Gênero:</label>
                                                <input type="text" id="select-genero" name="select-genero" class="form-control" value="<?php echo $row_aluno['nm_genero']; ?>" style="background-color: white;" readonly>
                                            </div>
                                            <div id="metade3" style="margin-left: 1%;">
                                                <label for="select-etec" class="form-label" style="margin-bottom: 1%;">ETEC frequentada:</label>
                                                <input type="text" id="select-etec" name="select-etec" class="form-control" value="<?php echo $row_aluno['nm_etec']; ?>"  style="background-color: white;" readonly>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                            <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_aluno['ds_descricao']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                    <div class="titulo" style="background-color: white;">
                                        Projetos postados
                                    </div>
                                    <?php
                                        if($num_projetos > 0){
                                            while($row_projetos = mysqli_fetch_assoc($query_projetos)){
                                                ?>
                                                    <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex; background-color: white;">
                                                        <div id="met1" style="padding: 0; width: 70%;">
                                                            <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_projetos['nm_projeto']; ?>" readonly>
                                                        </div>
                                                        <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                            <a href="projetos.php?see=<?php echo $row_projetos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                        </div>
                                                    </div>
                                                            <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                            <div id="met1" style="padding: 0; width: 100%;">
                                                                <label class="btn btn-light" style="margin: 0; border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Este usuário não possui nenhum projeto</label>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                    ?>
                                </div>

                                        <button id="btn-denunciar-perfil" class="btn btn-light" style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">Denunciar</button>
                             

                                    <script>
                                        $("#btn-denunciar-perfil").click(function(){
                                            $.ajax({
                                                url: "config/modal-denuncia-usuario.php",
                                                type: "POST",
                                                data: "usuarioPesquisado="+"<?php echo $row_usuario_pesquisado['cd_usuario']; ?>",
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
                                    </script>
                                <?php
                            }else if($row_usuario_pesquisado['id_nivel'] == 2){
                                $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];
                                $vagas = "SELECT * FROM tb_vaga WHERE id_autor_vaga = '$cd_usuario_pesquisado'";
                                $query_vagas = mysqli_query($mysqli, $vagas);
                                $num_vagas = mysqli_num_rows($query_vagas);
                                ?>
                                    <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">                                            <div class="banner">
                                            <label for="uploadImage">
                                                <img src="<?php echo $row_usuario_pesquisado['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                            </label>
                                        </div>
                                        <div id="dados">
                                            <div class="row">
                                                <div id="metade" style="width: 100%;">
                                                    <label for="nome-usuario" style="margin-bottom: 1%;">Nome da empresa:</label>
                                                    <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_usuario_pesquisado['nm_usuario']; ?>" readonly style="background-color: white;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1%;">
                                                <div id="metade" style="margin-right: 1%;">
                                                    <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_usuario_pesquisado['ds_email']; ?>" readonly style="background-color: white;">
                                                </div>
                                                <div id="metade" style="margin-left: 1%;">
                                                    <label for="github" style="margin-bottom: 1%;">CNPJ:</label>
                                                        <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_usuario_pesquisado['ds_cnpj']; ?>" readonly style="background-color: white;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1%;">
                                                <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                                <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_usuario_pesquisado['ds_descricao']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                        <div class="titulo" style="background-color: white;">
                                            Vagas postadas
                                        </div>
                                        <?php
                                            if($num_vagas > 0){
                                                while($row_vagas = mysqli_fetch_assoc($query_vagas)){
                                                    ?>
                                                        <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex; background-color: white;">
                                                            <div id="met1" style="padding: 0; width: 70%;">
                                                                <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_vagas['nm_vaga']; ?>" readonly>
                                                            </div>
                                                            <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                                <a href="vagas.php?see=<?php echo $row_vagas['ds_url_vaga']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                            </div>
                                                        </div>
                                                                <?php
                                                        }
                                                    }else{
                                                        ?>
                                                            <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                                <div id="met1" style="padding: 0; width: 100%;">
                                                                    <label class="btn btn-light" style="margin: 0; border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Este usuário não possui nenhuma vaga</label>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }
                                        ?>
                                    </div>

                                    
                                        <button id="btn-denunciar-perfil" class="btn btn-light" style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">Denunciar</button>
                                    
                                <script>
                                    $("#btn-denunciar-perfil").click(function(){
                                        $.ajax({
                                            url: "config/modal-denuncia-usuario.php",
                                            type: "POST",
                                            data: "usuarioPesquisado="+"<?php echo $row_usuario_pesquisado['cd_usuario']; ?>",
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
                                </script>
                                <?php
                            }else{
                                header('Location: index.php');
                            }
                        ?>
                    <?php
                }else if($idNivel == 2){
                    $sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario' AND id_nivel = '$idNivel'";
                    $query = mysqli_query($mysqli, $sql);
                    $row = mysqli_fetch_assoc($query);
                    
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

                            <nav class="nav nav-pills nav-justified" id="nav-navega">
                                <a class="nav-link p-3" id="a-navega-a" href="sobre_empresa.php">Quem somos</a>
                                <a class="nav-link p-3" id="a-navega-b" href="projetos_empresa.php">Projetos</a>
                                <a class="nav-link p-3" id="a-navega-c" href="escolas_empresa.php">Escolas</a>
                                <a class="nav-link p-3" id="a-navega-d" href="vagas_empresa.php">Minhas vagas</a>
                                <a class="nav-link p-3" id="a-navega-e" href="curriculos_empresa.php">Currículos</a>
                                <a class="nav-link p-3" id="a-navega-f" href="ajuda_empresa.php">Ajuda</a>
                            </nav>
                        <?php
                            if($row_usuario_pesquisado['id_nivel'] == 1){
                                $sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec WHERE ds_url_usuario = '$url'";
                                $query_aluno = mysqli_query($mysqli, $sql_aluno);
                                $row_aluno = mysqli_fetch_assoc($query_aluno);

                                $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];
                                $projetos = "SELECT * FROM tb_projeto WHERE id_autor_projeto = '$cd_usuario_pesquisado'";

                                $query_projetos = mysqli_query($mysqli, $projetos);
                                $num_projetos = mysqli_num_rows($query_projetos);
                                ?>
                                <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">                                         
                                    <div class="banner">
                                        <label for="uploadImage">
                                            <img src="<?php echo $row_aluno['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                        </label>
                                    </div>
                                    <div id="dados">
                                        <div class="row">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="nome-usuario" style="margin-bottom: 1%;">Nome de usuário:</label>
                                                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_aluno['nm_usuario']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="nome-completo" style="margin-bottom: 1%;">Nome completo:</label>
                                                <input type="text" class="form-control" name="nome-completo" id="nome-completo" value="<?php echo $row_aluno['nm_completo']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_aluno['ds_email']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="github" style="margin-bottom: 1%;">Conta Github:</label>
                                                    <?php
                                                        if($row_aluno['nm_github'] == "Não declarado"){
                                                            ?>
                                                                <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                            <?php
                                                        }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade2" style="margin-right: 1%;">
                                                <label for="select-genero" class="form-label" style="margin-bottom: 1%;">Gênero:</label>
                                                <input type="text" id="select-genero" name="select-genero" class="form-control" value="<?php echo $row_aluno['nm_genero']; ?>" style="background-color: white;" readonly>
                                            </div>
                                            <div id="metade3" style="margin-left: 1%;">
                                                <label for="select-etec" class="form-label" style="margin-bottom: 1%;">ETEC frequentada:</label>
                                                <input type="text" id="select-etec" name="select-etec" class="form-control" value="<?php echo $row_aluno['nm_etec']; ?>"  style="background-color: white;" readonly>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                            <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_aluno['ds_descricao']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                    <div class="titulo" style="background-color: white;">
                                        Projetos postados
                                    </div>
                                    <?php
                                        if($num_projetos > 0){
                                            while($row_projetos = mysqli_fetch_assoc($query_projetos)){
                                                ?>
                                                    <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex; background-color: white;">
                                                        <div id="met1" style="padding: 0; width: 70%;">
                                                            <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_projetos['nm_projeto']; ?>" readonly>
                                                        </div>
                                                        <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                            <a href="projetos.php?see=<?php echo $row_projetos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                        </div>
                                                    </div>
                                                            <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                            <div id="met1" style="padding: 0; width: 100%;">
                                                                <label class="btn btn-light" style="margin: 0; border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Este usuário não possui nenhum projeto</label>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                    ?>
                                </div>

                                    
                                        <button id="btn-denunciar-perfil" class="btn btn-light" style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">Denunciar</button>
                                    
                                    <script>
                                        $("#btn-denunciar-perfil").click(function(){
                                            $.ajax({
                                                url: "config/modal-denuncia-usuario.php",
                                                type: "POST",
                                                data: "usuarioPesquisado="+"<?php echo $row_usuario_pesquisado['cd_usuario']; ?>",
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
                                    </script>
                                <?php
                            }else if($row_usuario_pesquisado['id_nivel'] == 2){
                                $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];
                                $curtidas_projeto = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cd_usuario_pesquisado'";
                                $query_curtidas_projeto = mysqli_query($mysqli, $curtidas_projeto);
                                $num_curtidas_projeto = mysqli_num_rows($query_curtidas_projeto);
                                ?>
                                <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">     
                                    <div class="banner">
                                        <label for="uploadImage">
                                            <img src="<?php echo $row_usuario_pesquisado['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                        </label>
                                    </div>
                                    <div id="dados">
                                        <div class="row">
                                            <div id="metade" style="width: 100%;">
                                                <label for="nome-usuario" style="margin-bottom: 1%;">Nome da empresa:</label>
                                                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_usuario_pesquisado['nm_usuario']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_usuario_pesquisado['ds_email']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="github" style="margin-bottom: 1%;">CNPJ:</label>
                                                    <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_usuario_pesquisado['ds_cnpj']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                            <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_usuario_pesquisado['ds_descricao']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                               
                                    <button id="btn-denunciar-perfil" class="btn btn-light"style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">Denunciar</button>
                                
                                <script>
                                    $("#btn-denunciar-perfil").click(function(){
                                        $.ajax({
                                            url: "config/modal-denuncia-usuario.php",
                                            type: "POST",
                                            data: "usuarioPesquisado="+"<?php echo $row_usuario_pesquisado['cd_usuario']; ?>",
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
                                </script>
                                <?php
                            }else{
                                header('Location: index.php');
                            }
                        ?>

                    <?php
                }else{
                    $sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario' AND id_nivel = '3'";
                    $query = mysqli_query($mysqli, $sql);
                    $row = mysqli_fetch_assoc($query);

                    $img_caminho = $row['path_foto_usuario'];
                        ?>
                           <!-- Navbar (topo) -->
                            <nav class="navbar" id="nav-topo">
                                <div class="container-fluid" id="div-topo">
                                    <a class="navbar-brand" href="home_adm.php" id="a-topo">
                                        STAR TEC
                                    </a>
                                    <ul class="nav justify-content-end" id="ul-topo">
                                        <li class="nav-item" id="li-topo">
                                            <a class="nav-link" title="Meu perfil" id="li-a" style="padding-right: 0; padding-left: 0;">
                                                <img src="<?php echo $img_caminho; ?>" id="li-img" class="rounded-circle" style="margin: 0; width: 40px; height: 40px;">
                                            </a>
                                        </li>
                                        <li class="nav-item" id="li-topo">
                                            <a class="nav-link" href="config/finaliza-sessao.php" id="a-sair" style="margin-left: 35px; margin-bottom: 0; margin-top: 15px;">Sair</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>

                           <!-- Navbar (navega) -->
                            <nav class="nav nav-pills nav-justified" id="nav-navega">
                                <a class="nav-link p-3" id="a-navega-a" href="alunos_adm.php">Alunos</a>
                                <a class="nav-link p-3" id="a-navega-b" href="empresa_adm.php">Empresas</a>
                                <a class="nav-link p-3" id="a-navega-c" href="projetos_adm.php">Projetos</a>
                                <a class="nav-link p-3" id="a-navega-d" href="vagas_adm.php">Vagas</a>
                                <a class="nav-link p-3" id="a-navega-f" href="curriculos_adm.php">Currículos</a>
                            </nav>
                        <?php
                        if($row_usuario_pesquisado['id_nivel'] == 1){
                            $sql_aluno = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec WHERE ds_url_usuario = '$url'";
                            $query_aluno = mysqli_query($mysqli, $sql_aluno);
                            $row_aluno = mysqli_fetch_assoc($query_aluno);

                            $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];

                            $projetos = "SELECT * FROM tb_projeto WHERE id_autor_projeto = '$cd_usuario_pesquisado'";
                            $query_projetos = mysqli_query($mysqli, $projetos);
                            $num_projetos = mysqli_num_rows($query_projetos);
                            ?>
                                <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">                                 
                                <div class="banner">
                                    <label for="uploadImage">
                                        <img src="<?php echo $row_aluno['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                    </label>
                                </div>
                                <div id="dados">
                                    <div class="row">
                                        <div id="metade" style="margin-right: 1%;">
                                            <label for="nome-usuario" style="margin-bottom: 1%;">Nome de usuário:</label>
                                            <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_aluno['nm_usuario']; ?>" readonly style="background-color: white;">
                                        </div>
                                        <div id="metade" style="margin-left: 1%;">
                                            <label for="nome-completo" style="margin-bottom: 1%;">Nome completo:</label>
                                            <input type="text" class="form-control" name="nome-completo" id="nome-completo" value="<?php echo $row_aluno['nm_completo']; ?>" readonly style="background-color: white;">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 1%;">
                                        <div id="metade" style="margin-right: 1%;">
                                            <label for="email" style="margin-bottom: 1%;">Email:</label>
                                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_aluno['ds_email']; ?>" readonly style="background-color: white;">
                                        </div>
                                        <div id="metade" style="margin-left: 1%;">
                                            <label for="github" style="margin-bottom: 1%;">Conta Github:</label>
                                                <?php
                                                    if($row_aluno['nm_github'] == "Não declarado"){
                                                        ?>
                                                            <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_aluno['nm_github']; ?>" readonly style="background-color: white;">
                                                        <?php
                                                    }
                                                ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 1%;">
                                        <div id="metade2" style="margin-right: 1%;">
                                            <label for="select-genero" class="form-label" style="margin-bottom: 1%;">Gênero:</label>
                                            <input type="text" id="select-genero" name="select-genero" class="form-control" value="<?php echo $row_aluno['nm_genero']; ?>" style="background-color: white;" readonly>
                                        </div>
                                        <div id="metade3" style="margin-left: 1%;">
                                            <label for="select-etec" class="form-label" style="margin-bottom: 1%;">ETEC frequentada:</label>
                                            <input type="text" id="select-etec" name="select-etec" class="form-control" value="<?php echo $row_aluno['nm_etec']; ?>"  style="background-color: white;" readonly>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 1%;">
                                        <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                        <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_aluno['ds_descricao']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                    <div class="titulo" style="background-color: white;">
                                        Projetos postados
                                    </div>
                                    <?php
                                        if($num_projetos > 0){
                                            while($row_projetos = mysqli_fetch_assoc($query_projetos)){
                                                ?>
                                                    <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex; background-color: white;">
                                                        <div id="met1" style="padding: 0; width: 70%;">
                                                            <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_projetos['nm_projeto']; ?>" readonly>
                                                        </div>
                                                        <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                            <a href="projetos.php?see=<?php echo $row_projetos['ds_url_projeto']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                        </div>
                                                    </div>
                                                            <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                            <div id="met1" style="padding: 0; width: 100%;">
                                                                <label class="btn btn-light" style="margin: 0; border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Este usuário não possui nenhum projeto</label>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                    ?>
                                </div>

                                <?php
                                     $projetos_curtidos = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cd_usuario_pesquisado'";
                                    $query_projetos_curtidos = mysqli_query($mysqli, $projetos_curtidos);
                                    $num_projetos_curtidos = mysqli_num_rows($query_projetos_curtidos);

                                    $vagas_curtidas = "SELECT * FROM tb_curtida_vaga INNER JOIN tb_vaga ON tb_curtida_vaga.id_curtida_vaga = tb_vaga.cd_vaga WHERE id_autor_curtida_vaga = '$cd_usuario_pesquisado'";
                                    $query_vagas_curtidas = mysqli_query($mysqli, $vagas_curtidas);
                                    $num_vagas_curtidas = mysqli_num_rows($query_vagas_curtidas);
                                ?>
                                
                                <div class="curtidas" style="width: 80%; margin-left: 10%; margin-bottom: 0; margin-right: 10%; background-color: white; padding: 1%; border-radius: 3px;">
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
                                                        Este usuário ainda não curtiu nenhum projeto
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
                                                        Este usuário ainda não curtiu nenhuma vaga
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="btn-deletar-usuario btn btn-light" id="<?php echo $row_usuario_pesquisado['ds_url_usuario']; ?>" style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">
                                    Deletar
                                </div>  
                                    <script>
                                        $(".btn-deletar-usuario").click(function(){
                                            $id_usuario = $(this).attr('id');

                                            $.ajax({
                                                url: "config/modal-deletar-usuario-adm.php",
                                                type: "POST",
                                                data: "idUsuario="+$id_usuario + "&nivelUsuario="+"1",
                                                dataType: "html"
                                            }).done(function(resposta){
                                                $("#modal-deletar-usuario-adm").html(resposta);
                                                $("#modal-deletar-usuario-adm").fadeIn();
                                            }).fail(function(jqXHR, textStatus ){
                                                console.log("Request failed: " + textStatus);
                                                $("#modal-deletar-usuario-adm").fadeOut();
                                            }).always(function(){
                                                console.log("completou");
                                            });
                                        }) 
                                    </script>
                                <?php
                            }else if($row_usuario_pesquisado['id_nivel'] == 2){
                                $cd_usuario_pesquisado = $row_usuario_pesquisado['cd_usuario'];
                                $curtidas_projeto = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cd_usuario_pesquisado'";
                                $query_curtidas_projeto = mysqli_query($mysqli, $curtidas_projeto);
                                $num_curtidas_projeto = mysqli_num_rows($query_curtidas_projeto);
                                ?>
                                <div style="width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; padding-top: 0.5%; padding-bottom: 3%; margin-top: 2%; border-radius: 3px;">                                        
                                    <div class="banner">
                                        <label for="uploadImage">
                                            <img src="<?php echo $row_usuario_pesquisado['path_foto_usuario']; ?>" class="rounded-circle" id="uploadPreview" style="border: 1px solid;">
                                        </label>
                                    </div>
                                    <div id="dados">
                                        <div class="row">
                                            <div id="metade" style="width: 100%;">
                                                <label for="nome-usuario" style="margin-bottom: 1%;">Nome da empresa:</label>
                                                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" value="<?php echo $row_usuario_pesquisado['nm_usuario']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <div id="metade" style="margin-right: 1%;">
                                                <label for="email" style="margin-bottom: 1%;">Email:</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $row_usuario_pesquisado['ds_email']; ?>" readonly style="background-color: white;">
                                            </div>
                                            <div id="metade" style="margin-left: 1%;">
                                                <label for="github" style="margin-bottom: 1%;">CNPJ:</label>
                                                    <input type="text" class="form-control" name="github" id="github" placeholder="<?php echo $row_usuario_pesquisado['ds_cnpj']; ?>" readonly style="background-color: white;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1%;">
                                            <label for="descricao-text" class="form-label" style="padding: 0; margin-bottom: 1%;">Descrição:</label>
                                            <textarea readonly class="form-control" name="descricao" id="descricao-text" rows="6" placeholder="Digite uma breve descrição sobre você" style="background-color: white;"><?php echo $row_usuario_pesquisado['ds_descricao']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $projetos_curtidos = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_projeto ON tb_curtida_projeto.id_curtida_projeto = tb_projeto.cd_projeto WHERE id_autor_curtida_projeto = '$cd_usuario_pesquisado'";
                                    $query_projetos_curtidos = mysqli_query($mysqli, $projetos_curtidos);
                                    $num_projetos_curtidos = mysqli_num_rows($query_projetos_curtidos);

                                    $curriculos_curtidos = "SELECT * FROM tb_curtida_curriculo INNER JOIN tb_curriculo ON tb_curtida_curriculo.id_curtida_curriculo = tb_curriculo.cd_curriculo WHERE id_autor_curtida_curriculo = '$cd_usuario_pesquisado'";
                                    $query_curriculos_curtidos = mysqli_query($mysqli, $curriculos_curtidos);
                                    $num_curriculos_curtidos = mysqli_num_rows($query_curriculos_curtidos);

                                    $vagas = "SELECT * FROM tb_vaga WHERE id_autor_vaga = '$cd_usuario_pesquisado'";
                                    $query_vagas = mysqli_query($mysqli, $vagas);
                                    $num_vagas = mysqli_num_rows($query_vagas);
                                ?>

                                <div class="projetos" style="padding: 1%; width: 80%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 3px;">
                                            <div class="titulo" style="background-color: white;">
                                                Vagas postadas
                                            </div>
                                            <?php
                                                if($num_vagas > 0){
                                                    while($row_vagas = mysqli_fetch_assoc($query_vagas)){
                                                        ?>
                                                            <div class="conteudo-projetos" style="width: 100%; margin-bottom: 0.5%; display: flex; background-color: white;">
                                                                <div id="met1" style="padding: 0; width: 70%;">
                                                                    <input type="text" class="btn btn-light" style="border-radius: 0; background-color: white; height: 50px; border: 1px solid #DCDCDC; width: 100%;" value="<?php echo $row_vagas['nm_vaga']; ?>" readonly>
                                                                </div>
                                                                <div id="met2" style="padding: 0; width: 30%; display: flex;">
                                                                    <a href="vagas.php?see=<?php echo $row_vagas['ds_url_vaga']; ?>" class="btn btn-light" style="border-radius: 0; padding-top: 10px; border-top: 1px solid #DCDCDC; border-bottom: 1px solid #DCDCDC; border-right: 1px solid #DCDCDC; width: 100%;">Visualizar</a>
                                                                </div>
                                                            </div>
                                                                    <?php
                                                            }
                                                        }else{
                                                            ?>
                                                                <div class="conteudo-projetos" style="width: 100%; display: flex;">
                                                                    <div id="met1" style="padding: 0; width: 100%;">
                                                                        <label class="btn btn-light" style="margin: 0; border-radius: 0; background-color: white; height: 50px; padding-top: 10px; border: 1px solid #DCDCDC; color: gray; width: 100%;">Este usuário não possui nenhuma vaga</label>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                            ?>
                                        </div>

                                <div class="curtidas" style="width: 80%; margin-left: 10%; margin-right: 10%; margin-bottom: 0; background-color: white; padding: 1%; border-radius: 3px;">
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
                                                            Este usuário ainda não curtiu nenhum projeto
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
                                                            Este usuário ainda não curtiu nenhum currículo
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <div class="btn-deletar-usuario btn btn-light" id="<?php echo $row_usuario_pesquisado['ds_url_usuario']; ?>" style="width: 80%; height: border: 1px solid #DCDCDC; margin-top: 3%; margin-left: 10%; margin-right: 10%; margin-bottom: 3%; padding-top: 1%; padding-bottom: 1%;">
                                            Deletar
                                </div>   
                                <script>
                                    $(".btn-deletar-usuario").click(function(){
                                        $id_usuario = $(this).attr('id');

                                        $.ajax({
                                            url: "config/modal-deletar-usuario-adm.php",
                                            type: "POST",
                                            data: "idUsuario="+$id_usuario + "&nivelUsuario="+"2",
                                            dataType: "html"
                                        }).done(function(resposta){
                                            $("#modal-deletar-usuario-adm").html(resposta);
                                            $("#modal-deletar-usuario-adm").fadeIn();
                                        }).fail(function(jqXHR, textStatus ){
                                            console.log("Request failed: " + textStatus);
                                            $("#modal-deletar-usuario-adm").fadeOut();
                                        }).always(function(){
                                            console.log("completou");
                                        });
                                    }) 
                                </script>
                                <?php
                            }else{
                                header('Location: index.php');
                            }
                }
                ?>

                    <div class="modal" tabindex="-1" id="modal-deletar-usuario-adm"></div>
                    <div class="modal" tabindex="-1" id="denuncia"></div>
                </body>
                </html>
                <?php
            }else{
                header('Location: index.php');
            }
        }
    }else{
        header('Location: index.php');
    }
?>