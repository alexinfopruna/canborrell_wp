<?php
/**
 * tespTPV:
 * 
 * order=31710
 * 
 */
//$message = "1234000000002085078125713978000qwertyasdf0123456789";
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

include(ROOT . INC_FILE_PATH . $tpv_config_file); //NECESSITO TENIR A PUNT 4id i $lang
include ROOT . INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';





$miObj = new RedsysAPI;
$conecta = ROOT."../reservar/Gestor_form.php?a=respostaTPV_SHA256";
$conecta = "http://www.can-borrell.com/reservar/Gestor_form.php?a=respostaTPV_SHA256";


//$url = isset($_REQUEST['purl']) ? $_REQUEST['purl'] : "http://sis-d.redsys.es/sis/realizarPago";
$id_reserva = isset($_REQUEST['pidr']) ? $_REQUEST['pidr'] : '****';
$lidr = $order = substr(time(), -4, 3) . $id_reserva;
$amount = isset($_REQUEST['pamount']) ? $_REQUEST['pamount'] : 1500;
$response = isset($_REQUEST['presponse']) ? $_REQUEST['presponse'] : 99;
$callback = isset($_REQUEST['pcallback']) ? $_REQUEST['pcallback'] : "reserva_pk_tpv_ok_callback";
$ddate = date("d-m-Y");
$dhour = date("H:i");
//echo $callback;die();
if (isset($_REQUEST['Decode'])){
  $params = $miObj->decodeMerchantParameters($_REQUEST['Ds_Merchant_MerchantParameters']  );
  $param = json_decode($params, TRUE);
  $amount = $param['Ds_Amount'];
  $lidr = $param['Ds_Order'];
//  $fuc = $param['$fuc']
  $moneda = $param['Ds_Currency'];
  $trans = $param['Ds_TransactionType'];
  $terminal = $param['Ds_Terminal'];
  $response = $param['Ds_Response'];
  $callback = $param['Ds_MerchantData'];
  $ddate = $param['Ds_Date'];
  $dhour = $param['Ds_Hour'];
  echo "<pre>";
  print_r($param);
  echo "</pre>";
  
  
  echo  "intval($response)=".intval($response);
  echo "<br><br>";
}

$miObj->setParameter("Ds_Amount", $amount);
$miObj->setParameter("Ds_Order", strval($lidr));
$miObj->setParameter("Ds_MerchantCode", $fuc);
$miObj->setParameter("Ds_Currency", $moneda);
$miObj->setParameter("Ds_TransactionType", $trans);
$miObj->setParameter("Ds_Terminal", $terminal);
$miObj->setParameter("Ds_Date", $ddate);
$miObj->setParameter("Ds_Hour", date("H:i"));
$miObj->setParameter("Ds_Response", $response);
$miObj->setParameter("Ds_MerchantData", $callback);
$miObj->setParameter("Ds_ConsumerLanguage", 3);

// Se generan los parámetros de la petición
$request = "";
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignatureNotif($clave256, $params);


// ACCIONS
// ACCIONS
// ACCIONS
// ACCIONS
// ACCIONS
// ACCIONS
if (isset($_REQUEST['reset_estat']) && $_REQUEST['reset_estat'] == 'reset_estat') {
  $dest = '//' . $_SERVER['HTTP_HOST'] . "/cb-reserves/reservar/Gestor_form.php?a=reset_estat&b=$id_reserva";
  header("Location: $dest ");
}

$href = '//' . $_SERVER['HTTP_HOST'] . "/cb-reserves/reservar/testTPV256.php"
    . "?pidr=$id_reserva&pamount=$amount&presponse=$response&pcallback=$callback&"
    . "=$tpv_config_file&init=1";
$HTML = '<a href="' . $href . '">' . $href . '</a>';
?>
<?php
$HTML .= sprintf("Ds_Order: %s <br>", $lidr);
$HTML .= sprintf("Ds_Date: %s <br>", date("d-m-Y"));
$HTML .= sprintf("Ds_Hour: %s <br>", date("H:i"));
$HTML .= sprintf("Ds_Amount: %s <br>", $amount);
$HTML .= sprintf("Ds_Currency: %s <br>", $moneda);
$HTML .= sprintf("Ds_Transactiontype: %s <br>", $trans);
$HTML .= sprintf("Ds_MerchantCode: %s <br>", $fuc);
$HTML .= sprintf("Ds_Terminal: %s <br>", $terminal);
$HTML .= sprintf("Ds_Response: %s <br>", $response);
$HTML .= sprintf("Ds_MerchantData: %s <br>", $callback);
$HTML .= sprintf("Ds_ConsumerLanguage: %s <br>", "003");

echo $HTML;
?>

<!--------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------->


<style>
input[type=text], .ds_input {
    display: inline;
}  
</style>
<br/>
<br/>
<br/>
<br/>
<form name="frm"  method="POST" target="_self">
    Config 
    <select name='tpv_config_file'>
        <option value='TPV256.php' <?php if ($tpv_config_file == 'TPV256.php') echo 'selected' ?>>TPV256.php</option>
        <option value="TPV256_test.php" <?php if ($tpv_config_file == 'TPV256_test.php') echo 'selected' ?>>TPV256_test.php</option>
    </select>
    
    <?php echo $url; ?><br/>
                  <!--purl2<input type="text" name="purl2" value="<?php echo $url; ?>"/></br>-->
    pidr <input type="text" name="pidr" value="<?php echo $id_reserva; ?>"/><br/>
    pamount <input type="text" name="pamount" value="<?php echo $amount; ?>"/><br/>
    presponse <input type="text" name="presponse" value="<?php echo $response; ?>"/><br/>
    pcallback <input type="text" name="pcallback" value="<?php echo $callback; ?>"/><br/>
    <br/>
    <input type="submit" name="init" value="Enviar" />
    <input type="submit" name="reset_estat" value="reset_estat" />
</form>  
<br/>
<br/>
<br/>
<br/>

  <form name="decode" action="" method="POST" target="_self">
      Ds_Merchant_MerchantParameters<br> <textarea style="width:700px;height:150px;" name="Ds_Merchant_MerchantParameters"></textarea><br/>
      <input type="submit" value="Decode" name="Decode" >
  </form>

<br/>
<br/>
<br/>
<br/>
<?php if (isset($_REQUEST['init'])): ?>
  <form name="frm" action="<?php echo $conecta ?>" method="POST" target="_blank">
      Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/><br/>
      Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/><br/>
      Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/><br/>
      no-update 
      <select name="param">
          <option value="none">none</option>
          <option value="no-update">no-update</option>
          
      </select>
      <input type="submit" value="Enviar" >
  </form>
<?php endif; ?>