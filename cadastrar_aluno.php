<?php
    include('banco/conexao.php');
    session_start();
    if((isset($_SESSION['cdUsuario']) == true) and (isset($_SESSION['idNivel']) == true)){
        if($_SESSION['idNivel'] == 1){
            header('Location: home_aluno.php');
        }if($_SESSION['idNivel'] == 2){
            header('Location: home_empresa.php');
        }if($_SESSION['idNivel'] == 3){
            header('Location: home_adm.php');
        }
    }

    $result_genero = "SELECT * FROM tb_genero";
    $resultado_genero = mysqli_query($mysqli, $result_genero);
    $result_etec = "SELECT * FROM tb_etec";
    $resultado_etec = mysqli_query($mysqli, $result_etec);
    $result_escolaridade = "SELECT * FROM tb_escolaridade";
    $resultado_escolaridade = mysqli_query($mysqli, $result_escolaridade);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aluno</title>
    <!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
    <!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
    <!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
    <!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
    <!-- Jquery Mask --><script src="css/local/js/jquery.mask.min.js"></script>
    <!-- CSS --><link rel="stylesheet" href="css/login.css">
    <!-- CSS --><link rel="stylesheet" href="css/navbar.css">
    <!-- CSS --><link rel="stylesheet" href="css/geral.css">
    <!-- CSS --><link rel="stylesheet" href="css/footer.css">
    <!-- JS --><script src="js/versenha.js"></script>
    <!-- JS --><script src="js/versenha2.js"></script>
    <!-- JS --><script src="js/mask.js"></script>
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">JÁ TEM UMA CONTA?</h2>
                <p class="description description-primary">Clique no botão abaixo para logar</p>
                <button id="signin" class="btn btn-primary" style="padding-left: 0; padding-right: 0;">LOGIN</button>  
            </div>    
            <div class="second-column">
                <h2 class="title title-second" style="margin-bottom: 2%;">CRIAR CONTA</h2>
                <p class="description description-second"></p>
                <form method="post" action="config/cadastrar-aluno.php" class="form">
                    <label class="label-input">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" name="cad_nm_usuario" placeholder="Nome do usuário" onblur="validarUsuario()" id="cad_nm_usuario" required>
                    </label>
                    <span id="usuario-alert"></span><br>
                    
                    <label class="label-input">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" name="cad_nm_completo" placeholder="Nome completo" onblur="validarNome()" id="cad_nm_completo" required>
                    </label>
                    <span id="nome-alert"></span><br>

                    <label class="label-input">
                        <i class="far fa-envelope icon-modify"></i>
                       <input type="email" onblur="validarEmail()" name="cad_email" maxlength="100" placeholder="Email" id="cad_email" required>
                    </label>
                    <span id="email-alert"></span><br>
                    
                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" name="cad_senha" placeholder="Senha" maxlength="20" minlength="8" onblur="validarSenha()" required id="cad_senha">
                        <i class="fa-solid fa-eye" onclick="mostrarOcultarSenhaA()" style="margin-right: 3%;" id="versenhaA"></i><br>
                    </label>
                    <span id="senha-alert"></span><br>

                    <label class="label-input" style="background-color: white;">
                        <div id="escolaridade">
                            <select class="etec" onblur="validarEtec()" name="cad_etec" id="cad_etec" style="border: 0;" required>
                                <option value="" selected>Etec frequentada</option>
                                <?php 
                                    while($row_etec = mysqli_fetch_assoc($resultado_etec)){
                                        ?>
                                        <option value="<?php echo $row_etec['cd_etec']; ?>"><?php echo $row_etec['nm_etec']; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </label>
                    <span id="etec-alert"></span><br>

                    <button type="submit" class="btn btn-second" style="padding-left: 0; padding-right: 0;">REGISTRAR</button>        
                </form>
            </div><!-- second column -->
        </div><!-- first content -->
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">CRIE SUA CONTA</h2>
                <p class="description description-primary">Clique no botão abaixo para cadastrar-se</p>
                <button id="signup" class="btn btn-primary" style="padding-left: 0; padding-right: 0;">CADASTRAR</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second" style="margin-bottom: 2%;">BEM VINDO</h2>
                <form method="post" action="config/login_aluno.php" class="form">
                    <label class="label-input">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" onblur="validarEmailLogin()" name="log_email" id="log_email" placeholder="Email" required>
                    </label>
                    <span id="email-login-alert"></span><br>
                
                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" onblur="validarSenhaLogin()" name="log_senha" id="log_senha" placeholder="Senha" required>
                        <i class="fa-solid fa-eye" onclick="mostrarOcultarSenhaB()" style="margin-right: 3%;" id="versenhaB"></i><br>
                    </label>
                    <span id="senha-login-alert"></span><br>

                    
                    <div style="display: flex; width: 100%;">
                        <a href="index.php" class="btn btn-second" style="width: 48%; margin-right: 2%; text-align: center; text-decoration: none;">VOLTAR</a>
                        <button type="submit" class="btn btn-second" style="width: 48%; margin-left: 2%; padding-left: 0; padding-right: 0;">LOGAR</button>
                    </div>
                </form>
            </div><!-- second column -->
        </div><!-- second-content -->
    </div>
    <script src="js/app.js"></script>
    <script>
            function validarUsuario(){
            usuario = document.querySelector("#cad_nm_usuario").value;
            if(usuario == ""){
                document.getElementById("usuario-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#usuario-alert").css("color", "red");
                $("#usuario-alert").css("font-family", "arial");
                $("#usuario-alert").css("font-size", "13px");
                $("#usuario-alert").css("margin-left", "1%");
                $("#usuario-alert").css("padding", "0");
            }else{
                $.ajax({
                url: "config/valida-user.php",
                type: "POST",
                data: "nome="+$("#cad_nm_usuario").val(),
                dataType: "html"
                }).done(function(resposta){
                    $("#usuario-alert").html(resposta);
                    if($("#usuario-alert").html() == "Nome já cadastrado"){
                        $("#usuario-alert").css("color", "red");
                        $("#usuario-alert").css("font-family", "arial");
                        $("#usuario-alert").css("font-size", "13px");
                        $("#usuario-alert").css("margin-left", "1%");
                        $("#usuario-alert").css("padding", "0");
                    }if($("#usuario-alert").html() == "Nome disponível"){
                        $("#usuario-alert").css("color", "green");
                        $("#usuario-alert").css("font-family", "arial");
                        $("#usuario-alert").css("font-size", "13px");
                        $("#usuario-alert").css("margin-left", "1%");
                        $("#usuario-alert").css("padding", "0");
                    }if($("#usuario-alert").html() == "Nome inválido"){
                        $("#usuario-alert").css("color", "red");
                        $("#usuario-alert").css("font-family", "arial");
                        $("#usuario-alert").css("font-size", "13px");
                        $("#usuario-alert").css("margin-left", "1%");
                        $("#usuario-alert").css("padding", "0");
                    }
                }).fail(function(jqXHR, textStatus ){
                    console.log("Request failed: " + textStatus);
                }).always(function(){
                    console.log("completou");
                });
            }
        }

        function validarNome(){
            nome = document.querySelector("#cad_nm_completo").value;
            if(nome == ""){
                document.getElementById("nome-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#nome-alert").css("color", "red");
                $("#nome-alert").css("font-family", "arial");
                $("#nome-alert").css("font-size", "13px");
                $("#nome-alert").css("margin-left", "1%");
                $("#nome-alert").css("padding", "0");
            }else{
                document.getElementById("nome-alert").innerHTML = "";
                $("#nome-alert").css("color", "");
                $("#nome-alert").css("font-family", "");
                $("#nome-alert").css("font-size", "");
                $("#nome-alert").css("margin-left", "");
                $("#nome-alert").css("padding", "");
            }
        }

        function validarEmail(){
            email = document.querySelector("#cad_email");
            if(email.value == ""){
                document.getElementById("email-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#email-alert").css("color", "red");
                $("#email-alert").css("font-family", "arial");
                $("#email-alert").css("font-size", "13px");
                $("#email-alert").css("margin-left", "1%");
                $("#email-alert").css("padding", "0");
            }else{
                usuario = email.value.substring(0, email.value.indexOf("@"));
                dominio = email.value.substring(email.value.indexOf("@")+ 1, email.value.length);

                if((usuario.length >=1) &&
                (dominio.length >=3) &&
                (usuario.search("@")==-1) &&
                (dominio.search("@")==-1) &&
                (usuario.search(" ")==-1) &&
                (dominio.search(" ")==-1) &&
                (dominio.search(".")!=-1) &&
                (dominio.indexOf(".") >=1)&&
                (dominio.lastIndexOf(".") < dominio.length - 1)){
                    $.ajax({
                        url: "config/valida-email.php",
                        type: "POST",
                        data: "email="+$("#cad_email").val(),
                        dataType: "html"
                    }).done(function(resposta){
                        $("#email-alert").html(resposta);
                        if($("#email-alert").html() == "Email já cadastrado"){
                            $("#email-alert").css("color", "red");
                            $("#email-alert").css("font-family", "arial");
                            $("#email-alert").css("font-size", "13px");
                            $("#email-alert").css("margin-left", "1%");
                            $("#email-alert").css("padding", "0");
                        }if($("#email-alert").html() == "Email disponível"){
                            $("#email-alert").css("color", "green");
                            $("#email-alert").css("font-family", "arial");
                            $("#email-alert").css("font-size", "13px");
                            $("#email-alert").css("margin-left", "1%");
                            $("#email-alert").css("padding", "0");
                        }
                    }).fail(function(jqXHR, textStatus ){
                        console.log("Request failed: " + textStatus);
                    }).always(function(){
                        console.log("completou");
                    });
                }
                else{
                    document.getElementById("email-alert").innerHTML="E-mail inválido";
                        $("#email-alert").css("color", "red");
                        $("#email-alert").css("color", "red");
                        $("#email-alert").css("font-family", "arial");
                        $("#email-alert").css("font-size", "13px");
                        $("#email-alert").css("margin-left", "1%");
                        $("#email-alert").css("padding", "0");
                }   
            }
        }

        function validarSenha(){
            senha = document.querySelector("#cad_senha").value;
            var qualidade = 0;

            if(senha.length <= 7){
                qualidade += 0;
            }else if(senha.length >= 8){
                qualidade += 5;
            }

            if((senha.length >= 8) && (senha.match(/[a-z]+/))){
                qualidade += 1;
            }else{
                qualidade += 0;
            }

            if((senha.length >= 8) && (senha.match(/[A-Z]+/))){
                qualidade += 1;
            }else{
                qualidade += 0;
            }

            if((senha.length >= 8) && (senha.match(/[!@#$%&;*]/))){
                qualidade += 1;
            }else{
                qualidade += 0;
            }

            if(senha.match(/[0-9]+/)){
                qualidade += 1;
            }else{
                qualidade += 0;
            }


            exibirValores(qualidade);
        }

        function exibirValores(qualidade){
            if(senha == ""){
                document.getElementById("senha-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#senha-alert").css("color", "red");
                $("#senha-alert").css("font-family", "arial");
                $("#senha-alert").css("font-size", "13px");
                $("#senha-alert").css("margin-left", "1%");
                $("#senha-alert").css("padding", "0");
            }else{
                if(qualidade <= 6){
                    document.getElementById("senha-alert").innerHTML = "<font color='red'>Senha fraca</font>";
                    $("#senha-alert").css("color", "red");
                    $("#senha-alert").css("font-family", "arial");
                    $("#senha-alert").css("font-size", "13px");
                    $("#senha-alert").css("margin-left", "1%");
                    $("#senha-alert").css("padding", "0");
                }
                if(qualidade >= 7){
                    document.getElementById("senha-alert").innerHTML = "<font color='green'>Senha forte</font>";
                    $("#senha-alert").css("color", "green");
                    $("#senha-alert").css("font-family", "arial");
                    $("#senha-alert").css("font-size", "13px");
                    $("#senha-alert").css("margin-left", "1%");
                    $("#senha-alert").css("padding", "0");
                }   
            }
        }

        function validarEtec(){
            etec = document.querySelector("#cad_etec").value;
            if(etec == ""){
                document.getElementById("etec-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#etec-alert").css("color", "red");
                $("#etec-alert").css("font-family", "arial");
                $("#etec-alert").css("font-size", "13px");
                $("#etec-alert").css("margin-left", "1%");
                $("#etec-alert").css("padding", "0");
            }else{
                document.getElementById("etec-alert").innerHTML = "";
                $("#etec-alert").css("color", "");
                $("#etec-alert").css("font-family", "");
                $("#etec-alert").css("font-size", "");
                $("#etec-alert").css("margin-left", "");
                $("#etec-alert").css("padding", "");
            }
        }

        function validarEmailLogin(){
            email_log = document.querySelector("#log_email");
            if(email_log.value == ""){
                document.getElementById("email-login-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#email-login-alert").css("color", "red");
                $("#email-login-alert").css("font-family", "arial");
                $("#email-login-alert").css("font-size", "13px");
                $("#email-login-alert").css("margin-left", "1%");
                $("#email-login-alert").css("padding", "0");
            }else{
                usuario_log = email_log.value.substring(0, email_log.value.indexOf("@"));
                dominio_log = email_log.value.substring(email_log.value.indexOf("@")+ 1, email_log.value.length);

                if((usuario_log.length >=1) &&
                (dominio_log.length >=3) &&
                (usuario_log.search("@")==-1) &&
                (dominio_log.search("@")==-1) &&
                (usuario_log.search(" ")==-1) &&
                (dominio_log.search(" ")==-1) &&
                (dominio_log.search(".")!=-1) &&
                (dominio_log.indexOf(".") >=1)&&
                (dominio_log.lastIndexOf(".") < dominio_log.length - 1)){
                    $.ajax({
                        url: "config/valida-email-login.php",
                        type: "POST",
                        data: "email="+$("#log_email").val() + "&idNivel=1",
                        dataType: "html"
                    }).done(function(resposta){
                        $("#email-login-alert").html(resposta);
                        if($("#email-login-alert").html() == "Email não cadastrado"){
                            $("#email-login-alert").css("color", "red");
                            $("#email-login-alert").css("font-family", "arial");
                            $("#email-login-alert").css("font-size", "13px");
                            $("#email-login-alert").css("margin-left", "1%");
                            $("#email-login-alert").css("padding", "0");
                        }if($("#email-login-alert").html() == "Email indisponível"){
                            $("#email-login-alert").css("color", "red");
                            $("#email-login-alert").css("font-family", "arial");
                            $("#email-login-alert").css("font-size", "13px");
                            $("#email-login-alert").css("margin-left", "1%");
                            $("#email-login-alert").css("padding", "0");
                        }
                    }).fail(function(jqXHR, textStatus ){
                        console.log("Request failed: " + textStatus);
                    }).always(function(){
                        console.log("completou");
                    });
                }else{
                    document.getElementById("email-login-alert").innerHTML="E-mail inválido";
                        $("#email-login-alert").css("color", "red");
                        $("#email-login-alert").css("color", "red");
                        $("#email-login-alert").css("font-family", "arial");
                        $("#email-login-alert").css("font-size", "13px");
                        $("#email-login-alert").css("margin-left", "1%");
                        $("#email-login-alert").css("padding", "0");
                }   
            }
        }

        function validarSenhaLogin(){
            senha_log = document.querySelector("#log_senha");
            if(senha_log.value == ""){
                document.getElementById("senha-login-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                $("#senha-login-alert").css("color", "red");
                $("#senha-login-alert").css("font-family", "arial");
                $("#senha-login-alert").css("font-size", "13px");
                $("#senha-login-alert").css("margin-left", "1%");
                $("#senha-login-alert").css("padding", "0");
            }else{
                document.getElementById("senha-login-alert").innerHTML="";
                $("#senha-login-alert").css("color", "");
                $("#senha-login-alert").css("font-family", "");
                $("#senha-login-alert").css("font-size", "");
                $("#senha-login-alert").css("margin-left", "");
                $("#senha-login-alert").css("padding", "");
            }
        }
    </script>
</body>
</html>