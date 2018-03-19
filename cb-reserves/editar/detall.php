<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
require_once(ROOT . "Gestor_pagaments.php");
$pagaments = new Gestor_pagaments();

if (!isset($_SESSION)) session_start(); 

require(ROOT.DB_CONNECTION_FILE); 
require_once(ROOT . INC_FILE_PATH.'valors.php'); 
require_once(ROOT . INC_FILE_PATH.'alex.inc'); valida_admin('editar.php') ;
?>
  <?php
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

/******************************************************************************/	
$recordID = $_GET['id'];


if (!is_numeric($recordID)) $recordID=(int)substr($recordID,-6);
$query_DetailRS1 = "SELECT * FROM reserves WHERE id_reserva = $recordID AND (num_2<>666 OR num_2<=>NULL)";
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query( $canborrell, $query_limit_DetailRS1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);

//foreach($row_DetailRS1 as $k=>$v) $row_DetailRS1[$k]=Gestor::charset($v);

if (isset($_REQUEST['fac']) && $_REQUEST['fac']==1) echo ">>>>>>>>>>>>>>>>>>>> ".factura($row_DetailRS1,"../",true);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

$rec="";
if ($row_DetailRS1['num_1']>900) $rec=" <br><b><center>RECORDATORI ENVIAT</center><b>";

$b3=Gestor::flagBit($row_DetailRS1['reserva_info'], 3);
$b4=Gestor::flagBit($row_DetailRS1['reserva_info'], 4);
$cadira=Gestor::flagBit($row_DetailRS1['reserva_info'], 8);
$movilitat=Gestor::flagBit($row_DetailRS1['reserva_info'], 9);

$ampla="";
if ($b4) $ampla=$b3?" (Doble llarg)":" (Doble ample)";
$cadira=$cadira?' / <span style="color:red;">Cadira de rodes</span> ':'';
$movilitat=$movilitat?' / <span style="color:red;">Movilitat reduïda</span> ':'';


/***************************************************************************************/
/*************************          MAIL / SMS           *******************************/
/*************************          MAIL / SMS           *******************************/
/*************************          MAIL / SMS           *******************************/
/*************************          MAIL / SMS           *******************************/
/***************************************************************************************/
/***************************************************************************************/


/*************************************************************************************/
/********************************  SMS  *********************************************/
/********************************  SMS  *********************************************/
/********************************  SMS  *********************************************/
/*************************************************************************************/


$query_DetailRS1 = "SELECT * FROM sms WHERE sms_reserva_id = $recordID";
$DetailRS1 = mysqli_query( $canborrell, $query_DetailRS1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$nex= "";

$sms = ' <uib-accordion close-others="oneAtATime"> ';
while( $row = mysqli_fetch_assoc($DetailRS1)){
  //$class = $sms_confirma?'mail_ok':'mail_err';
  $sms .= '<uib-accordion-group class=""><uib-accordion-heading><span class="glyphicon glyphicon-comment"></span> '.$row['sms_data'].'</uib-accordion-heading>   '.$nex.$row['sms_data'].' :'.substr($row['sms_missatge'],0,40000);
  
  
  if(strlen($row['sms_missatge'])>40000)  $sms.="...";
  
  $sms .= '</uib-accordion-group>';
  $nex = "";
  
}
$sms .= '</uib-accordion>';

if ($pagaments->get_estat_multipago($row_DetailRS1['id_reserva'])== 8) {
  $row_DetailRS1['estat'] = 8;
  $total_coberts_pagats = $pagaments->get_total_coberts_pagats($row_DetailRS1['id_reserva']);
  $total_import_pagaments = $pagaments->get_total_import_pagaments($row_DetailRS1['id_reserva']);

  $total_coberts_pagats = " (" . ((int)$total_coberts_pagats) . ")";
  //$total_import_pagaments = " (" . ($total_import_pagaments) . "€)";

  $color[8] = "#00eeff";
//  $estat[8] = " MultiPagament <br>".($row_DetailRS1['adults'] + $row_DetailRS1['nens10_14'] + $row_DetailRS1['nens4_9'])." / $total_coberts_pagats";
  $estat[8] = " MultiPagament <br>".$row_DetailRS1['preu_reserva']." / Pagat: $total_import_pagaments";
}
else{
  $total_coberts_pagats = "";
  $total_import_pagaments = "";
}



//echo $mail_confirma;die();
//Reserva Grups CONFIRMADA
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>Detall de reserva</title>
<link href="reserves.css" rel="stylesheet" type="text/css" />
<link href="../css/estils.css" rel="stylesheet" type="text/css" />


<!------------ ANGUALAR + UI -------------->
  <link rel="stylesheet" type="text/css" media="all" href="../css/calendari.css" />
  <script type="text/javascript" src="../js/calendar.js"></script>
  <script type="text/javascript" src="../js/lang/calendar-ca.js"></script>
  <script type="text/javascript" src="../js/calendar-setup.js"></script>

  
      <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-animate.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.1.2.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-spinner/0.8.0/angular-spinner.min.js"></script>
    <script type="text/javascript" src="js/angular-loading-spinner.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

    <script src="js/detall.js"></script>
<!------------ ANGUALAR + UI -------------->

<style type="text/css">
  .email_body{overflow-x: scroll;}  
  .email_body{max-width:100% !important;}  
 table { 
    
    border-spacing: 2px;
    border-collapse: separate;
}

#detall tr{background-color: white;}
#detall  td{padding:2px !important;}
    
td a, td a:visited, td a:link {color:#ccc} 
td a:hover {color:white} 
<!--
.Estilo4 {font-size: 12px}
.Estilo6 {font-size: 9px}
.Estilo7 {color: #FFFFFF}

.sms{font-size:9px;}


            .mail_error{ cursor:pointer;color:white;background:red}
            .mail_ok{color:white;background:green}
            .mail_no{background:#FFF}

   @-webkit-keyframes blinker {
       from {opacity: 1.0;}
       to {opacity: 0.3;}
   }
   .blinkxx{
       text-decoration: blink;
       -webkit-animation-name: blinker;
       -webkit-animation-duration: 0.6s;
       -webkit-animation-iteration-count:infinite;
       -webkit-animation-timing-function:ease-in-out;
       -webkit-animation-direction: alternate;

-->
td{border:white solid 3px;}
</style>
</head>

    <body class="back">
<span us-spinner="{radius:30, width:8, length: 16}"></span>		
<table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td bgcolor="#570600" colspan="2" align="center"><table cellpadding="0" cellspacing="0" width="716" height="19" border="0">
      <tr>
        <td><a href="llistat.php" class="Estilo7">GESTI&Oacute; RESERVES </a> <img src="../img/separa_mn.gif" width="1" height="8" border="0" /><a href="gestio_dies.php"> GESTI&Oacute; DIES PLENS </a> <img src="../img/separa_mn.gif" width="1" height="8" border="0" /> <font color="#FFFFFF"><b><a href="editar.php?id=-1">EDITAR PREUS I SUGGERIMENTS</a></b></font></td>
        <td align="right"><a href="../cat/index.html">CAN BORRELL</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<table  id="detall" ng-app="detall" width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><div align="center">
      <p class="titol2">&nbsp;</p>
      <p class="titol2">Detall de Reserva</p>
    </div></td>
  </tr>
  <tr>
    <td><table border="0" align="center" cellpadding="3" cellspacing="3">
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">id_reserva</td>
          <td width="320" align="right" bgcolor="#333333" class="llista"><div align="left" class="titol2"><?php echo $row_DetailRS1['id_reserva']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">estat</td>
          <td width="320"  align="center" bgcolor="<?php if (($row_DetailRS1['estat']<0)||($row_DetailRS1['estat']>8)) $row_DetailRS1['estat']=0;echo $color[(int) $row_DetailRS1['estat']]; ?>" class="estat"><?php echo $estat[(int) $row_DetailRS1['estat']]; ?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">data de reserva</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo data_llarga($row_DetailRS1['data']); ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">hora</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo substr($row_DetailRS1['hora'],0,5); ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">nom</td>
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['nom']; ?></div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">M&ograve;bil</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['tel']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">Fixe</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['fax']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">e-mail</td>
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><a href="mailto: <?php echo $row_DetailRS1['email']; ?>" class="llista"><?php echo $row_DetailRS1['email']; ?></a> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">idioma</td>
          <td width="320" bgcolor="#CCCCCC" class="llista"><?php echo $row_DetailRS1['lang']; ?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">menu</td>
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php 
          $comanda=$gestor->plats_comanda($recordID);
          if ( $comanda) echo $comanda; 
           else echo ($mmenu[(int)$row_DetailRS1['menu']]['cat']); 
          
          ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">adults</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$row_DetailRS1['adults']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">nens de 10 a 14 anys<br/>
            men&uacute;s junior </td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div id="cal" align="left"><?php echo (int)$row_DetailRS1['nens10_14']."<br/>&nbsp;".$row_DetailRS1['txt_1']; ?>
          </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">nens de 4 a 9 anys<br/>
            men&uacute;s infantils </td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$row_DetailRS1['nens4_9']."<br/>&nbsp;".$row_DetailRS1['txt_2']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">cotxets de nadons </td>

          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$row_DetailRS1['cotxets'].$ampla.$cadira.$movilitat; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">observacions</td>
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['observacions']; ?></div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">resposta:</td>
          <td align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['resposta']; ?></div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">data creaci&oacute;</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (data_llarga($row_DetailRS1['data_creacio'])); ?></div></td>
        </tr>
        <tr ng-controller="llistatEmails" ng-init="init(<?php echo (int)$row_DetailRS1['id_reserva']; ?>)">
                  
           
          <td align="right" bgcolor="#333333" class="Estilo2" ng-class="confirmada?'btn-success':'btn-danger'"> Email</td>
          <td   width="320" align="right" bgcolor="#CCCCCC" class="llista sms"><div align="left">
                  <span ng-repeat="fila in files" ng-controller="emalist" ng-click="open(fila.email_id)" ng-class="className(fila.email_resultat, fila.email_restaurant)" class="btn" style="float:left"><span ng-hide="fila.email_resultat" class="glyphicon glyphicon-alert"> </span> <span class="glyphicon glyphicon-envelope"></span> {{fila.email_timestamp}} :{{fila.email_categoria}}</span>
                  
                  <?php
           
           // echo $mail; 
            
            ?>
                  
              </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">SMS</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista sms"><div align="left">
            <?php
           
            echo $sms; 
            
            ?>
                  
              </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">preu reserva</td>
		  <?php
                                                          
			if (file_exists('factures/'.NOM_FACTURA.date("Y")."-".$row_DetailRS1['id_reserva'].'.pdf'))
			{
				$factura='<a href="factures/'.NOM_FACTURA.date("Y")."-".$row_DetailRS1['id_reserva'].'.pdf" target="_blank"> - (Enviada Factura Proforma)</a>';

			}
			else
			{
				
				$factura=" (Preu menús: ".calcula_preu_real($row_DetailRS1,"../").")".($row_DetailRS1['factura']?" demana factura":"");
			}
		  
		  ?>
          <td width="320" align="right" bgcolor="#999999" class="llista"><div align="left" class="estat"><?php
          $pagats = $pagaments->get_total_coberts_pagats($row_DetailRS1['id_reserva']);
          $pagat = $pagaments->get_total_import_pagaments($row_DetailRS1['id_reserva']);
          echo $row_DetailRS1['preu_reserva']."€ / Pagats <b> $pagat € ($pagats coberts)</b> / ".$factura; ?> 
                      <table>
                    <?php                                              
                    $llista_pagaments = $pagaments->get_llistat_pagaments($row_DetailRS1['id_reserva']);
                    foreach ($llista_pagaments as $row): ?>
                                             
                                                <tr class="">
                                                    <td   class="Estilo5"><?php echo $row['pagaments_grups_nom_pagador']; ?></td>
                                                    <td   class="llista"><div  class="estat">
                                                            
                                                            <div  class="Estilo5 tar"><?php echo  " ( " .$row['coberts'] . " coberts) "?></div>
                                                        </div></td>
                                                        <td id="tar"><?php echo $row['pagaments_grups_import']."€ "  ?> </td>
                                                </tr>
                                              <?php endforeach; ?>

                  </table>
              </div></td>
        </tr>
        <?php if ($row_DetailRS1['factura']){?>
		<tr>
          <td align="right" bgcolor="#333333" class="Estilo2 Estilo4">dades facuració </td>
          <td align="right" bgcolor="#CCCCCC" class="llista Estilo4"><div align="left"><span class="estat"><?php echo $row_DetailRS1['factura_cif']."<br/>".$row_DetailRS1['factura_nom']."<br/>".$row_DetailRS1['factura_adresa']?></span></div></td>
        </tr>
		<?php }?>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2 Estilo4">data l&iacute;mit pagament </td>
          <td align="right" bgcolor="#CCCCCC" class="llista Estilo4"><div align="left"><span class="estat"><?php if ($row_DetailRS1['data_limit']>0) echo data_llarga($row_DetailRS1['data_limit']).$rec; ?></span></div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF" class="Estilo2 Estilo4">&nbsp;</td>
          <td width="320" align="right" bgcolor="#FFFFFF" class="llista Estilo4"><div align="left"><a href="edit_reserva.php?id=<?php echo $row_DetailRS1['id_reserva']; ?>" class="dins petita petita Estilo6">&lt;modificar valors&gt;</a></div></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <form id="form1" name="form1" method="post" action="apdeit.php?id=<?php echo $row_DetailRS1['id_reserva']; ?>">
					
        <div align="center">
          <input id="Confirmar" type="submit" name="Submit" value="Confirmar" />
          <input id="Denegar" type="submit" name="Submit" value="Denegar"/>
          <input id="Pagada" type="submit" name="Submit" value="Pagada" />
          <input id="Eliminar" type="submit" name="Submit" value="Eliminar" />
          <input id="Pendent" type="submit" name="Submit" value="Pendent" />
          <input type="hidden" name="P_ID" value="<?php echo $row_DetailRS1['id_reserva']; ?>" />
          <input type="hidden" name="estat" id="estat" value="<?php echo (int)$row_DetailRS1['estat']; ?>" />
          <input type="hidden" value="" id="data_limit" name="data_limit" style="width: 100%; border:0px; font-weight:bold; background-color:#F8F8F0; color:#999966;" val="OB" alt="Si us plau, tri&iuml; una data." readonly="READONLY" />
        </div>
      </form>
      <p>&nbsp;</p>
    <script language="JavaScript" type="text/javascript">
	var estat=0;
	estat=document.getElementById("estat").value;
	//alert (estat);
/*
  		document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Cancelar").style.display = "none";  
  		document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
*/
	switch(estat)
	{
	  case 0:
  		document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Cancelar").style.display = "none";  
  		//document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
 	  
	  break;
	  case "1":
	  //alert("WWWW");
  		//document.getElementById("Confirmar").style.display = "none";  
  		//document.getElementById("Denegar").style.display = "none";  
  		//document.getElementById("Pagada").style.display = "none";  
  		//document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
	  break;
	  case "2":
  		document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		//document.getElementById("Pagada").style.display = "none";  
  		document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
	  break;
	  case "3":
	  case "7":
	  case "8":
  		document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Pagada").style.display = "none";  
  		document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
	  break;
	  case "4":
  		document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Pagada").style.display = "none";  
  		document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
	  break;
	  case "5":
	  break;
  		//document.getElementById("Confirmar").style.display = "none";  
  		//document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Pagada").style.display = "none";  
  		//document.getElementById("Eliminar").style.display = "none";  
  		//document.getElementById("Pendent").style.display = "none";  
	  case "6":
  		//document.getElementById("Confirmar").style.display = "none";  
  		document.getElementById("Denegar").style.display = "none";  
  		document.getElementById("Pagada").style.display = "none";  
  		//document.getElementById("Eliminar").style.display = "none";  
  		document.getElementById("Pendent").style.display = "none";  
	  break;
	}
      </script>
	  <script type="text/javascript">
   Calendar.setup({
      inputField     :    "data_limit",     // id del campo de texto
     // ifFormat     :     "%d/%m/%Y",     // formato de la fecha que se escriba en el campo de texto
      ifFormat     :     "%y-%m-%d",     // formato de la fecha que se escriba en el campo de texto
      button     :    "Confirmar",     // el id del botón que lanzará el calendario
      displayArea: "cal",     // el id del botón que lanzará el calendario
	  firstDay:1,
	  weekNumbers: false,
//	  flat         : "calendar-container", // ID of the parent element
  onUpdate  : dateChanged          // our callback function
//	  dateStatusFunc : ourDateStatusFunc
});

function dateChanged(calendar) {

  if (!calendar.dateClicked) return false;

    var y = calendar.date.getFullYear();
    var m = calendar.date.getMonth()+1;     // integer, 0..11
    var d = calendar.date.getDate();      // integer, 1..31
  if (confirm("Data límit de pagament "+d+"/"+m+"/"+y+". Comfirmar reserva?")) 
  {
  	document.form1.action="apdeit.php?id=<?php echo $row_DetailRS1['id_reserva']; ?>&sub=Confirmar";
	//document.getElementById('data_limit').value=document.forms['form1'].action;
	document.forms['form1'].submit();
  	return true;
  }
  else
  {
    return false;
  }

}
	</script> 
	  
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center" class="titol">&nbsp;</p>
<p align="center" class="titol">&nbsp;</p>
<?php //factura($row_DetailRS1 ,"../",true);?>
</body>
</html><?php
((mysqli_free_result($DetailRS1) || (is_object($DetailRS1) && (get_class($DetailRS1) == "mysqli_result"))) ? true : false);
?>