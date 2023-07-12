<?php
if (!defined('MAIL_RESTAURANT')) define('MAIL_RESTAURANT','restaurant@can-borrell.com');
require_once ROOT.'../editar/html2pdf-master/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

/******************************************************************************************************/

include ROOT.'../editar/factura_factura.php';

/******************************************************************************************************/
/******************************************************************************************************/
// FUNCIONS GLOBALS
/******************************************************************************************************/
/******************************************************************************************************/
function calcula_preu($persones=null)
{
  $preu=6;
  //  24/11/2009 REBAIXES: les reserves eren 6euros (<25pers) i 10euros (>25)
  //  ara queda per 4 i 7
  
  if ($persones==null) $persones=$_POST['adults']+$_POST['nens10_14']+$_POST['nens4_9'];
  
  if ($persones<=25)
  {
    $preu=1*$persones; //abans 4
  }
  else
  {
    $preu=1*$persones; //abans 7
  }
  $preu=sprintf("%01.2f",$preu);
 return($preu."(ANULAT)");
}

function calcula_preu_real($fila,$doc_root)
{
	require_once(ROOT."Carta.php");
	$carta=new Carta();
	
	global $menuId;
	$menuAdults=$menuId[(int)$fila['menu']];
	$menuJR=isset($menuId[$fila['txt_1']])?$menuId[$fila['txt_1']]:'';
	$menuINF=isset($menuId[$fila['txt_2']])?$menuId[$fila['txt_2']]:'';
	$preu= $carta->preuPlat($menuAdults)*$fila['adults'] + 	$carta->preuPlat($menuJR)*$fila['nens10_14'] +  	$carta->preuPlat($menuINF)*$fila['nens4_9'];
	$reserva=$fila['preu_reserva'];
	$preu=($preu >= $reserva)? $preu:$reserva;
	$preu=sprintf("%01.2f",$preu);
	return $preu;//."(ANULAT)";

}

function factura($fila,$doc_root,$out=false)
{
	require_once(ROOT."Carta.php");
	$carta=new Carta();
	
	global $txt,$lang, $camps,$mmenu;
	// CALCULA PREU
    //require_once(ROOT . INC_FILE_PATH . "template.inc");

	$avui=date("d/m/Y");
	$file=ROOT."../editar/templates/factura_cli.lbi";
	
	$t=new Template('.','comment');
	$t->set_file("page", $file);
	$t->set_var("titol","FACTURA PROFORMA");
	$t->set_var("id_reserva",date("Y")."-".$fila['id_reserva']);
	$t->set_var("cdata_reserva",$txt[89][$lang]);    $t->set_var("data",$avui);
	$t->set_var("cif",$fila['factura_cif']);
	$t->set_var("cnom",$txt[91][$lang]);    $t->set_var("nom",$fila['factura_nom']);
	$t->set_var("cadresa",$txt[84][$lang]);    $t->set_var("adresa",$fila['factura_adresa']);

	global $menuId;
	$menuAdults=$menuId[(int)$fila['menu']];
	$menuJR=$menuId[$fila['txt_1']];
	$menuINF=$menuId[$fila['txt_2']];

	$m=(int)$fila['menu'];
	$n=$mmenu[$m]['cat'];
	$t->set_var('menu',$n." (".$carta->preuPlat($menuAdults)."&euro;)");	$t->set_var('totadults',sprintf("%01.2f",$carta->preuPlat($menuAdults)*$fila['adults']));
	$t->set_var('cadults',$camps[2][$lang]);   $t->set_var('adults',(int)$fila['adults']);
	if ($fila['nens10_14']>0)
	{
		$t->set_var('cnens10_14',$camps[3][$lang]);  
		$t->set_var('nens10_14',(int)$fila['nens10_14']." x ".$fila['txt_1']." (".$carta->preuPlat($menuJR)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuJR)*$fila['nens10_14']));  
	}	
	
	if ($fila['nens4_9']>0) 
	{
		$t->set_var('cnens4_9',$camps[4][$lang]);
		$t->set_var('nens4_9',(int)$fila['nens4_9']." x ".$fila['txt_2']." (".$carta->preuPlat($menuINF)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuINF)*$fila['nens4_9']));  
	}
			
	$t->set_var("cpreu_reserva",$txt[85][$lang]);$t->set_var("preu_reserva",calcula_preu($fila['adults']+$fila['nens10_14']+$fila['nens4_9']));
	$t->set_var("cpreu_subtotal",$txt[86][$lang]); $t->set_var("preu_subtotal",$preu=calcula_preu_real($fila,$doc_root));
	$t->set_var("cpreu_iva",$txt[87][$lang]);   $t->set_var("preu_iva",sprintf("%01.2f",$preu*IVA/100));
	$t->set_var("cpreu_total",$txt[88][$lang]); $t->set_var("preu_total",sprintf("%01.2f",$preu*(1+IVA/100)));
	
	
	
	$t->set_var("nota1",$txt[82][$lang]);
	$t->set_var("nota2",$txt[83][$lang]);
	$t->set_var("nota3",$txt[90][$lang]);
	$t->parse("OUT", "page");
	$html=$t->get("OUT");
	if ($out)$t->p("OUT");
	
	include_once (ROOT.'../editar/fpdf/html2fpdf.php');	
	include_once(ROOT.'../editar/fpdf/fpdf.php');	

	$pdf = new HTML2FPDF(); // Creamos una instancia de la clase HTML2FPDF
	$pdf -> AddPage(); // Creamos una página
	
	$html=fpdf_text($html); //CHARSET
	
	$pdf -> WriteHTML($html);//Volcamos el HTML contenido en la variable $html para crear el contenido del PDF
	$carpeta_factures=INC_FILE_PATH."factures/";

	$nompdf=$carpeta_factures.NOM_FACTURA.date("Y")."-".$fila['id_reserva'].".pdf";
	$pdf -> Output($nompdf,"F");//Volcamos el pdf generado con nombre 'doc.pdf'. En este caso con el parametro 'D' forzamos la descarga del mismo.
	
	return $nompdf;
}

function fpdf_text($str){
	return iconv('UTF-8', 'windows-1252', $str);
}


/* Genera PDF dela factura proforma
Retorna la ruta al fitxer creat
 *  */
function factura23($fila,$doc_root,$out=false)
{    
	include ROOT.'../editar/translate_factura.php';


	require_once(ROOT."Carta.php");
	$carta=new Carta();



	global $lang, $camps,$mmenu;
//print_r($txt);
        $lang=$lang_cli=$fila['lang'];
	$IVA=10;
	// CALCULA PREU
	$avui=date("d/m/Y");
	$file=dirname(__FILE__) . "/templates/factura_cli.lbi";

    require_once(ROOT . INC_FILE_PATH . "template.inc");

	$t=new Template('.','comment');
	$t->set_file("page", $file);
	$t->set_var("titol","FACTURA PROFORMA");
	$t->set_var("id_reserva",date("Y")."-".$fila['id_reserva']);
	$t->set_var("cdata_reserva",$txt[89][$lang]);    $t->set_var("data",$avui);
	$t->set_var("cif",$fila['factura_cif']);
	$t->set_var("cnom",$txt[91][$lang]);    $t->set_var("nom",$fila['factura_nom']);
	$t->set_var("cadresa",$txt[84][$lang]);    $t->set_var("adresa",$fila['factura_adresa']);

	global $menuId;
	$menuAdults=$menuId[(int)$fila['menu']];
	$menuJR=$menuId[$fila['txt_1']];
	$menuINF=$menuId[$fila['txt_2']];

	$m=(int)$fila['menu'];
	$n=$mmenu[$m]['cat'];
	$t->set_var('menu',$n." (".$carta->preuPlat($menuAdults)."&euro;)");	$t->set_var('totadults',sprintf("%01.2f",$carta->preuPlat($menuAdults)*$fila['adults']));
	$t->set_var('cadults',$camps[2][$lang]);   $t->set_var('adults',(int)$fila['adults']);
	if ( $fila['nens10_14']>0)
	{
		$t->set_var('cnens10_14',$camps[3][$lang]);  
		$t->set_var('nens10_14',(int)$fila['nens10_14']." x ".$fila['txt_1']." (".$carta->preuPlat($menuJR)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuJR)*$fila['nens10_14']));  
		 
	}	
	
	if ( $fila['nens4_9']>0) 
	{
		$t->set_var('cnens4_9',$camps[4][$lang]);
		$t->set_var('nens4_9',(int)$fila['nens4_9']." x ".$fila['txt_2']." (".$carta->preuPlat($menuINF)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuINF)*$fila['nens4_9']));  
	}
        
        $preu_reserva = $fila['preu_reserva'];
	$preu_reserva = sprintf("%01.2f",$preu_reserva);
	//$t->set_var("cpreu_reserva",$txt[85][$lang]);$t->set_var("preu_reserva",calcula_preu($fila['adults']+$fila['nens10_14']+$fila['nens4_9']));
	$t->set_var("cpreu_reserva",$txt[85][$lang]);$t->set_var("preu_reserva",$preu_reserva);
	$t->set_var("cpreu_subtotal",$txt[86][$lang]); $t->set_var("preu_subtotal",$preu=calcula_preu_real($fila,$doc_root));
	$t->set_var("cpreu_iva",$txt[87][$lang]);   $t->set_var("preu_iva",sprintf("%01.2f",$preu*$IVA/100));
	$t->set_var("cpreu_total",$txt[88][$lang]); $t->set_var("preu_total",sprintf("%01.2f",$preu*(1+$IVA/100)));
	

	
	$t->set_var("nota1",$txt[82][$lang]);
	$t->set_var("nota2",$txt[83][$lang]);
	$t->set_var("nota3",$txt[90][$lang]);
	$t->parse("OUT", "page");
	$content = $html=$t->get("OUT");
echo $content;
    try {
        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content);
        
        $carpeta_factures=INC_FILE_PATH."factures/";
        //$carpeta_factures=ROOT."factures/";
	$nompdf=$carpeta_factures.NOM_FACTURA.date("Y")."-".$fila['id_reserva'].".pdf";
        
        $html2pdf->output($nompdf,"F");//Volcamos el pdf generado con nombre 'doc.pdf'. En este caso con el parametro 'D' forzamos la descarga del mismo.
    } catch (Html2PdfException $e) {
        $html2pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }
    return $nompdf;
}
