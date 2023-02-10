<?php
session_start();
set_time_limit(0);
error_reporting(E_ERROR | E_PARSE);

include 'config.php';
include 'functions.php';
if (isset($_GET['sair'])) {
    unset($_SESSION['usuario']);
    session_destroy();
    header("Location: login.php");
}

if (!$_SESSION['usuario'])
    header("Location: login.php");

if (isset($_GET['acao']) && $_GET['acao'] == 'apagar') {
    $id = $_GET['id'];

    mysqli_query($conn,"DELETE FROM lc_movimento WHERE id='$id'");

    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=2");
    exit();
}

if (isset($_POST['acao']) && $_POST['acao'] == 'editar_cat') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    mysqli_query($conn,"UPDATE lc_cat SET nome='$nome' WHERE id='$id'");

    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=3");
    exit();
}

if (isset($_GET['acao']) && $_GET['acao'] == 'apagar_cat') {
    $id = $_GET['id'];

    $qr=mysqli_query($conn,"SELECT c.id FROM lc_movimento m, lc_cat c WHERE c.id=m.cat && c.id=$id");
    if (mysqli_num_rows($qr)>0){
        header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_err=1");
        exit();
    }
    
    mysqli_query($conn,"DELETE FROM lc_cat WHERE id='$id'");

    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=2");
    exit();
}

if (isset($_POST['acao']) && $_POST['acao'] == 'editar_mov') {
    $id = $_POST['id'];
    $dia = $_POST['dia'];
    $tipo = $_POST['tipo'];
    $cat = $_POST['cat'];
    $descricao = $_POST['descricao'];
    $valor = str_replace(",", ".", $_POST['valor']);

    mysqli_query($conn,"UPDATE lc_movimento SET dia='$dia', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor' WHERE id='$id'");

    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=3");
    exit();
}

if (isset($_POST['acao']) && $_POST['acao'] == 2) {

    $nome = $_POST['nome'];

    mysqli_query($conn,"INSERT INTO lc_cat (nome) values ('$nome')");


    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=1");
    exit();
}

if (isset($_POST['acao']) && $_POST['acao'] == 1) {

    $data = $_POST['data'];
    $tipo = $_POST['tipo'];
    $cat = $_POST['cat'];
    $descricao = $_POST['descricao'];
    $valor = str_replace(",", ".", $_POST['valor']);

    $t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

    mysqli_query($conn,"INSERT INTO lc_movimento (dia,mes,ano,tipo,descricao,valor,cat) values ('$dia','$mes','$ano','$tipo','$descricao','$valor','$cat')");


    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=1");
    exit();
}

if (isset($_GET['mes']))
    $mes_hoje = $_GET['mes'];
else
    $mes_hoje = date('m');

if (isset($_GET['ano']))
    $ano_hoje = $_GET['ano'];
else
    $ano_hoje = date('Y');
?>

<?php if ($_SESSION['usuario']) :?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle financeiro</title>

  <!--
    - favicon
  -->
  <link rel="shortcut icon" href="./assets/images/favicon.webp" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./assets/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./assets/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="./assets/remixicon/remixicon.css" rel="stylesheet">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

  <!--
    - #MAIN
  -->

  <main>

    <!--
      - #SIDEBAR
    -->

    <aside class="sidebar">

      <div class="sidebar-info">
        <div class="info-content">

<td >
<select onchange="location.replace('?mes=<?php echo $mes_hoje?>&ano='+this.value)">
<?php
for ($i=2023;$i<=2023;$i++){
?>
<option value="<?php echo $i?>" <?php if ($i==$ano_hoje) echo "selected=selected"?> ><?php echo $i?></option>
<?php }?>
</select>
</td>

            </div>

          </li>

          <li class="contact-item">


            <div class="contact-info">
          
<?php
for ($i=1;$i<=12;$i++){
	?>
    <td align="center" style="<?php if ($i!=12) echo "border-right:1px solid #FFF;"?> padding-right:5px">
    <a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>" style="
    <?php if($mes_hoje==$i){?>     
    color: #272727;
    <?php }else{?>
    color:#FFF; 
    <?php }?>
    ">
    <?php echo mostraMes($i);?>
    </a>
    </td>
<?php
}
?>
</tr>
</table>
            </div>
        </ul>
<!--
        <div class="separator"></div>

        <ul class="social-list">

          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

        </ul>

      </div>
-->

    </aside>





    <!--
      - #main-content
    -->

    <div class="main-content">




      <!--
        - #ABOUT
      -->

      <article class="sobre  active">
        <section class="about-text">

          <ul class="service-list">

            <li class="service-item">

              <div class="service-content-box">

                <p class="service-item-text">

                <a href="javascript:;" onclick="abreFecha('add_cat')" class="bnt"><strong style="color: white;">[+] Adicionar Categoria</strong></a>
<a href="javascript:;" onclick="abreFecha('add_movimento')" class="bnt"><strong style="color: white;">[+] Adicionar Movimento</strong></a>

    <?php
if (isset($_GET['cat_err']) && $_GET['cat_err']==1){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Esta categoria n�o pode ser removida, pois h� movimentos associados a esta</strong>

<?php }?>

    <?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==2){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Categoria removida com sucesso!</strong>
</div>

<?php }?>
    
<?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==1){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Categoria Cadastrada com sucesso!</strong>
</div>

<?php }?>
    
    <?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==3){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Categoria alterada com sucesso!</strong>
</div>

<?php }?>

<?php
if (isset($_GET['ok']) && $_GET['ok']==1){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Movimento Cadastrado com sucesso!</strong>
</div>

<?php }?>

<?php
if (isset($_GET['ok']) && $_GET['ok']==2){
?>

<div style="padding:5px; background-color:#900; text-align:center; color:#FFF">
<strong>Movimento removido com sucesso!</strong>
</div>

<?php }?>
    
    <?php
if (isset($_GET['ok']) && $_GET['ok']==3){
?>

<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Movimento alterado com sucesso!</strong>
</div>

<?php }?>

<div style=" background-color:#F1F1F1; padding:10px; border:1px solid #999; margin:5px; display:none" id="add_cat">
    <h3>Adicionar Categoria</h3>
    <table width="100%">
        <tr>
            <td valign="top">
    

<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="2" />

Nome: <input type="text" name="nome" size="20" maxlength="50" />

<br />
<br />

<input type="submit" class="input" value="Enviar" />
</form>

            </td>
            <td valign="top" align="right">
                <b>Editar/Remover Categorias:</b><br/><br/>
<?php
$qr=mysqli_query($conn,"SELECT id, nome FROM lc_cat");
while ($row=mysqli_fetch_assoc($qr)){
?>
                <div id="editar2_cat_<?php echo $row['id']?>">
<?php echo $row['nome']?>  
                    
                     <a style="font-size:10px; color:#666" onclick="return confirm('Tem certeza que deseja remover esta categoria?\nAten��o: Apenas categorias sem movimentos associados poder�o ser removidas.')" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&acao=apagar_cat&id=<?php echo $row['id']?>" title="Remover">[remover]</a>
                     <a href="javascript:;" style="font-size:10px; color:#666" onclick="document.getElementById('editar_cat_<?php echo $row['id']?>').style.display=''; document.getElementById('editar2_cat_<?php echo $row['id']?>').style.display='none'" title="Editar">[editar]</a>
                    
                </div>
                <div style="display:none" id="editar_cat_<?php echo $row['id']?>">
                    
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="editar_cat" />
<input type="hidden" name="id" value="<?php echo $row['id']?>" />
<input type="text" name="nome" value="<?php echo $row['nome']?>" size="20" maxlength="50" />
<input type="submit" class="input" value="Alterar" />
</form> 
                </div>

<?php }?>

            </td>
        </tr>
    </table>
</div>

<div style=" background-color:#F1F1F1; padding:10px; border:1px solid #999; margin:5px; display:none" id="add_movimento">
<h3>Adicionar Movimento</h3>
<?php
$qr=mysqli_query($conn,"SELECT * FROM lc_cat");
if (mysqli_num_rows($qr)==0)
    echo "Adicione ao menos uma categoria";

else{
?>
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="1" />
<strong>Data:</strong><br />
<input type="text" name="data" size="11" maxlength="10" value="<?php echo date('d')?>/<?php echo $mes_hoje?>/<?php echo $ano_hoje?>"/>

<br />
<br />

<strong>Tipo:<br /></strong>
<label for="tipo_receita" style="color:#030"><input type="radio" name="tipo" value="1" id="tipo_receita" /> Receita</label>&nbsp; 
<label for="tipo_despesa" style="color:#C00"><input type="radio" name="tipo" value="0" id="tipo_despesa" /> Despesa</label>

<br />
<br />

<strong>Categoria:</strong><br />
<select name="cat">
<?php
while ($row=mysqli_fetch_assoc($qr)){
?>
<option value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
<?php }?>
</select>

<br />
<br />

<strong>Descriçāo:</strong><br />
<input type="text" name="descricao" size="100" maxlength="255" />

<br />
<br />

<strong>Valor:</strong><br />
R$<input type="text" name="valor" size="8" maxlength="10" />

<br />
<br />

<input type="submit" class="input" value="Enviar" />

</form>
<?php }?>
</div>
</td>
</tr>                </p>
              </div>

            </li>

          </ul>
<ul class="service-list2">
            <li class="service-item">

              <div class="service-content-box">
                <h4 class="h4 service-item-title" style="text-transform: uppercase">Entradas e Saídas deste mês</h4>

                <p class="service-item-text">
                <?php
$qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=1 && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysqli_fetch_assoc($qr);
$entradas=$row['total'];

$qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=0 && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysqli_fetch_assoc($qr);
$saidas=$row['total'];

$resultado_mes=$entradas-$saidas;
?>

        <table width="100%">
            <tr>
                <td ><span style="font-size:23px;">Entradas:</span></td>
                <td aling="left"><span style="font-size:23px;"><?php echo formata_dinheiro($entradas) ?></span></td>
            </tr>
            <tr>
                <td><span style="font-size:23px;">Saídas:</span></td>
                <td><span style="font-size:23px;"><?php echo formata_dinheiro($saidas) ?></span></td>
            </tr>
            <tr>
                <td><strong style="font-size:23px; color:<?php if ($resultado_mes < 0) echo "#b84c4c"; else echo "#ceb15a" ?>">Resultado:</strong></td>
                <td><strong style="font-size:23px; color:<?php if ($resultado_mes < 0) echo "#b84c4c"; else echo "#ceb15a" ?>"><?php echo formata_dinheiro($resultado_mes) ?></strong></td>
            </tr>
        </table>

              </div>

            </li>
</ul>
<ul class="service-list2">
            <li class="service-item">

              <div class="service-content-box">
                <h4 class="h4 service-item-title" style="text-transform: uppercase">Balanço geral</h4>

                <p class="service-item-text">
                <?php

$qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=1 ");
$row=mysqli_fetch_assoc($qr);
$entradas=$row['total'];

$qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=0 ");
$row=mysqli_fetch_assoc($qr);
$saidas=$row['total'];

$resultado_geral=$entradas-$saidas;
?>


<table width="100%">
<tr>
<td><span style="font-size:23px;">Entradas:</span></td>
<td><span style="font-size:23px;"><?php echo formata_dinheiro($entradas)?></span></td>
</tr>
<tr>
<td><span style="font-size:23px;">Saídas:</span></td>
<td><span style="font-size:23px;"><?php echo formata_dinheiro($saidas)?></span></td>
</tr>
<tr>
<td><strong style="font-size:23px; color:<?php if ($resultado_geral<0) echo "#b84c4c"; else echo "#ceb15a"?>">Resultado:</strong></td>
<td><strong style="font-size:23px; color:<?php if ($resultado_geral<0) echo "#b84c4c"; else echo "#ceb15a"?>"><?php echo formata_dinheiro($resultado_geral)?></strong></td>
</tr>
</table>

</p>
              </div>
</li>
</ul>

<ul class="service-list2">
            <li class="service-item">

              <div class="service-content-box">
                <h4 class="h4 service-item-title" style="text-transform: uppercase">Movimentos deste mês</h4>

                <p class="service-item-text">

                <table width="100%" align="center">
<tr>
<td colspan="2">
<div style="float:right; text-align:right">
<form name="form_filtro_cat" method="get" action=""  >
<input type="hidden" name="mes" value="<?php echo $mes_hoje?>" >
<input type="hidden" name="ano" value="<?php echo $ano_hoje?>" >
Filtrar por categoria:  <select name="filtro_cat" onchange="form_filtro_cat.submit()">
<option value="">Tudo</option>
<?php
$qr=mysqli_query($conn,"SELECT DISTINCT c.id, c.nome FROM lc_cat c, lc_movimento m WHERE m.cat=c.id && m.mes='$mes_hoje' && m.ano='$ano_hoje'");
while ($row=mysqli_fetch_assoc($qr)){
?>
<option <?php if (isset($_GET['filtro_cat']) && $_GET['filtro_cat']==$row['id'])echo "selected=selected"?> value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
<?php }?>
</select><br>
</form>
    </div>


</td>
</tr>
<?php
$filtros="";
if (isset($_GET['filtro_cat'])){
	if ($_GET['filtro_cat']!=''){	
		$filtros="&& cat='".$_GET['filtro_cat']."'";
                
                $qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=1 && mes='$mes_hoje' && ano='$ano_hoje' $filtros");
                $row=mysqli_fetch_assoc($qr);
                $entradas=$row['total'];

                $qr=mysqli_query($conn,"SELECT SUM(valor) as total FROM lc_movimento WHERE tipo=0 && mes='$mes_hoje' && ano='$ano_hoje' $filtros");
                $row=mysqli_fetch_assoc($qr);
                $saidas=$row['total'];

                $resultado_mes=$entradas-$saidas;
                
        }
}

$qr=mysqli_query($conn,"SELECT * FROM lc_movimento WHERE mes='$mes_hoje' && ano='$ano_hoje' $filtros ORDER By dia");
$cont=0;
while ($row=mysqli_fetch_assoc($qr)){
$cont++;

$cat=$row['cat'];
$qr2=mysqli_query($conn,"SELECT nome FROM lc_cat WHERE id='$cat'");
$row2=mysqli_fetch_assoc($qr2);
$categoria=$row2['nome'];

?>
<tr <?php if ($cont%2==0) echo "#F1F1F1"; else echo "#E0E0E0"?>" >
<td align="center" ><?php echo $row['dia']?></td>
<td><?php echo $row['descricao']?> <em>(<a href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><?php echo $categoria?></a>)</em> <a href="javascript:;" style="font-size:10px; color:#050505" onclick="document.getElementById('editar_mov_<?php echo $row['id']?>').style.display='';  " title="Editar">[EDITAR]</a></td>
<td align="right"><strong style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo "+"?><?php echo formata_dinheiro($row['valor'])?></strong></td>
</tr>
    <tr style="display:none; background-color:<?php if ($cont%2==0) echo "#F1F1F1"; else echo "#E0E0E0"?>" id="editar_mov_<?php echo $row['id']?>">
        <td>
            <form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
            <input type="hidden" name="acao" value="editar_mov" />
            <input type="hidden" name="id" value="<?php echo $row['id']?>" />
            
            <b>Dia:</b> <input type="text" name="dia" size="3" maxlength="2" value="<?php echo $row['dia']?>" />&nbsp;|&nbsp;
            <b>Tipo:</b> <label for="tipo_receita<?php echo $row['id']?>" style="color:#030"><input <?php if($row['tipo']==1) echo "checked=checked"?> type="radio" name="tipo" value="1" id="tipo_receita<?php echo $row['id']?>" /> Receita</label>&nbsp; <label for="tipo_despesa<?php echo $row['id']?>" style="color:#C00"><input <?php if($row['tipo']==0) echo "checked=checked"?> type="radio" name="tipo" value="0" id="tipo_despesa<?php echo $row['id']?>" /> Despesa</label>&nbsp;|&nbsp;
            <b>Categoria:</b>
<select name="cat">
<?php
$qr2=mysqli_query($conn,"SELECT * FROM lc_cat");
while ($row2=mysqli_fetch_array($qr2)){
?>
    <option <?php if($row2['id']==$row['cat']) echo "selected"?> value="<?php echo $row2['id']?>"><?php echo $row2['nome']?></option>
<?php }?>
</select>&nbsp;|&nbsp;
            <b>Valor:</b> R$<input type="text" value="<?php echo $row['valor']?>" name="valor" size="8" maxlength="10" />
            <br/>
            <b>Descricao:</b> <input type="text" name="descricao" value="<?php echo $row['descricao']?>" size="70" maxlength="255" />
            
            <input type="submit" class="input" value="Alterar" />
            </form> 
            <div>
            <a style="color:#FF0000" onclick="return confirm('Tem certeza que deseja apagar?')" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&acao=apagar&id=<?php echo $row['id']?>" title="Remover">[remover]</a> 
            </div>
            <hr/>
        </td>
    </tr>
      
<?php
}
?>
<tr>
<td colspan="66" align="right">
<strong style="font-size:22px; color:<?php if ($resultado_mes<0) echo "#C00"; else echo "#030"?>"><?php echo formata_dinheiro($resultado_mes)?></strong>
</td>
</tr>
</table>

</p>

              </div>
</li>
</ul>
<td >
<ul class="navbar-list">
<p style="font-size: 30px"> <a href="index.php?sair=1" class="bnt"><b style="color: #FFF">Desconectar</b></a>
</p>      </li>
    
        </ul>     
</td>

        </section>

      </article>



      
  </main>






  <!--
    - custom js link
  -->
  <script language="javascript" src="js/scripts.js"></script>
  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
<?php endif;?>