<?php
  include('banco/conexao.php');
  session_start();
  if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Startec - Bem vindo!</title>
    <link rel="stylesheet" href="css/capa.css"/>
  </head>

  <body>
    <header>
      <nav>
        <a class="logo" href="index.php">STAR TEC</a>
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
        <ul class="nav-list">
          <li><a href="home_nao_logado.php">Início</a></li>
          <li><a href="sobre_nao_logado.php">Sobre</a></li>
          <li><a href="projetos_nao_logado.php">Projetos</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <a href="cadastrar_aluno.php"><button id="aluno">ALUNO</button></a>
      <a href="cadastrar_empresa.php"><button id="empresa">EMPRESA</button></a>
    </main>
    <script src="js/mobile-navbar.js"></script>
  </body>
</html>
