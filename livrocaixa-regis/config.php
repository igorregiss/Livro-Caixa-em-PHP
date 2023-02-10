<?php
error_reporting(E_ERROR | E_PARSE);
//Configura��o do Banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$d_b = "livro_caixa";

//T�tulo do seu livro Caixa, geralmente seu nome
//$lc_titulo="Seu nome";

//Autentica��o simples
//$usuario="admin";
//$senha="123";

//////////////////////////////////////
//N�o altere a partir daqui!
//////////////////////////////////////
$conn = mysqli_connect($host, $user, $pass) or die("Erro na conexгo com a base de dados");
$db = mysqli_select_db($conn, $d_b) or die("Erro na selecao da base de dados");

//if (isset($_SESSION['logado']))
//    $logado = $_SESSION['logado'];
//else
//    $logado = "";
//
//
//if ($logado != $senha_ && !isset($pagina_login)) {
//
//    header("Location: login.php");
//
//    exit();
//}

function debug($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function alerta($texto)
{
    echo "<div id='msg'>" . $texto . "</div>";
    echo "<script>$(\"#msg\" ).fadeOut( 2000, function() {
    });</script>";
}
?>
