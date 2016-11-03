<?php
header('Content-Type: text/html; charset=utf-8');

define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");

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
$lang=$gestor->idioma($_REQUEST["lang"]);
$l=$gestor->lng;
?>
<!doctype html>
 
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

    <meta charset="utf-8" />
    <title>jQuery UI Sortable - Default functionality</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>
    <script>
    $(function() {
        $( "#sortable" ).sortable({ 
            update : function () { 
                var order = $('#sortable').sortable('serialize'); 
                $("#info").load("Gestor_filtre_carta.php?a=subfamilia_sorter&"+order); 
            } 
        });
        $( "#sortable" ).disableSelection();
    });
    </script>
</head>
<body>
<?php print $gestor->recuperaSorter();?>
</body>
</html>