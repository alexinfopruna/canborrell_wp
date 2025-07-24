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

//if (!$gestor->valida_sessio())  die("Login...");


class Test extends Gestor_form{
  
  public function __construct(){
    parent::__construct(DB_CONNECTION_FILE, 1);
  }
  
  public function run(){
     $form = $this->generaFormTpvSHA256($idr=123123, 15.00, "alex garcia");

    $resposta['mail'] =  FALSE;
    $resposta['virtual'] =  FALSE;
    $resposta['TPV'] =  "TPV";
    $resposta['idr'] = $idr;     
    $resposta['fprm_tpv'] = $form;     
    $json = $this->jsonOK("Reserva creada", $resposta);

    echo $json;
   }
}

  
  $t=new test();
  $t->run();
?>
