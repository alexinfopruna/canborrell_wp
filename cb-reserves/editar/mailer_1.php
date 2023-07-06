<?php

//require_once (ROOT . INC_FILE_PATH . "PHPMailer-master/PHPMailerAutoload.php");
//require_once (ROOT.'../../wp-includes/PHPMailer/PHPMailer.php');

require_once ROOT.'../editar/html2pdf-master/vendor/autoload.php';
//require_once dirname(__FILE__).'/../src/Html2Pdf.php';
// die("wwww");
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


require_once(ROOT . INC_FILE_PATH . 'alex.inc');

if (!defined('CONFIG')) {
  if (!defined('ROOT'))    define('ROOT', "../taules/");
  require_once(ROOT . "php/Configuracio.php");
  $conf = new Configuracio();
}

function mailer_reserva($idr, $template, $addr, $subject, $body, $altbody, $attach = null, $test = false, $cco = null) {
  $query = "INSERT INTO `email` ( `reserva_id`, `email_recipients`, `email_subject`, `email_body`, `email_resultat`,   `email_categoria`) "
      . "VALUES (  '$idr', '$addr', '$subject', '" . base64_encode($body) . "' , '0',  '$template');";
  $qry_result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $idt = mysqli_insert_id($GLOBALS["___mysqli_ston"]);
//echo $body;
  $res = mailer($addr, $subject, $body, $altbody, $attach, $test, $cco);
  $resultat = $res ? '1' : '0';

  if ($test || ENVIA_MAILS === false && $addr!="alexbasurilla@gmail.com") $resultat = '2';
  
  $query = "UPDATE email SET email_resultat = $resultat WHERE email_id = $idt";
  $qry_result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  return $res;
}

/* * ************************************************************************************ */
/* * ************************************************************************************ */
/* * ************************************************************************************ */
/* * ************************************************************************************ */

function mailer($addr, $subject, $body, $altbody = null, $attach = null, $test = false, $cco = null) {
  $exito = FALSE;
  error_log('<ul class="level-0"> >>> <span class="date">' . date("Y-m-d H:i:s") . "</span> >>>>  MAIL $addr<li class='level-0'>$addr, $subject, $body</li>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');

  if (!isset($altbody) || is_null($altbody))    $altbody = "Su cliente de correo no puede interpretar correctamente este mensaje. Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. Disculpe las molestias";

  $mail = new phpmailer();
  //echo "POOORT: ".$mail->Port;die();
  $mail->CharSet = 'UTF-8';
  /* SENSE IMATGE CAPSALERA */
  if ($addr == MAIL_RESTAURANT)
    $body = str_replace('<img src="//www.can-borrell.com/cb_reserves/img/lg_sup.png" alt="img" width="303" height="114" border="0" title="INICI" />', "", $body);
 
  include(ROOT . INC_FILE_PATH . "mailer_profile_office.php");
  if ($addr == MAIL_RESTAURANT && isset($_POST['client_email']))    $mail->From = $_POST['client_email'];


  if ($attach)    $mail->AddAttachment($attach, basename($attach));

  $occo = '--NO CCO--<br>';
  error_log("<li>TEST: " . ($test ? 'SI' : 'NO') . '</li>', 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
  error_log("<li>ENVIA ACTIVAT: " . (ENVIA_MAILS ? "SI" : "NO") . '</li>', 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
  if ($test || ENVIA_MAILS === false && $addr!="alexbasurilla@gmail.com") {
    $exito = true;
    $o = ">>>>>>>" . date("d-m-Y") . "<br/>";
    $o.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" pageEncoding="UTF-8"/>';
    $o.= "<br/>charset=" . CHARSET . " *** mailer: " . $mail->CharSet . "<br/>";
    $o.= "MAIL TO: $addr  FROM: restaurant@can-borrell.com<br/>";
    if ($cco)
      $occo = "CCO: $cco<br/>";
    $o.=$occo;
    $o.= "SUBJECT: $subject<br/>";
    $o.= $body . EOL . EOL;
    $o.= "...............................................................................<br/><br/>" . EOL . EOL;
    $o.= "...............................................................................<br/><br/>" . EOL . EOL;
    $o.= "...............................................................................<br/><br/>" . EOL . EOL;

    $f = fopen(ROOT . INC_FILE_PATH . "log/test_mail.html", 'a');
    fwrite($f, "ENVIAT AMB EXIT: <br>\n" . $o);
    fwrite($f, $o);
    return;

    error_log("</ul>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
    return FALSE;
  }
  else {
      echo "HOST: ".$mail->Host;
      echo "PASS: ".$mail->Password;
      echo "Enviant....";
    $exito = $mail->Send();
   
    if (!$exito) {
echo "!FALLA";
echo  $mail->ErrorInfo;
      $err = $mail->ErrorInfo;
      //print_log("<span style='color:red'>MAILER ERROR:$err - </span> Enviat mail TO:$addr $cco SUBJECT: $subject");
      error_log("<li><span style='color:red'>MAILER ERROR:$err - </span> Enviat mail TO:$addr $cco SUBJECT: $subject </li>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
     // error_log("</ul>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');

      //return FALSE;
    }
    else {
        echo "exito";

      error_log("<li><span style='color:green'>MAILER SUCCESS:</span>: Enviat mail TO:$addr SUBJECT: $subject</li>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
     // error_log('<li>' . $body . '</li>, 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
      //return TRUE;
    }

  if ($cco == $addr)    $cco = NULL;
  if ($cco) {
    $mail->ClearAllRecipients();
    $mail->AddAddress($cco);
    $bodycco = str_replace('<img src="//www.can-borrell.com/cb_reserves/img/lg_sup.png" alt="img" width="303" height="114" border="0" title="INICI" />', "<br><br>---- COPIA RESTAURANT ----<br><br>", $body);
    $mail->Body = $bodycco;
    $exito2 = $mail->Send();

        error_log("<li><span style='color:green'>MAILER CCO:</span>:".( $exito2?'!!!SUCCESS!!!':'***ERROR***')." Enviat CCO TO: $cco SUBJECT: $subject</li>", 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
        error_log('<li>' . $bodycco . '</li>', 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
  }
  }    

  
        error_log( '</ul>', 3, ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt');
  
  return $exito;
}



function utf8mail($to,$s,$body,$from_name="x",$from_a = "info@x.com")
{
  $reply = $from_a;
  
    $s= "=?utf-8?b?".base64_encode($s)."?=";
    $headers = "MIME-Version: 1.0\r\n";
    $headers.= "From: =?utf-8?b?".base64_encode($from_name)."?= <".$from_a.">\r\n";
    $headers.= "Content-Type: text/plain;charset=utf-8\r\n";
    $headers.= "Reply-To: $reply\r\n";  
    $headers.= "X-Mailer: PHP/" . phpversion();
    return mail($to, $s, $body, $headers);
}

?>