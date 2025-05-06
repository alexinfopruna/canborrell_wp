<?php 
header('Content-Type: text/html; charset=UTF-8');
header('Set-Cookie: fileDownload=true');



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
<br/>
<b>Fatal error</b>
:  Uncaught mysqli_sql_exception: Column 'estat_hores_actiu' cannot be null in D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\Gestor.php:387
Stack trace:
#0 D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\Gestor.php(387): mysqli_query(Object(mysqli), 'INSERT INTO est...')
#1 D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\gestor_reserves.php(2553): Gestor::log_mysql_query('INSERT INTO est...', Object(mysqli))
#2 D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\peticions_ajax.php(146): gestor_reserves-&gt;update_hora('13:15', '0', '0', 'BASE', '1', 'estat_hores_for...')
#3 D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\gestor_reserves.php(3868): include('D:\\Usuaris\\alex...')
#4 {main}
  thrown in <b>D:\Usuaris\alex\Dwww\CB_docker-compose-lamp\www\cb-reserves\taules\Gestor.php</b>
on line <b>387</b>
<br/>
DELETE FROM estat_hores_form WHERE    
    (estat_hores_data='2011-01-01' AND estat_hores_hora='13:15' AND estat_hores_torn = '1')


<br/>
</body>
</html>
