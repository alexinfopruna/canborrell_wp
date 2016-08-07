<?php
define("ROOT", "../taules/");
define("READER_SCRIPT", "read.php?f=");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();   

if (!$gestor->valida_sessio(64))  
{
  header("Location: login.php");
  die();
}

echo $html=$gestor->reserves_orfanes();
if (!$html) echo "No s'han trobat vincles trencats entre reserves i taules";
