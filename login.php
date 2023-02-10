<?php
session_start();
set_time_limit(0);
error_reporting(E_ERROR | E_PARSE);
if ($_SESSION['usuario']){
    echo "<script>window.location.href = 'index.php';</script>";
}

$pagina_login = 1;

include 'config.php';
include 'functions.php';


$login = $_POST['login'];
$pwd = $_POST['senha'];
$senha = sha1($pwd);

if ($_GET['go'] == 'cadastrar'){
    $cadnome = $_POST['cadnome'];
    $cadlogin = $_POST['cadlogin'];
    $cadsenha = sha1($_POST['cadsenha']);
    $queryVerifica = mysqli_query($conn,"SELECT * FROM usuario WHERE usuario = '$cadlogin'");
    $countVerifica = mysqli_num_rows($queryVerifica);
    if ($countVerifica == 1){
        echo "<script>alert('Nome de usuário ja cadastrado, tente outro!'); window.location.href = 'index.php';</script>";
    } else {
        $querycadastrar = mysqli_query($conn, "INSERT INTO usuario (nome, usuario, senha) VALUES ('$cadnome', '$cadlogin', '$cadsenha')");
        $_SESSION['usuario'] = new stdClass();
        $_SESSION['usuario']->nome = $cadnome;
        echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href = 'index.php';</script>";
    }

}

if ($_GET['go'] == 'login'){
    $querylogar = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario = '$login' AND senha = '$senha'");
    $count = mysqli_num_rows($querylogar);
    $obj = $querylogar->fetch_object();
    if ($obj){
        $_SESSION['usuario'] = new stdClass();
        $_SESSION['usuario']->nome = $obj->nome;
        echo "<script>alert('Logado com sucesso!')</script>";
        echo "<script>window.location.href = 'index.php';</script>";

    } else {
        if ($_POST){

        }

    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livro Caixa</title>
    <meta name="LANGUAGE" content="Portuguese" />
    <meta name="AUDIENCE" content="all" />
    <meta name="RATING" content="GENERAL" />
    <link rel="shortcut icon" href="https://i.imgur.com/BWpgGdQ.png" type="image/x-icon">
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="js/scripts.js"></script>
    <link href='css/googleapis.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.min.css">


    <link rel="stylesheet" href="css/style_login.css">


    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="vendor/simple-datatables/style.css" rel="stylesheet">


</head>

<body>
    <div class="box">
        <div class="img-box">
            <img src="https://agencianet.net.br/webp/assets/img/bgs/bg-login.png">
        </div>
        <div class="form-box">
            <h2>Login</h2>
            <p> Não tem cadastro? <a href="#"> Cadastrar-se </a> </p>

            <form action="?go=login" method="post">
                <div class="input-group">
                    <label for="nome">Usúario</label>
                    <input placeholder="Digite seu usúario" type="text" name="login" required autocomplete="off"/>
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input placeholder="Digite sua senha" type="password" name="senha" required autocomplete="off"/>
                </div>

                <div class="input-group">
                <button class="button button-block"/>
                Entrar</button></div>

            </form>
        </div>
    </div>
</body>
</html>



<script src='js/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>
</html>
