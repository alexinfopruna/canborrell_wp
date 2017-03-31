<?php 
header('Content-Type: text/html; charset=utf-8');

	if (!isset($_REQUEST['client_mobil'])) 
	{
		$json['resposta']="ko";
		$json['error']="No arriben dades al servidor";
		echo json_encode($json);	
		die();
	}

	define('ROOT',"../taules/");
	$AJAX=true;

	require_once("../reservar/Gestor_form.php");
	$gestor=new Gestor_form();
/****************************************************************************************/
// VALIDACIÓ
/****************************************************************************************/


/**/
	// COMPROVA CLIENT AMB RESERVA VIGENT
	$jsonClient=$gestor->recuperaClient($_REQUEST['client_mobil']);
	$client=json_decode($jsonClient);
	//Gestor::printr( $client);
	$json['resposta']="ko";
	$json['error']="";
	//echo $_REQUEST['client_mobil'];
	//print_r($client);
	if (isset($client)){		
		if($client->id_reserva || $client->id_reserva_grup) $json['error']="20";
	}
	
	//DADES CLIENT
	if(empty($_REQUEST['adults']) || $_REQUEST['adults']<6) $json['error']="Err adults";
	if(empty($_REQUEST['client_nom'])) $json['error']="Err client_nom";
	if(empty($_REQUEST['client_cognoms'])) $json['error']="Err client_cognoms";
	if(empty($_REQUEST['client_email'])) $json['error']="Err client_email";

	if (!empty($json['error']))
	{
		echo json_encode($json);	
		die();
	}
/****************************************************************************************/
// CONVERTEIX VARIABLES NOVES EN LES ANTIGUES PER FER SERVIR EL MATEIX PROCÈS
/****************************************************************************************/

	$_POST['redirect']="=https://www.can-borrell.com/cat/gracies.html";
	$_POST['subject']="Sol·licitud de reserva per a grups";
	$_POST['recipient']=MAIL_RESTAURANT;
	
	$_POST['DATA2']=$_REQUEST['selectorData'];
	$_POST['hora']=$_REQUEST['selectorHora'];
	$_POST['adults']=$_REQUEST['adults'];
	$_POST['nens10_14']=$_REQUEST['nens10_14']?$_REQUEST['nens10_14']:0;
	$_POST['nens4_9']=$_REQUEST['nens4_9']?$_REQUEST['nens4_9']:0;
	$_POST['cotxets']=isset($_REQUEST['selectorCotxets'])?$_REQUEST['selectorCotxets']:0;
	$_POST['menu']=$_REQUEST['menu_adults']=0;//ATENCIO MENUS PER CARTA!!!
	$_POST['txt_1']=$_REQUEST['menu_juniors']=0;//ATENCIO MENUS PER CARTA!!!
	$_POST['txt_2']=$_REQUEST['menu_nens']=0;//ATENCIO MENUS PER CARTA!!!
	$_POST['nom']=$_REQUEST['client_nom'];
	$_POST['tel']=$_REQUEST['client_mobil'];
	$_POST['fax']=$_REQUEST['client_telefon'];
	$_POST['email']=$_REQUEST['client_email'];
	$_POST['observacions']=$_REQUEST['observacions'];
	//$_POST['factura']=$_REQUEST['factura'];
	$_POST['factura_cif']=$_REQUEST['factura_cif'];
	$_POST['factura_nom']=$_REQUEST['factura_nom'];
	$_POST['factura_adresa']=$_REQUEST['factura_adresa'];
	
	
		
	//UPDATA EL CLIENT SI CAL
	$_POST['client_id']=$gestor->controlClient(false,$_REQUEST['client_mobil']);	
	//CODIFICA ESTAT RESERVA (cotxets,grups, online)
	$_POST['reserva_info']=$gestor->encodeInfo($_REQUEST['amplaCotxets'],1,1);
		
		$esborra= (isset($_POST['esborra_dades']) && $_POST['esborra_dades']=='on');
		$_POST['reserva_info']=$gestor->flagBit($_POST['reserva_info'],7,$esborra);

		$selectorCadiraRodes= (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes']=='on');
		$_POST['reserva_info']=$gestor->flagBit($_POST['reserva_info'],8,$selectorCadiraRodes);

		$selectorAccesible= (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible']=='on');
		$_POST['reserva_info']=$gestor->flagBit($_POST['reserva_info'],9,$selectorAccesible);

		$_POST['observacions']=preg_replace("/Portem cadira de rodes /","",$_POST['observacions']);
		if ($selectorCadiraRodes){
			$_POST['observacions']='Portem cadira de rodes '.$_POST['observacions'];
		}
				
	//BROWSER INFO --- ERROR AMB get_browser();
	//try{$browser = get_browser(null, true);}catch (Exception $e){$nothing=true;}
	//if (!isset($browser['parent'])) $browser['parent']='';
	//$reserva_navegador=$_SERVER['HTTP_USER_AGENT']." *** ".$browser['browser_name_pattern']." /// ".$browser['parent']." /// ".$browser['platform']." /// ".$browser['browser']." /// ".$browser['version']." /// ".$browser['cookies'];
	$reserva_navegador=$_SERVER['HTTP_USER_AGENT'];
	$_POST['reserva_navegador']=$reserva_navegador;
	
	//foreach($_POST as $k=>$v) $_POST[$k]=utf8_decode($v);
	include ("reserves.php");
	
	

?>