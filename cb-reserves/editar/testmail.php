<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
//require_once(ROOT."Gestor.php");
require(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();

require("mailer.php");
echo "Enviant...";
echo mailer("alexinfopruna@gmail.com", "canbo", "caaaanboreeeell");

?>