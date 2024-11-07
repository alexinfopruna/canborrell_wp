<?php
/***************************************************/
//
// CODIFICACIO ESTAT
//
// 1 PENDENT
// 2 CONFIRMADA
// 3 PAGAT TRANSF 
// 4 DENEGADA
// 5 ELIMINADA
// 6 CADUCADA
// 7 PAGAT TPV
// 100 RES.PETITA
/***************************************************/

if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");
require_once(ROOT."gestor_reserves.php");


require_once(ROOT . INC_FILE_PATH.'alex.inc');

require(ROOT.DB_CONNECTION_FILE); 
require_once(ROOT . INC_FILE_PATH.'valors.php'); 
require_once('mailer.php'); 


/******************************************************************************/	

echo "<DIV align=center><br><br>Gràcies, la seva reserva ha estat cancel·lada / Gracias, su reserva ha sido cancelada</DIV>";

$id = intval(substr($_GET['id'],5,5));
// COMPROVA QUE NO ESTIGUI JA CONFIRMADA
$query='SELECT * FROM reserves WHERE id_reserva='.$id." AND estat<>1";
$result=mysqli_query($canborrell, $query);
$norepe=mysqli_num_rows($result);
if (!$norepe) 
{
    echo '<meta http-equiv="Refresh" content="5;URL=../index.html" />' ;          
    echo "<br><br>(CANCEL·LACIO REPETIDA)";
    exit();
}




//$query='UPDATE reserves SET estat=1 WHERE id_reserva='.$id;  
$query='UPDATE reserves SET estat=5 WHERE id_reserva='.$id;  
$result=mysqli_query($canborrell, $query);
print_log("Reserva Cancelada pel client: $id");
mail_restaurant($id); 
    //mysql_free_result($result);
echo "<DIV align=center><br><br>Gràcies, la seva reserva ha estat cancel·lada / Gracias, su reserva ha sido cancelada</DIV>";




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
	
	/******************************************************************************/	
	
	/******************************************************************************/	
	$Result = mysqli_query( $canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$fila=mysqli_fetch_assoc($Result);
	
	$avui=date("d/m/Y");
	$ara=date("H:i");
	$file=getcwd(). "/templates/cancel_rest.lbi";
	
	
			$t=new Template('.','comment');
			$t->set_file("page", $file);
	
	///////////// TEXTES
			$t->set_var('self',$file);
			$t->set_var('avui',$avui);
			$t->set_var('titol',"RESERVA CANCELADA PEL PROPI CLIENT");
			$t->set_var('text1',$txt[11][$lang]);
			$t->set_var('text2',$txt[12][$lang]);
			$t->set_var('contacti',$txt[22][$lang]);
	
			$t->set_var('cdata_reserva',$camps[8][$lang]);
			$t->set_var('cnom',$camps[1][$lang]);
			$t->set_var('cadulst',$camps[2][$lang]);
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
			$t->set_var('cotxets',(int)$fila['cotxets']);
			$t->set_var('observacions',$fila['observacions']);
			$t->set_var('preu_reserva',$fila['preu_reserva']);
							
			$t->parse("OUT", "page");
			$html=$t->get("OUT");
            //////// SORTIDA PER PANTALLA
            //$t->p("OUT");
	        ///////////////////////////
	
	
    $recipient = MAIL_RESTAURANT;  
    $subject = "Can-Borrell: RESERVA GRUP CANCEL·LADA: ".$fila['id_reserva']; 

    $r=  mailer_reserva($fila['id_reserva'], 'Cancelació grups', $recipient, $subject, $html, $altbdy);
    $nreserva=$fila['id_reserva'];
    print_log("Enviament mail($r): $nreserva -- $recipient, $subject");
	
    ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
	return ($fila['id_reserva']);
}


?>
<meta http-equiv="Refresh" content="5;url=../index.html" />