<?php 
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Empresa</title>
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
                <form method="post" action="config/cadastrar-empresa.php" class="form">
                    <label class="label-input">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" name="cad_nm_empresa" placeholder="Nome da empresa" onblur="validarNome()" id="cad_nm_empresa" required>
                    </label>
                    <span id="nome-alert"></span><br>

                    <label class="label-input">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" onblur="validarEmail()" name="cad_email" maxlength="100" placeholder="Email" id="cad_email" required>
                    </label>
                    <span id="email-alert"></span><br>

                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="text" maxlength="18" name="cad_cnpj" id="cnpj" placeholder="00.000.000/0000-00" onblur="validarCNPJ(this)" required>
                    </label>
                    <span id="cnpj-alert"></span><br>

                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" name="cad_senha" placeholder="Senha" maxlength="20" minlength="8" onblur="validarSenha()" required id="cad_senha">
                        <i class="fa-solid fa-eye" onclick="mostrarOcultarSenhaA()" style="margin-right: 3%;" id="versenhaA"></i><br>
                    </label>
                    <span id="senha-alert"></span><br>
                       
                    <button id="cadastrar" style="padding-left: 0; padding-right: 0;" class="btn btn-second">REGISTRAR</button>        
                </form>
            </div><!-- second column -->
        </div><!-- first content -->
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">CRIE SUA CONTA</h2>      
                <button id="signup" style="padding-left: 0; padding-right: 0;" class="btn btn-primary">CADASTRAR</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second" style="margin-bottom: 3%;">BEM VINDO</h2>
                <form method="post" action="config/login_empresa.php" class="form">
                    <label class="label-input">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" onblur="validarEmailLogin()" name="log_email" id="log_email" placeholder="Email" required>
                    </label>
                    <span id="email-login-alert"></span><br>
                    
                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="text" onblur="validarCNPJLogin(this)" name="log_cnpj" id="log_cnpj" placeholder="00.000.000/0000-00" required>
                    </label>
                    <span id="cnpj-login-alert"></span><br>

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
            function validarNome(){
                nome = document.querySelector("#cad_nm_empresa").value;
                if(nome == ""){
                    document.getElementById("nome-alert").innerHTML = "<font color='red'>Este campo é obrigatório</font>";
                    $("#nome-alert").css("color", "red");
                    $("#nome-alert").css("font-family", "arial");
                    $("#nome-alert").css("font-size", "13px");
                    $("#nome-alert").css("margin-left", "1%");
                    $("#nome-alert").css("padding", "0");
                }else{
                    $.ajax({
                    url: "config/valida-user.php",
                    type: "POST",
                    data: "nome="+$("#cad_nm_empresa").val(),
                    dataType: "html"
                    }).done(function(resposta){
                        $("#nome-alert").html(resposta);
                        if($("#nome-alert").html() == "Nome já cadastrado"){
                            $("#nome-alert").css("color", "red");
                            $("#nome-alert").css("font-family", "arial");
                            $("#nome-alert").css("font-size", "13px");
                            $("#nome-alert").css("margin-left", "1%");
                            $("#nome-alert").css("padding", "0");
                        }if($("#nome-alert").html() == "Nome disponível"){
                            $("#nome-alert").css("color", "green");
                            $("#nome-alert").css("font-family", "arial");
                            $("#nome-alert").css("font-size", "13px");
                            $("#nome-alert").css("margin-left", "1%");
                            $("#nome-alert").css("padding", "0");
                        }if($("#nome-alert").html() == "Nome inválido"){
                            $("#nome-alert").css("color", "red");
                            $("#nome-alert").css("font-family", "arial");
                            $("#nome-alert").css("font-size", "13px");
                            $("#nome-alert").css("margin-left", "1%");
                            $("#nome-alert").css("padding", "0");
                        }
                    }).fail(function(jqXHR, textStatus ){
                        console.log("Request failed: " + textStatus);
                    }).always(function(){
                        console.log("completou");
                    });
                }
            }

            function valorCNPJ(cnpj){
                cnpj = cnpj.replace(/[^\d]+/g, '');
                if(cnpj == ''){
                    return false;
                }if(cnpj.length != 14){
                    return false;
                }if(cnpj == "00000000000000" ||
                    cnpj == "11111111111111" ||
                    cnpj == "22222222222222" ||
                    cnpj == "33333333333333" ||
                    cnpj == "44444444444444" ||
                    cnpj == "55555555555555" ||
                    cnpj == "66666666666666" ||
                    cnpj == "77777777777777" ||
                    cnpj == "88888888888888" ||
                    cnpj == "99999999999999"){
                    return false;
                }
                    
                tamanho = cnpj.length - 2
                numeros = cnpj.substring(0, tamanho);
                digitos = cnpj.substring(tamanho);
                soma = 0;
                pos = tamanho - 7;
                for(i = tamanho; i >= 1; i--){
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if(pos < 2){
                        pos = 9;
                    }
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if(resultado != digitos.charAt(0)){
                    return false;
                }
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0, tamanho);
                soma = 0;
                pos = tamanho - 7;
                for(i = tamanho; i >= 1; i--){
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if(pos < 2){
                        pos = 9;
                    }
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if(resultado != digitos.charAt(1)){
                    return false;
                }
                return true;    
            }
        
            function validarCNPJ(el){
                if(!valorCNPJ(el.value)){
                    document.getElementById("cnpj-alert").innerHTML="CNPJ inválido";
                    $("#cnpj-alert").css("color", "red");
                    $("#cnpj-alert").css("font-family", "arial");
                    $("#cnpj-alert").css("font-size", "13px");
                    $("#cnpj-alert").css("margin-left", "1%");
                    $("#cnpj-alert").css("padding", "0");
                }else{
                    $.ajax({
                        url: "config/valida-cnpj.php",
                        type: "POST",
                        data: "cnpj="+$("#cnpj").val(),
                        dataType: "html"
                    }).done(function(resposta){
                        $("#cnpj-alert").html(resposta);
                        if($("#cnpj-alert").html() == "CNPJ já cadastrado"){
                            $("#cnpj-alert").css("color", "red");
                            $("#cnpj-alert").css("font-family", "arial");
                            $("#cnpj-alert").css("font-size", "13px");
                            $("#cnpj-alert").css("margin-left", "1%");
                            $("#cnpj-alert").css("padding", "0");
                        }if($("#cnpj-alert").html() == "CNPJ disponível"){
                            $("#cnpj-alert").css("color", "green");
                            $("#cnpj-alert").css("font-family", "arial");
                            $("#cnpj-alert").css("font-size", "13px");
                            $("#cnpj-alert").css("margin-left", "1%");
                            $("#cnpj-alert").css("padding", "0");
                        }
                    }).fail(function(jqXHR, textStatus ){
                        console.log("Request failed: " + textStatus);
                    }).always(function(){
                        console.log("completou");
                    });
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
                            data: "email="+$("#log_email").val() + "&idNivel=2",
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

            function valorCNPJLogin(log_cnpj){
                cnpj_log = cnpj_log.replace(/[^\d]+/g, '');
                if(cnpj_log == ''){
                    return false;
                }if(cnpj_log.length != 14){
                    return false;
                }if(cnpj_log == "00000000000000" ||
                    cnpj_log == "11111111111111" ||
                    cnpj_log == "22222222222222" ||
                    cnpj_log == "33333333333333" ||
                    cnpj_log == "44444444444444" ||
                    cnpj_log == "55555555555555" ||
                    cnpj_log == "66666666666666" ||
                    cnpj_log == "77777777777777" ||
                    cnpj_log == "88888888888888" ||
                    cnpj_log == "99999999999999"){
                    return false;
                }
                    
                tamanho_log = cnpj_log.length - 2
                numeros_log = cnpj_log.substring(0, tamanho_log);
                digitos_log = cnpj_log.substring(tamanho_log);
                soma_log = 0;
                pos_log = tamanho_log - 7;
                for(i = tamanho_log; i >= 1; i--){
                    soma_log += numeros_log.charAt(tamanho_log - i) * pos_log--;
                    if(pos_log < 2){
                        pos_log = 9;
                    }
                }
                resultado_log = soma_log % 11 < 2 ? 0 : 11 - soma_log % 11;
                if(resultado_log != digitos_log.charAt(0)){
                    return false;
                }
                tamanho_log = tamanho_log + 1;
                numeros_log = cnpj_log.substring(0, tamanho_log);
                soma_log = 0;
                pos_log = tamanho_log - 7;
                for(i = tamanho_log; i >= 1; i--){
                    soma_log += numeros_log.charAt(tamanho_log - i) * pos_log--;
                    if(pos_log < 2){
                        pos_log = 9;
                    }
                }
                resultado_log = soma_log % 11 < 2 ? 0 : 11 - soma_log % 11;
                if(resultado_log != digitos_log.charAt(1)){
                    return false;
                }
                return true;    
            }
        
            function validarCNPJLogin(el){
                if(!valorCNPJ(el.value)){
                    document.getElementById("cnpj-login-alert").innerHTML="CNPJ inválido";
                    $("#cnpj-login-alert").css("color", "red");
                    $("#cnpj-login-alert").css("font-family", "arial");
                    $("#cnpj-login-alert").css("font-size", "13px");
                    $("#cnpj-login-alert").css("margin-left", "1%");
                    $("#cnpj-login-alert").css("padding", "0");
                }else{
                    $.ajax({
                        url: "config/valida-cnpj-login.php",
                        type: "POST",
                        data: "cnpj="+$("#log_cnpj").val() + "&idNivel=2",
                        dataType: "html"
                    }).done(function(resposta){
                        $("#cnpj-login-alert").html(resposta);
                        if($("#cnpj-login-alert").html() == "CNPJ já cadastrado"){
                            $("#cnpj-login-alert").css("color", "red");
                            $("#cnpj-login-alert").css("font-family", "arial");
                            $("#cnpj-login-alert").css("font-size", "13px");
                            $("#cnpj-login-alert").css("margin-left", "1%");
                            $("#cnpj-login-alert").css("padding", "0");
                        }if($("#cnpj-login-alert").html() == ""){
                        }
                    }).fail(function(jqXHR, textStatus ){
                        console.log("Request failed: " + textStatus);
                    }).always(function(){
                        console.log("completou");
                    });
                }
            }
    </script>
</body>
</html>