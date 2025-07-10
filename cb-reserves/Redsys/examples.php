<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
defined('ROOT') or define('ROOT', '../taules/');
defined('INC_FILE_PATH') or define('INC_FILE_PATH', ROOT . '../../../canBorrell_inc_LOCAL/');
//$tpv_config_file = "TPV256.php";



if (!defined('ROOT'))
  define('ROOT', "../taules/");
require_once (ROOT . "Gestor.php");



/* * ************** PERMISOS ADMIN *************************************** */
if (!isset($_SESSION['permisos']))
  die("error:sin permisos"); /*   * ******* */
if ($_SESSION['permisos'] < 200)
  die("error:sin permisos"); /*   * ********* */
/* * ************** PERMISOS ADMIN *************************************** */
$id = $lang = "not set";
$tpv_config_file = isset($_REQUEST['tpv_config_file']) ? $_REQUEST['tpv_config_file'] : TPV_CONFIG_FILE;
//echo ROOT . INC_FILE_PATH . $tpv_config_file;die();
include(ROOT . INC_FILE_PATH . $tpv_config_file); //NECESSITO TENIR A PUNT id i $lang

$id = time(); //'012121042'; // ID de la reserva, debe ser único para cada transacción
$lang = 'cat'; // Idioma de la transacción, puede ser 'cat' o 'es'

$config = require __DIR__.'/config.php';
include __DIR__.'/src/autoload.php';



echo generaFormTpvSHA256_v2($config, $id, "0,1", "Test TPV", "reserva_pk_tpv_ok_callback");

die('<script>document.forms[0].submit();</script>');


echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>";
$step = empty($_GET['step']) ? 1 : (int) $_GET['step'];


# Carga tu fichero con la configuración personalizada en config.local.php


//include(ROOT . INC_FILE_PATH . $tpv_config_file);
//$config = require __DIR__.'/config.php';
//$config = $config_tpv;


if ($step === 1) {
    # Ejemplo de pago instantáneo
    # Este proceso se realiza para pagos en el momento, sin necesidad de confirmación futura (TransactionType = 0)

    # Cargamos la clase con los parámetros base

    $TPV = new Redsys\Tpv\Tpv($config);
    # Indicamos los campos para el pedido
    $TPV->setFormHiddens(array(
        'TransactionType' => '7',
        'MerchantData' => 'Televisor de 50 pulgadas',
        'Order' => $id,
        'Amount' => '0,1',
        'UrlOK' => 'http://can-borrell.com',
        'UrlKO' => 'http://can-borrell.com',
        'MerchantURL' => 'https://www.can-borrell.com/cb-reserves/reservar/Gestor_form.php?a=respostaTPV_SHA256'
    ));

    # Imprimimos el pedido el formulario y redirigimos a la TPV
    echo $TPV->getPath();
 

    echo '<form action="'.$TPV->getPath('/realizarPago').'" method="post">'.$TPV->getFormHiddens().'</form>';

    //die('<script>document.forms[0].submit();</script>');
}




  function generaFormTpvSHA256_v2($config, $id_reserva, $import, $nom, $tpv_ok_callback_alter = NULL) {
    //$this->xgreg_log("generaFormTpvSHA256 $id_reserva $import $nom", 0, LOG_FILE_TPVPK, TRUE);
    if( intval($_SESSION['permisos']) == 255) { $import=0.1;}
    
//echo $_SESSION['permisos'];die();
//$import = 0.1;
    //$id = $order = substr(time(), -4, 3) . $id_reserva;
$id= $id_reserva; // ID de la reserva, debe ser único para cada transacción
    $titular = $nom;
   // $lang = $this->lang;
   $lang = 'cat'; // Idioma de la transacción, puede ser 'cat' o 'es'
    $idioma = ($lang == "cat") ? "003" : "001";
    //$amount = $import * 100;
    $amount = $import;

    include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    // MODIFICA PARAMS 
    if (isset($tpv_ok_callback_alter))
      $tpv_ok_callback = $tpv_ok_callback_alter;
    // Valores de entrada del ejemplo de redsy
    $fuc="999008881";$terminal="871";$moneda="978";$trans="0";//$url="";$urlMerchant="";$urlOKKO="";$urlKO="";$urlOK="";$id=time();$amount="145";
    //Se incluye la librería
    include ROOT.INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';
   
    if( intval($_SESSION['uSer']->id) ==2 && $tpv_ok_callback=="reserva_pk_tpv_ok_callback") $trans=0;
   if( $tpv_ok_callback=="reserva_pk_tpv_ok_callback") $trans=0;
   else $trans=0; // reserva de grups

    
    //Se crea Objeto
    $miObj = new RedsysAPI;

    $TPV = new Redsys\Tpv\Tpv($config);
//echo $id; die();

    # Indicamos los campos para el pedido
    $TPV->setFormHiddens(array(
        'TransactionType' =>  $trans,
        'MerchantData' => $tpv_ok_callback,
        'Order' => strval($id),
        'Amount' => $amount,
        'UrlOK' => $urlOK,
        'UrlKO' => $urlKO,
        'MerchantURL' => $urlMerchant,
        'ConsumerLanguage' => $idioma,
        'PayMethods' => $paymethods,
        'ProductDescription' => $producte
    ));

    $form = $TPV->getPath();


    echo "ZZZZZ". $TPV->getPath();
 

    $form = '<form action="'.$TPV->getPath('/realizarPago').'" method="post">'.$TPV->getFormHiddens().'</form>';
    return $form;
  }
