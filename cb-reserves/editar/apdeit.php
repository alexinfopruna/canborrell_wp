<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
if (!defined('T_RESERVES')) define('T_RESERVES', "reserves");
require_once(ROOT."Gestor.php");
require_once(ROOT."gestor_reserves.php");

if (!isset($_SESSION)) session_start(); 

require_once(INC_FILE_PATH.'alex.inc');valida_admin('editar.php');


require(ROOT.DB_CONNECTION_FILE); 
require_once(INC_FILE_PATH.'valors.php'); 
require_once('mailer.php');
 
//$lang='cat';
((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));


$id = $id_reserva = $_GET['id'];

$P_ID = isset($_POST['P_ID'])?$_POST['P_ID']:FALSE;
if (isset($_GET["sub"]) && $_GET["sub"]=="Confirmar") $_POST["Submit"]="Confirmar";
$func=$_POST["Submit"];
//die("TOT BEEE");
if (isset($_GET['resend'])) $func="Confirmar";
if ($id!=$P_ID) return;
$SMS=null;


$gestor = new gestor_reserves();
valida_admin('editar.php');

$reserva = $gestor->load_reserva($id_reserva, 'reserves');
$lang_r=Gestor::codelang($reserva['lang']);
require_once(ROOT."../editar/translate_editar_$lang_r.php");





switch($func)
{
case "Pendent":
    $estat=1;
  break;

  case "Confirmar":
    $estat=2;
    //$SMS="TU RESERVA {ID} PARA EL DIA {DIA} ESTA CONFIRMADA.HEMOS ENVIADO MAIL CON INTRUCCIONES PARA EL PAGO.SI NO RECIBES MAIL REVISA SPAM O CANTACTANOS: restaurant@can-borrell.com";

    $SMS=Gestor::lv("LA RESERVA {ID} PER AL DIA {DIA} ESTA CONFIRMADA.HEM ENVIAT MAIL AMB INTRUCCIONS PER AL PAGAMENT.");
    $SMS.=Gestor::lv("SI NO REPS MAIL REVISA SPAM O CANTACTAN'S: restaurant@can-borrell.com");
  break;
  
  case "Denegar":
    $estat=4;
   // $SMS="TU RESERVA {ID} PARA EL DIA {DIA} HA SIDO DENEGADA. TE HEMOS ENVIADO EMAIL CON MAS DETALLES.SI NO RECIBES MAIL REVISA SPAM O CANTACTANOS: restaurant@can-borrell.com";
        $SMS=Gestor::lv("LA RESERVA {ID} PER AL DIA {DIA} HA ESTAT DENEGADA.HEM ENVIAT MAIL AMB MES DETALLS.");
        $SMS.=Gestor::lv("SI NO REPS MAIL REVISA SPAM O CANTACTAN'S: restaurant@can-borrell.com");

    break;

  case "Pagada":
    $estat=3;

    $SMS=Gestor::lv("HEM REBUT CONFIRMACIO DEL PAGAMENT DE LA TEVA RESERVA {ID} PER AL DIA {DIA}. TE ESPERAMOS EN CAN-BORRELL");

    
    $SMS="";

    break;

  case "Eliminar":
    $estat=2;
  break;

  default:
    $estat=0;
  break;    
}


if (($func=="Eliminar")&&($id==$P_ID))
{
   $query="DELETE FROM reserves WHERE id_reserva=$id AND estat=5";
   $result=mysqli_query($canborrell, $query);
   $query2='UPDATE reserves SET estat=5 WHERE id_reserva='.$id;
   $result=mysqli_query($canborrell, $query2);
   // print_log("Reserva Esborrada: $id");
    
   Gestor::xgreg_log("<span class='grups'>Reserva Esborrada: <span class='idr'>$id</span></span>",0,'/log/logGRUPS.txt');
      Gestor::xgreg_log("<span class='grups'>$query</span>",1,'/log/logGRUPS.txt');
         Gestor::xgreg_log("<span class='grups'>$query2</span>",1,'/log/logGRUPS.txt');
   header("location: llistat.php");

}
else{
  
if (!isset($_GET['resend']))
{    
    $d_limit=$_POST['data_limit'];
   $query='UPDATE reserves SET estat='.$estat.', num_1=0, data_limit="'.$d_limit.'" WHERE id_reserva='.$id;
   //print_log("Reserva modificada: $id / estat=$estat / data limit=$d_limit ---- $query");
   Gestor::xgreg_log("<span class='grups'>Reserva modificada: <span class='idr'>$id</span> / estat=$estat / data limit=$d_limit ---- </span>",0,'/log/logGRUPS.txt');
   Gestor::xgreg_log("<span class='grups'>$query</span>",1,'/log/logGRUPS.txt');
   
   //echo $query;
   $result=mysqli_query($canborrell, $query);  
    //mysql_free_result($result);

   $m=mail_SMS_cli($id,$SMS); 
}else{
  $id = $_GET['resend'];
   $result=mysqli_query($canborrell, $query); 
  $m=mail_SMS_cli($id , $SMS); 
}

   $mensa="?msg=1&idr=$id&";
  $mensa.=$m['mail_cli']?"&mail_cli=ok":"&mail_cli=err";
   $mensa.=$m['mail_rest']?"&mail_rest=ok":"&mail_rest=err";
   $mensa.=$m['sms']?"&sms=ok":"&sms=err";
  header("location: llistat.php".$mensa); 
  
}


/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
function mail_SMS_cli($id=false,$SMS=null)
{    
  $resultats = array('mail_cli'=>FALSE,'mail_rest'=>FALSE,'sms'=>FALSE);
  $copia = "Sense plantilla ";
  $d=false;
  
   Gestor::xgreg_log("<span class='mail'>ENVIA SMS+MAIL: <span class='idr'>$id</span></span>",0,'/log/logGRUPS.txt');
  
	global $camps, $mmenu,$txt,$database_canborrell, $canborrell,$lang;
	if (!isset($_SESSION)) session_start();
	
	if ($id)
	{
		$query="SELECT * FROM reserves WHERE id_reserva=$id";
	}else{
		$query="SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";
	
	}
	
	((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));
	$Result = mysqli_query( $canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$fila=mysqli_fetch_assoc($Result);
                            $id = $fila['id_reserva'];
 	$lang=$lang_cli=$fila['lang'];

 	/*** ENVIA SMS ***/ 	
 	$SMS=str_replace('{ID}', $id, $SMS);
 	$SMS=str_replace('{DIA}', $fila['data'], $SMS);
 	//echo "ID: $id / SMS: $SMS";
 	$g=new gestor_reserves();
                      
       Gestor::xgreg_log("<span class='grups'>Enviament SMS(Pendent...): <span class='idr'>$id</span></span>",1,'/log/logGRUPS.txt');
   Gestor::xgreg_log("<span class='grups'>Enviament SMS: <span class='idr'>$id</span></span>",0,'/log/logMAILSMS.txt');
                       /*******************************************************/
                       /*******************************************************/
                       /*******************************************************/
                      /**********/ $sms=$g->enviaSMS($id, $SMS);
                       /*******************************************************/
                       /*******************************************************/
                       /*******************************************************/
     $r=$sms?"<span class='EXIT'>EXIT</span>":"<span class='ERROR'>ERROR</span>";
     if ($sms) $resultats['sms'] = TRUE;
   Gestor::xgreg_log("<span class='grups'>RESULTAT SMS($d): <span class='idr'>$id</span></span>",1,'/log/logMAILSMS.txt');
                           
 	error_log("</ul>",3, ROOT . INC_FILE_PATH .'/log/logMAILSMS.txt');
 	
 	
	switch ((int)$fila['estat'])
	{
          case 2: // RESRVA CONFIRMADA
		$v=10; 
                                                        $lng = Gestor::newlang($lang_cli);
            
            
		//$aki="<a href='http://www.can-borrell.com/editar/pagament256.php?id=".$fila["id_reserva"]."&lang=$lang_cli' class='dins'>AQUI</a>";
                                                        $b64=base64_encode($fila["id_reserva"]."&".$fila['tel']."&".$lng);
                                                        //var_dump(base64_decode($b64));die();
                                                        $aki="<a href='http://www.can-borrell.com/reservar/pagament?rid=$b64&lang=$lng' class='dins'>AQUI</a>";
                                                        
        $copia="Reserva Grups CONFIRMADA";
        $subject="Can-Borrell: RESERVA CONFIRMADA";
        $altbdy="Su reserva para el Restaurante Can Borrel ha sido confirmada. \n\nDebido a que su cliente de correo no puede interpretar correctamente este mensaje no es posible automatizar el proceso de pago.\n\n Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";
 	  break;
	
          case 3: // PAGAMENT OK
		$v=20;
		$preu=$fila['preu_reserva'];
	//    $datat=cambiaf_a_normal($fila['data']).", ".$fila['hora']."h";
		$datat=data_llarga($fila['data'],$lang).", ".$fila['hora']."h";
        $copia="Reserva Grups PAGADA";
        $subject="Can-Borrell: NOTIFICACIÓ DE PAGAMENT REBUDA";
		if ($fila['factura']) 
		{
			$attach=factura($fila,"../",false);
			//echo "SIII ATACH: ".$attach;
		}
		else
		{
			//echo $fila['factura']." NO ATACH: ".$attach;
		}	
		
		$altbdy="Se ha registrado el pago de su reserva. \n\nDebido a que su cliente de correo no puede interpretar correctamente este mensaje no es posible mostrar los datos de la reserva.\n\n Si tiene alguna duda, por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";
		
	  break;
	
          case 4: // RESERVA DENEGADA
		$v=30;
		$aki="<a href='http://www.can-borrell.com/cat/contactar.php?id=".$fila["id_reserva"]."&lang=$lang_cli' class='dins'>AQUÍ</a>";
        $altbdy="Lamentamos informarle que la reserva que solicitó para el restaurante Can Borrell ha sido denegada por encontrarse el comedor lleno.\n\n Para más información, por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";
    $copia="Reserva Grups DENEGADA";
    $subject="Can-Borrell: RESERVA DENEGADA";
	  break;
	  
	  default:
               $subject="..::Reserva Can Borrell::..";
		 return "0";
              
	  break;
	}
	
	
	$avui=date("d/m/Y");
	$ara=date("H:i");
	
	$file="templates/mail_cli.lbi";

			$t=new Template('.','comment');
			$t->set_file("page", $file);
	
			$dat_limit=data_llarga($fila['data_limit'],$lang);
            $dlim="";
            if ($v==10) $dlim= $txt[$v+2][$lang].$dat_limit.$txt[$v+3][$lang];
	///////////// TEXTES
    if ($v==10){      
    				if (!isset($fila['import'])) $fila['import']='';             
            $idd=$fila['id_reserva']+100000;
            $mulink=substr($fila['email'],0,2).substr($fila['nom'],0,2).$idd."***".substr($fila['import'],0,2);
        
			$t->set_var('ident',	$txt[75][$lang]);
			$t->set_var('confirma',$txt[76][$lang]);
			$t->set_var('cancela',$txt[77][$lang]);
			$t->set_var('id_banc',"RESERVA-".$fila['id_reserva']);
			$t->set_var('confirlink',$mulink);
			$t->set_var('cancelink',$mulink);
    }
		
			$t->set_var('avui',$avui);
			$t->set_var('titol',$txt[$v][$lang]);
			$t->set_var('text1',$txt[$v+1][$lang]);
			if ($v!=10) $t->set_var('text2',$txt[$v+2][$lang]);
			$t->set_var('data_limit',$dlim);
			$t->set_var('contacti',$txt[9][$lang]);
			if (!isset($preu)) $preu="";
			$t->set_var('import',$preu);
			if (!isset($aki)) $aki='';
			$t->set_var('aki',$aki);
			if (!isset($datat)) $datat="";
			$t->set_var('datat',$datat);
	
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
            //$gestor=new gestor_reserves();
            $comanda=$g->plats_comanda($fila['id_reserva']);
           if ($comanda) $n=$comanda;
            else   $n=$mmenu[$m]['cat'];
                        
                        
			$t->set_var('menu',$n);
			$t->set_var('adults',(int)$fila['adults']);
			$t->set_var('nens10_14',(int)$fila['nens10_14']);
			$t->set_var('nens4_9',(int)$fila['nens4_9']);
            //$t->set_var('txt_1'," menú: ".$fila['txt_1']);
            //$t->set_var('txt_2'," menú: ".$fila['txt_2']);
            $t->set_var('txt_1',"");
            $t->set_var('txt_2',"");
            $t->set_var('cresposta',$txt[79][$lang]);
			if (($fila['resposta']=="")||(!isset($fila['resposta']))) $fila['resposta']=="RECIBIDO / REBUT";   
            $t->set_var('resposta',$fila['resposta']);
			$t->set_var('cotxets',(int)$fila['cotxets']);
			$t->set_var('observacions',$fila['observacions']);
			$t->set_var('preu_reserva',$fila['preu_reserva']);
							
			$t->parse("OUT", "page");
			$html=$t->get("OUT");
			//$t->p("OUT");
			//exit();
	$recipient=$fila['email'];
    //$subject="..::Reserva Can Borrell::..";
    if (!isset($attach))$attach=null;
    
    $r = FALSE;
    $r=mailer_reserva($id, $copia, $recipient, $subject , $html, $altbdy,$attach,false,MAIL_CCO);
    $envio = $r?'<span class="exit">ENVIAT OK</span>':'<span class="error">ERROR</span>';
    $nreserva=$fila['id_reserva'];
    $att=$attach?" -- FACTURA: $attach":"";
    //print_log("Enviament mail($r): $nreserva -- $recipient, $subject: $copia $att");
    Gestor::xgreg_log("<span class='grups'>Enviament mail($envio): <span class='idr'>$nreserva</span> -- $recipient, $subject: $copia $att</span>",1,'/log/logGRUPS.txt');

    if ($r) $resultats['mail_cli'] = TRUE;
    if (!$r) echo "ERROR en l'enviament del mail!!!!!";
    
    ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
	//return ($fila['id_reserva']);
    return $resultats;
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
function mail_restaurant($id=false)
{    
	global $mmenu,$txt,$database_canborrell, $canborrell;
	session_start();
	
	if ($id)
	{
		$query="SELECT * FROM reserves WHERE id_reserva=$id";
	}else{
		$query="SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";
	
	}
	
	((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));
	
	((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));
	$Result = mysqli_query( $canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$fila=mysqli_fetch_assoc($Result);
	$id = $fila['id_reserva'];
	$avui=date("d/m/Y");
	$ara=date("H:i");
	$file="templates/pagat_rest.lbi";
	
	
			$t=new Template('.','comment');
			$t->set_file("page", $file);
	
	///////////// TEXTES
			$t->set_var('avui',$avui);
			$t->set_var('titol',$txt[10][$lang]);
			$t->set_var('text1',$txt[11][$lang]);
			$t->set_var('text2',$txt[12][$lang]);
			$t->set_var('contacti',$txt[22][$lang]);
	
			$t->set_var('cdata_reserva',$camps[8][$lang]);
			$t->set_var('cnom',$camps[1][$lang]);
			$t->set_var('cadults',$camps[2][$lang]);
			$t->set_var('cnens10_14',$camps[3][$lang]);
			$t->set_var('cnens4_9',$camps[4][$lang]);
			$t->set_var('ccotxets',$camps[5][$lang]);
			$t->set_var('cobservacions',$camps[6][$lang]);
			$t->set_var('cpreu_reserva',$camps[7][$lang]);
			
	
			
	//////////// DADES RESERVA
			$dat_cat=data_llarga($fila['data']);   
	
	
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
            $gestor=new gestor_reserves();
            $comanda=$gestor->plats_comanda($fila['id_reserva']);
           if ($comanda) $n=$comanda;
            else   $n=$mmenu[$m]['cat'];

			$t->set_var('menu',$n);
			$t->set_var('adults',(int)$fila['adults']);
			$t->set_var('nens10_14',(int)$fila['nens10_14']);
			$t->set_var('nens4_9',(int)$fila['nens4_9']);
            //$t->set_var('txt_1'," menú: ".$fila['txt_1']);
            //$t->set_var('txt_2'," menú: ".$fila['txt_2']);
            $t->set_var('txt_1',"");
            $t->set_var('txt_2',"");
            $t->set_var('cresposta',$txt[79]['cat']);
            $t->set_var('resposta',$fila['resposta']);
			$t->set_var('cotxets',(int)$fila['cotxets']);
			$t->set_var('observacions',$fila['observacions']);
			$t->set_var('preu_reserva',$fila['preu_reserva']);
							
			$t->parse("OUT", "page");
			$html=$t->get("OUT");
		   // $t->p("OUT");
	
	
    $recipient = MAIL_RESTAURANT;  
    $subject = "..::Reserva Can Borrell: Confirmació pagament reserva de grup"; 

    $r=mailer_reserva($ir, "pagat_rest", $recipient, $subject, $html, $altbdy);
    $r=$r?"<span class='EXIT'>EXIT</span>":"<span class='ERROR'>ERROR</span>";
    $nreserva=$fila['id_reserva'];
    //  print_log("Enviament mail($r): $nreserva -- $recipient, $subject");
   Gestor::xgreg_log("<span class='grups'>Enviament mail($r): <span class='idr'>$nreserva</span> -- $recipient, $subject: $copia $att</span>",1,'/log/logGRUPS.txt');
	
    ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
	return ($fila['id_reserva']);
}
?>
