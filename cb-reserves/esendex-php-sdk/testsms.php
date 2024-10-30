<?php
//EUJS - H28G - 13NJ - 8GZX - P49K - CM9G

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();

//$gestor->enviaSMS(82795,"TEEEST");
$result = gestor_reserves::esendex24("606782798","HOLAAAA");
echo "Enviat";
//print_r($result);



