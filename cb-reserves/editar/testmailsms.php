<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
//require_once(ROOT."Gestor.php");
require(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
//if (!$gestor->valida_sessio())die("USUARI NO AUTORITZAT!");
//if (ENVIA_SMS == "1" )

ini_set('display_errors','On');
ini_set('error_reporting',1);
error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(E_ALL);
//error_reporting(NONE);
define ('SMS_ACTIVAT',true);

require(ROOT.DB_CONNECTION_FILE); 
require_once(INC_FILE_PATH.'valors.php'); 
require_once(INC_FILE_PATH.'alex.inc'); 
include_once( "SMSphp/EsendexSendService.php" );

$mensaini="";



?>


testmensamailsms.php?id=XXXXXX

<?php
echo mail_cli($_REQUEST['id']);



function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

/******************************************************************************/	
// CADUCADES



function mail_cli($id=false, $plantilla="templates/recordatori_cli.lbi")
{   
    require_once("mailer.php"); 
	global $camps, $mmenu,$txt,$database_canborrell, $canborrell,$lang,$gestor;
	//session_start();
	
	if ($id)
	{
		$query="SELECT * FROM reservestaules WHERE id_reserva=$id";
	}else{
		$query="SELECT * FROM reservestaules ORDER BY id_reserva DESC Limit 1";
	
	}
 
	/******************************************************************************/	
	$Result = mysqli_query( $canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$fila=mysqli_fetch_assoc($Result);
	
	$lang=$lang_cli=$fila['lang'];
        
        echo $query;
 print_r($fila);	
		$v=50;      
		$aki="<a href='http://www.can-borrell.com/editar/pagament.php?id=".$fila["id_reserva"]."&lang=$lang_cli' class='dins'>AQUI</a>";
        $copia="Recordatori de Reserva";
        $altbdy="Su reserva para el Restaurante Can Borrel ha sido confirmada. \n\nDebido a que su cliente de correo no puede interpretar correctamente este mensaje no es posible automatizar el proceso de pago.\n\n Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";
  
	
	
	$avui=date("d/m/Y");
	$ara=date("H:i");
	
	$file=$plantilla;

			$t=new Template('.','comment');
			$t->set_file("page", $file);
	
			$dat_limit=data_llarga($fila['data_limit'],$lang);
            $dlim="";
            if ($v==50) $dlim= $dat_limit;
	///////////// TEXTES
    if ($v==50){                   
            $idd=$fila['id_reserva']+100000;
            
            $fila['import']="***********";
            $mulink=substr($fila['email'],0,2).substr($fila['nom'],0,2).$idd."***".substr($fila['import'],0,2);
        
			$t->set_var('ident',$txt[75][$lang]);
			$t->set_var('confirma',$txt[76][$lang]);
			$t->set_var('cancela',$txt[77][$lang]);
			$t->set_var('id_banc',"RESERVA-".$fila['id_reserva']);
			$t->set_var('confirlink',$mulink);
			$t->set_var('cancelink',$mulink);
    }

			$t->set_var('caducada',$txt[80][$lang]);
			$t->set_var('avui',$avui);
			$t->set_var('titol',$txt[$v][$lang]);
			$t->set_var('text1',$txt[$v+1][$lang]);
			$t->set_var('text2',$txt[$v+2][$lang]);
			$t->set_var('data_limit',$dlim);
			$t->set_var('contacti',$txt[9][$lang]);
			$t->set_var('import',$preu=0);
			$t->set_var('aki',$aki);
			$t->set_var('datat',$datat=0);
	
			$t->set_var('cdata_reserva',$camps[8][$lang]);
			$t->set_var('cnom',$camps[1][$lang]);
			$t->set_var('cadults',$camps[2][$lang]);
			$t->set_var('cnens10_14',$camps[3][$lang]);
			$t->set_var('cnens4_9',$camps[4][$lang]);
			$t->set_var('ccotxets',$camps[5][$lang]);
			$t->set_var('cobservacions',$camps[6][$lang]);
			$t->set_var('cpreu_reserva',$camps[7][$lang]); 			
	//////////// DADES RESERVA
			$dat_cat=data_llarga($fila['data'],$lang);   
	
	
			$t->set_var('id_reserva',$fila['id_reserva']);
			$t->set_var('data',$dat_cat);
			$t->set_var('hora',substr($fila['hora'],0,5));
			$t->set_var('nom',$fila['nom']);
			$t->set_var('tel',$fila['tel']);
			$t->set_var('fax',$fila['fax']);
			$t->set_var('email',$fila['email']);
			$m=(int)$fila['menu'];
			$n=$mmenu[$m]['cat'];
                        
                        
                                    ///// COMANDA
                        $comanda=$gestor->plats_comanda($fila['id_reserva']);
                        if ($comanda) $n=$comanda;
                        else   $n=$mmenu[$m]['cat'];

			$t->set_var('menu',$n);
			$t->set_var('adults',(int)$fila['adults']);
			$t->set_var('nens10_14',(int)$fila['nens10_14']);
			$t->set_var('nens4_9',(int)$fila['nens4_9']);
                        $t->set_var('txt_1',"");
                        $t->set_var('txt_2',"");
                        $t->set_var('cresposta',$txt[79][$lang]);
                        $t->set_var('resposta',$fila['resposta']);
			$t->set_var('cotxets',(int)$fila['cotxets']);
			$t->set_var('observacions',$fila['observacions']);
			$t->set_var('preu_reserva',$fila['preu_reserva']);
							
			$t->parse("OUT", "page");
			$html=$t->get("OUT");
			
            //$t->p("OUT");
	$recipient=$fila['email'];
    $subject="..::Reserva Can Borrell: Recordatori reserva";
    //$r=mailer($recipient, $subject , $html, $altbdy, null, false, MAIL_CCO);
    
    echo $html;
    
    $nreserva=$fila['id_reserva'];
    print_log("Enviament RECORDATORI($r): $nreserva -- $recipient, $subject: $copia");


    ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
	return ($fila['id_reserva']);
}

function enviaSMS($numMobil, $importReserva, $diaReserva, $idReserva, $lang)
{
	global $txt;
	$mensa=$txt[92][$lang];
	echo "............$mensa.........";
	$mensa=str_replace("%diaReserva",$diaReserva,$mensa);
	$mensa=str_replace("%importReserva",$importReserva,$mensa);
	$mensa=str_replace("%idReserva",$idReserva,$mensa);
	
	
	// Test Variables - assign values accordingly:
	$username = "restaurant@can-borrell.com";			// Your Username (normally an email address).
	$password = "1909";			// Your Password.
	$accountReference = "EX0062561";		// Your Account Reference (either your virtual mobile number, or EX account number).
	$originator = "Rest.Can Borrell";		// An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).
	$recipients = $numMobil;		// The mobile number(s) to send the message to (comma-separated).
	$body = $mensa;			// The body of the message to send (must be less than 160 characters).
	$type = "Text";			// The type of the message in the body (e.g. Text, SmartMessage, Binary or Unicode).
	$validityPeriod = 0;		// The amount of time in hours until the message expires if it cannot be delivered.
	$result;			// The result of a service request.
	//$messageIDs = array($idReserva);		// A single or comma-separated list of sent message IDs.
	$messageStatus;			// The status of a sent message.
	
	$sendService = new EsendexSendService( $username, $password, $accountReference );
        //echo $lang."   ---------------------- TEEEST: $body  ---------------------------<br>";
	//if (ENVIA_SMS) $result = $sendService->SendMessage( $recipients, $body, $type );
	
	echo $body;
	
	//print_log("ENVIAT SMS: $numMobil RESERVA $idReserva");
	//print_log("RESULTAT ENVIO: ".$result['Result']." / ".$result['MessageIDs']);
}


?>