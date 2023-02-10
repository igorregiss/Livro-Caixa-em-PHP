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
$senha = $pwd;

$querylogar = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario = '$login' AND senha = '$senha'");
$count = mysqli_num_rows($querylogar);
$obj = $querylogar->fetch_object();
debug($obj);
debug($_SESSION);
if ($obj){
    $_SESSION['usuario'] = new stdClass();
    $_SESSION['usuario']->nome = $obj->nome;
    echo "<script>alert('Logado com sucesso!')</script>";
    echo "<script>window.location.href = 'index.php';</script>";

} else {
if ($_POST){
    echo "usuario incorreto";

}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <title id='titulo'>Livro caixa <?php echo $lc_titulo ?></title>
        <meta name="LANGUAGE" content="Portuguese" />
        <meta name="AUDIENCE" content="all" />
        <meta name="RATING" content="GENERAL" />
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <script language="javascript" src="js/scripts.js"></script>
    </head>
    <body style="padding:10px">


        <table cellpadding="1" cellspacing="10"  width="900" align="center" style="background-color:#033">

            <tr>
                <td colspan="11" style="background-color:#005B5B;">
                    <h2 style="color:#FFF; margin:5px">Livro Caixa - <?php echo $lc_titulo ?></h2>
                </td>
                <td colspan="2" align="right" style="background-color:#005B5B;">
                    <b style="color:#FFF"<?php echo date('m') ?><?php echo date('Y') ?>">Hoje:<strong> <?php echo date('d') ?> de <?php echo mostraMes(date('m')) ?> de <?php echo date('Y') ?></strong></b>&nbsp;
                </td>
            </tr>
        </table>
        <br />
        <br />
        <table cellpadding="1" cellspacing="10"  width="900" align="center" >

            <tr>
                <td colspan="11" align="center" >
                    Faça Login para entrar no sistema:
                    <br><br>
                            <form action="" method="post">

                                Login: <input type='text' name='login'><br>
                                        Senha: <input type='password' name='senha'><br>
                                                <br>
                                                    <input type='submit' name='OK' value='Entrar'>

                                                        </form>
                                                        <br>

                                                            </td>
                                                            </tr>
                                                            </table>

                                                            <table cellpadding="5" cellspacing="0" width="900" align="center">
                                                                <tr>
                                                                    <td align="right">
                                                                        <hr size="1" />
                                                                        <em>Livro Caixa - Versaāo 1.0</em>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            </body>
                                                            </html>
