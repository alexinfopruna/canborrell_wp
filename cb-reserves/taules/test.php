<?php 
header('Content-Type: text/html; charset=UTF-8');
header('Set-Cookie: fileDownload=true');

echo "HOLAAAA";
phpinfo();
exit();

require_once("Gestor.php");
define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
 if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");


require_once("gestor_reserves.php");
require_once(ROOT."../taules/Gestor_grups.php");
require_once(ROOT."../taules/Gestor_pagaments.php");
require_once(ROOT."../reservar/Gestor_form.php");
$gestor=new gestor_reserves(); 


require_once(ROOT . "RestrictionController.php");

if (!$gestor->valida_sessio())  die("Login...");


class Test extends gestor_reserves {
  
  public function __construct(){
    parent::__construct(DB_CONNECTION_FILE, 1);
  }
  
  public function run(){
      $grups=new Gestor_grups();
      $pagament=new Gestor_pagaments();  
      echo $pagament->get_preu_persona_reserva(3050);
      //$pagament->afegir_pagament(1233047, 3047, 36, preu_persona_grups, "manolo");
     // $pagament->validar_pagament(1233047,  99);
     // $gestor=new Gestor_form();  
     // $gestor->reserva_grups_tpv_ok_callback("3051", "36", "2018-02-02", "14:00:00") ;
   }
}
  
  
  $t=new test();
  $t->run();
?>
<html xmlns="//www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MenjadorEditor</title>
<link type="text/css" href="css/print.css" rel="stylesheet" />			
		<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
<script>

</script>

<style>

</style>
</head>
<body bgcolor="#ffffff">

</body>
</html>
