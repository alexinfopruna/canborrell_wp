<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("ROOT", "../taules/");

require_once(ROOT."gestor_reserves.php");

$gestor=new gestor_reserves();   

if (!$gestor->valida_sessio(64))  
{
  header("Location: login.php");
  die();
}


?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php
echo isset($_GET['y']);
///*
if (isset($_GET['y'])){
  echo $html = $gestor->restore_config();
  
}
else{
  echo "La restauració de la configuració recuperarà un estat genèric <b>PERDENT LA CONFIGURACIÓ ACTUAL</b>. <br><br>Només s'ha de fer en cas que el sistema de reserves no respongui.";
  echo "<br><br><br><br><a href='restore_config.php?y=1'>Restaurar</a>";
  echo "<br><br><a href='.'>Cancel·lar</a>";
}



?>
</body>
</html>
