<?php 
$id=5002;
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");
require(ROOT."gestor_reserves.php");
require(ROOT.DB_CONNECTION_FILE); 
require_once('valors23.php'); 
 
$gestor=new gestor_reserves();

require("mailer_1.php");
echo "Enviant...";

		$query="SELECT * FROM reserves WHERE id_reserva=$id";
	((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));
	$Result = mysqli_query( $canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$fila=mysqli_fetch_assoc($Result);
                            $id = $fila['id_reserva'];
 	$lang=$lang_cli=$fila['lang'];
                      
		$v=20;
		$preu=$fila['preu_reserva'];
		$datat=data_llarga($fila['data'],$lang).", ".$fila['hora']."h";
        $copia=Gestor::lv("Reserva Grups PAGADA");
        $subject=Gestor::lv("Can-Borrell: NOTIFICACIÓ DE PAGAMENT REBUDA")." ".$fila['id_reserva'];


		if ($fila['factura']) 
		{
                    echo "A veeer";
			$attach=factura23($fila,"../",false);
			echo "SIII ATACH: ".$attach;
		}
		else
		{
			//echo $fila['factura']." NO ATACH: ".$attach;
		}	
		
		$altbdy="Se ha registrado el pago de su reserva. \n\nDebido a que su cliente de correo no puede interpretar correctamente este mensaje no es posible mostrar los datos de la reserva.\n\n Si tiene alguna duda, por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";

?>
