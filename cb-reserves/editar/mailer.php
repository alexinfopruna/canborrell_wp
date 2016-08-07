<?php
require_once (ROOT.INC_FILE_PATH."PHPMailer-master/PHPMailerAutoload.php");
require_once(ROOT.INC_FILE_PATH.'alex.inc');
 
if (!defined('CONFIG'))
{
	if (!defined('ROOT')) 	define('ROOT', "../taules/");
	require_once(ROOT."php/Configuracio.php");
	$conf = new Configuracio();
}

function mailer_reserva($idr, $template, $addr, $subject, $body, $altbody, $attach=null, $test=false, $cco=null){
  $query = "INSERT INTO `email` ( `reserva_id`, `email_recipients`, `email_subject`, `email_body`, `email_resultat`,   `email_categoria`) "
      . "VALUES (  '$idr', '$addr', '$subject', '".base64_encode($body)."' , '0',  '$template');";
 $qry_result = mysqli_query($GLOBALS["___mysqli_ston"], $query)  or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
 $idt= mysqli_insert_id($GLOBALS["___mysqli_ston"]);
 
 
 $res = mailer($addr,$subject,$body,$altbody,$attach, $test, $cco);
  $resultat = $res?'1':'0';
  
   if ($test || ENVIA_MAILS===false) $resultat = '2';
  $query = "UPDATE email SET email_resultat = $resultat WHERE email_id = $idt";
  $qry_result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  
  return $res;
}

/***************************************************************************************/
/***************************************************************************************/
/***************************************************************************************/
/***************************************************************************************/
function mailer($addr,$subject,$body,$altbody = null,$attach=null, $test=false, $cco=null)
{  
  $exito = FALSE;
  error_log('<ul class="level-0"> >>> <span class="date">' . date("Y-m-d H:i:s") . "</span> >>>>  MAIL $addr<li class='level-0'>$addr, $subject, $body</li>",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');

  
  
  
  if (!isset($altbody) || is_null($altbody)) $altbody="Su cliente de correo no puede interpretar correctamente este mensaje. Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. Disculpe las molestias";
    
  $mail = new phpmailer();
  if (defined('CHARSET')) $mail->CharSet = CHARSET;
  $mail->CharSet = 'UTF-8';  
  
  /* SENSE IMATGE CAPSALERA */
  if ($addr==MAIL_RESTAURANT) $body=str_replace('<img src="http://www.can-borrell.com/img/lg_sup.gif" alt="img" width="303" height="114" border="0" title="INICI" />', "", $body);

 /*
  $mail->IsSMTP();
  $mail->Host = "mail.can-borrell.com";
  $mail->SMTPAuth = true;
  $mail->Username = "mail6224"; 
  $mail->Password = "joseprov";
  $mail->From = "info@can-borrell.com";
  $mail->FromName = "Reserves Can Borrell";
  $mail->Timeout=30;
  $mail->AddAddress($addr);
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->AltBody = $altbody;
  $mail->IsHTML(true);
  */
   include(ROOT.INC_FILE_PATH."mailer_profile.php");

  if ($addr=="info@can-borrell.com" && isset($_POST['client_email']))  $mail->From=$_POST['client_email'];
  if ($addr==MAIL_RESTAURANT && isset($_POST['client_email']))  $mail->From=$_POST['client_email'];
  
  if ($attach) $mail->AddAttachment($attach,basename($attach));
 
  $occo='';
  error_log("<li>TEST".$test.'</li>',3,ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
  error_log("<li>ENVIA ACTIVAT: ".(ENVIA_MAILS?"SI":"NO").'</li>',3,ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
  if ($test || ENVIA_MAILS===false)
  {
	  $exito=true;
          $o=">>>>>>>".date("d-m-Y")."<br/>";
	  $o.='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" pageEncoding="UTF-8"/>';
	  $o.='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" pageEncoding="UTF-8"/>';
	  $o.= "<br/>charset=".CHARSET." *** mailer: ".$mail->CharSet."<br/>";
	  $o.= "MAIL TO: $addr  FROM: info@can-borrell.com<br/>";
	  if ($cco) $occo= "CCO: $cco<br/>";
	  $o.=$occo;
	  $o.= "SUBJECT: $subject<br/>";  
	  $o.= $body.EOL.EOL;
	  $o.= "...............................................................................<br/><br/>".EOL.EOL;
	  $o.= "...............................................................................<br/><br/>".EOL.EOL;
	  $o.= "...............................................................................<br/><br/>".EOL.EOL;
          
	$f = fopen(ROOT.INC_FILE_PATH."log/test_mail.html", 'a');
	fwrite($f,"ENVIAT AMB EXIT: <br>\n".$o);
	fwrite($f,$o);
	  
 	 error_log("</ul>",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
                            return FALSE;
  }
   else
   {
      $exito = $mail->Send();
   }

   if ($cco == $addr) $cco=NULL;
   if ($cco) {
       $mail->ClearAllRecipients(); 
               $mail->AddAddress($cco);
               $body=str_replace('<img src="http://www.can-borrell.com/img/lg_sup.gif" alt="img" width="303" height="114" border="0" title="INICI" />', "", $body);
               $mail->Body=$body;
               $intentos=0;
               $exito2=false;
        while ((!$exito2) && ($intentos < 1)) { //NOMES UN INTENT
                       if (true) 
                       {
                               if ($intentos) sleep(3);
                               $exito2 = $mail->Send();	
                       }
               $intentos=$intentos+1;	
   }
      
   if(!$exito)
   {
     
         $err=$mail->ErrorInfo;
      //print_log("<span style='color:red'>MAILER ERROR:$err - </span> Enviat mail TO:$addr $cco SUBJECT: $subject");
      error_log("<li><span style='color:red'>MAILER ERROR:$err - </span> Enviat mail TO:$addr $cco SUBJECT: $subject",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
      error_log("</ul>",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
      
      return FALSE;
   }
   else
   {
      error_log("<li><span style='color:green'>MAILER SUCCESS:</span>: Enviat mail TO:$addr $cco SUBJECT: $subject</li>",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
      error_log('<li>'.$body.'</li></ul>',3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
     return TRUE;
   } 
     
   }
   
   return $exito;
}
?>