<?php 
header('Content-Type: text/html; charset=UTF-8');

define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");

if (!defined('USR_FORM_WEB')) define('USR_FORM_WEB',3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

$ruta_lang="../";
/**/
// ERROR HANDLER
//require_once("../taules/php/error_handler.php");

// CREA USUARI ANONIM
if (!isset($_SESSION)) session_start();
$usr=new Usuari(USR_FORM_WEB,"webForm",1);
if (!isset($_SESSION['uSer'])) $_SESSION['uSer']=$usr;

require_once(ROOT."/../reservar/Gestor_filtre_carta.php");
$gestor=new Gestor_filtre_carta();
require_once(ROOT . INC_FILE_PATH.'alex.inc');
require_once(ROOT . INC_FILE_PATH."llista_dies_taules.php");


if (!$gestor->valida_sessio(64))
{
	print "Has de fer login al panel!!";
	die();
}


//RECUPERA IDIOMA
$lang=$gestor->idioma(isset($_REQUEST["lang"])?$_REQUEST["lang"]:"");
$l=$gestor->lng;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<TITLE>Masia Can Borrell</TITLE>
<meta http-equiv="Content-Type" content="text/plain; charset=UTF-8" />
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.forms.css"   rel="stylesheet" />
<link type="text/css" href="../css/estils.css" rel="stylesheet" />
<link type="text/css" href="css/form_reserves.css" rel="stylesheet" />
<style>
	#bt-menu,#bt-carta,a.bt{float:left;margin-left:20px;color: #570600;margin-top: 8px;}
	
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
	
</style>



               <?php echo Gestor::loadJQuery("2.0.3"); ?>
<script type="text/javascript" src="js/form_filtre_carta.js?<?php echo time();?>"></script>

<?php
require_once(ROOT.'../reservar/translate_'.$gestor->lng.'.php');
?>
<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** -->
</HEAD>
<body>
  <a href="#" id="bt-carta" name="bt-carta" class="bt"><?php l('Publica / Despublica plats de la carta');?>  </a>
  <a href="#" id="bt-menu" name="bt-menu" class="bt"><?php l('Publica / Despublica menús');?>  </a>
  <a href="#" id="bt-sort" name="bt-sort" class="bt"><?php l('Ordena subfamílies');?>  </a>


  <div id="fr-cartaw-popup" title="<?php l("Publica / Despublica plats de la carta")?>"
    class="carta-menu" style="height: 300px">
    <div id="fr-carta-tabs">
      <?php echo $gestor->recuperaCarta(isset($row['id_reserva'])?$row['id_reserva']:NULL)?>
    </div>
  </div>

  <!-- ******************* CARTA-MENU *********************** -->
  <!-- ******************* CARTA-MENU *********************** -->
  <!-- ******************* CARTA-MENU *********************** -->

  <div id="fr-menu-popup" title="<?php l("Publica / Despublica menús")?>"
    class="carta-menu">
    <div id="fr-menu-tabs">
      <?php echo $gestor->recuperaCarta(null,true);?>
    </div>
  </div>

  <!-- ******************* CARTA-SORT *********************** -->
  <!-- ******************* CARTA-SORT *********************** -->
  <!-- ******************* CARTA-SORT *********************** -->

  <div id="fr-sort-popup" title="<?php l("Ordena les pestanyes de subfamília")?>" class="carta-sort">
		<?php print $gestor->recuperaSorter();?>
  </div>


</body>
</HTML>