<?php
	if (!defined('ROOT')) define('ROOT', "../taules/");
                            
                            
require (ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
if (!$gestor->valida_sessio(64))  
{
  header("Location: login.php");
  die();
}                            
	require_once(ROOT."Gestor.php");

	$cfg=new Configuracio();
	require(ROOT.INC_FILE_PATH."alex.inc");
	$factures=scan_Dir(ROOT.INC_FILE_PATH."factures/");

?><!DOCTYPE HTML>
<HTML>
<HEAD>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE> Llistat de factures Proforma </TITLE>
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link type="text/css" href="../reservar/css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	
<link type="text/css" href="../css/estils.css" rel="stylesheet" />	
<link type="text/css" href="../reservar/css/form_reserves.css" rel="stylesheet" />	
<style>
	.admin{display:none}
	body{backgroun-image:none;	}
	a.bt,a.bt:link,a.bt:visited{display:block;color:#666;text-align:left;}
	a.bt:hover{background:#570600;color:white;}
	
	h1{text-align:center;background:white;}
	.ui-accordion-header{text-align:center;font-size:1.5em}
	h4{background:#666;color:white;padding: 7px 7px 7px 7px;}
	
	.bt{padding:4px;margin:3px;}
	.caixa{
	/*float:left;*/
	/*width:400px;*/
	/*min-height:400px;*/
	height:350px;
	margin: 0px 15px 15px 15px;
	padding: 0px 5px 5px 5px;
	}	
	
	#panel{width:500px;margin:0 auto;}
	
	iframe{width:100%;height:1000px;display:none;background:white;background-image:none;}
	.cb-llistat{width:600px;margin:auto auto;background:white;padding:8px;border:darkgray solid 1px}
</style>
               <?php echo Gestor::loadJQuery("2.0.3"); ?>
</head>
<body>
<h1>Llistat de factures Proforma</h1>
<div class="cb-llistat ui-corner-all">
<?php
	foreach ($factures as $k=>$v)
	{
		echo '<a href="'.ROOT.INC_FILE_PATH.'factures/'.$v.'" target="_blank" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">'.$v.'</a>';
	}
?>
<div>

</body>
</html>