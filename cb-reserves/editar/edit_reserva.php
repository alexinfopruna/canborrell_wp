<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");

require(ROOT.DB_CONNECTION_FILE); 
require_once(ROOT . INC_FILE_PATH.'valors.php'); 
require_once(ROOT . INC_FILE_PATH.'alex.inc'); valida_admin('editar.php') ;

$id=$_GET["id"];

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (!isset($_POST['data'])) $_POST['data']=null;
$data=cambiaf_a_mysql($_POST['data']);


$query_reserves = "SELECT * FROM reserves WHERE id_reserva=$id ORDER BY estat ";
//$query_limit_reserves = sprintf("%s LIMIT %d, %d", $query_reserves, $startRow_reserves, $maxRows_reserves);
$reserves = mysqli_query( $canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Recordset1 = mysqli_fetch_assoc($reserves);

//if ($_POST['estat']==1 && ($row_Recordset1['estat']==3 || $row_Recordset1['estat']==7))
$avis="";

$estat[0]="Pendent";
$estat[1]="Pendent";
$estat[2]="Confirmada";
$estat[3]="Pagada tranferència";
$estat[4]="Caducada";
$estat[5]="Denegada";
$estat[6]="Eliminada";
$estat[7]="Pagada tarja";
$estat[100]="Petita";


require_once(ROOT . "Gestor_pagaments.php");
$pagaments = new Gestor_pagaments();
$pagat  = $pagaments->get_total_import_pagaments($id);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE reserves SET num_1=000, data=%s, nom=%s, tel=%s, fax=%s, email=%s, lang=%s,hora=%s, menu=%s, adults=%s, nens10_14=%s, nens4_9=%s, cotxets=%s, observacions=%s, resposta=%s, txt_1=%s, txt_2=%s,estat=%s, preu_reserva=%s WHERE id_reserva=%s",
                       GetSQLValueString($data, "date"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['hora'], "text"),
                       GetSQLValueString($_POST['menu'], "int"),
                       GetSQLValueString($_POST['adults'], "int"),
                       GetSQLValueString($_POST['nens10_14'], "int"),
                       GetSQLValueString($_POST['nens4_9'], "int"),
                       GetSQLValueString($_POST['cotxets'], "int"),
                       GetSQLValueString($_POST['observacions'], "text"),
                       GetSQLValueString($_POST['resposta'], "text"),
                       GetSQLValueString($_POST['txt_1'], "text"),
                       GetSQLValueString($_POST['txt_2'], "text"),
                       GetSQLValueString($_POST['estat'], "int"),
                       GetSQLValueString($_POST['preu_reserva'], "double"),
                       GetSQLValueString($_POST['id_reserva'], "int"));

  /******************************************************************************/	
  $Result1 = mysqli_query( $canborrell, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  //print_log("Modificació valors: ".$_POST['id_reserva']);
  $res=$_POST['id_reserva'];

   Gestor::xgreg_log("<span class='grups'>Modificació reserva GRUPS: <span class='idr'>$res</span></span>",0,'/log/logGRUPS.txt');
   $anterior = Gestor::log_array($row_Recordset1);
   Gestor::xgreg_log("Valor anterior:<br>$anterior",1,'/log/logGRUPS.txt');
  $coberts = $_POST['adults'] + $_POST['nens10_14'] + $_POST['nens4_9'];
   if ($_POST['estat']!=$row_Recordset1['estat']) $avis="\\n\\nL`estat de la reserva passarà de ".$estat[$row_Recordset1['estat']]." a ".$estat[$_POST['estat']];
$preu_persona = $pagaments->get_preu_persona_reserva();
   if ($_POST['preu_reserva']!=($coberts) * $preu_persona) $avis .= "\\n\\nEl preu (".$_POST['preu_reserva'].") no escorrespon amb els coberts ($coberts)";
if ($pagat>$row_Recordset1['preu_reserva']) $avis .= "\\n\\nS`ha pagat un import ($pagat) superior a la reserva (".$_POST['preu_reserva'].")";
if ($pagat && $_POST['estat']!=3 && $_POST['estat']!=7) $avis .= "\\n\\nS'han realitzat pagaments d'aquesta reserva i l'estat (".$estat[$_POST['estat']].") no ho reflexa";

   
   
//  header("location: llistat.php"); 
}
?>

<?php
/******************************************************************************/	
if (isset($_GET['totalRows_reserves'])) {
  $totalRows_reserves = $_GET['totalRows_reserves'];
} else {
  $all_reserves = mysqli_query($GLOBALS["___mysqli_ston"], $query_reserves);
  $totalRows_reserves = mysqli_num_rows($all_reserves);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gestió de reserves</title>
<link href="reserves.css" rel="stylesheet" type="text/css" />
<link href="../css/estils.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    td a, td a:visited, td a:link {color:#ccc} 
td a:hover {color:white} 
<!--
.Estilo7 {font-size: 18px}
.Estilo8 {font-size: 12px}
-->
</style>


     <?php echo Gestor::loadJQuery("2.0.3"); ?>
        <script>
          var avis = "<?php echo $avis;?>";
          $(function () {
            if (avis){
              alert("ATENCIÓ!\n\n"+avis);
              $(location).attr('href', 'llistat.php');
            }
          });
          </script>

</head>

<body>
<table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td bgcolor="#570600" colspan="2" align="center"><table cellpadding="0" cellspacing="0" width="716" height="19" border="0">
      <tr>
        <td><a href="llistat.php">GESTI&Oacute; RESERVES </a> <img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" /><a href="gestio_dies.php"> GESTI&Oacute; DIES PLENS </a> <img src="../img/separa_mn.gif" alt="1" width="1" height="8" border="0" /> <font color="#FFFFFF"><b><a href="editar.php?id=-1">EDITAR PREUS I SUGGERIMENTS</a></b></font></td>
        <td align="right"><a href="../cat/index.html">CAN BORRELL</a></td>
      </tr>
    </table></td>
  </tr>
</table>


<table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
	
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <p align="center"><span class="titol2">Modificar   Reserva </span></p>
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Id_reserva:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><span class="estat"><?php echo $row_Recordset1['id_reserva']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Data:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="data" type="text" value="<?php echo cambiaf_a_normal($row_Recordset1['data']); ?>" size="32"> 
        (dd/mm/aaaa) </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Hora:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="hora" type="text" value="<?php echo $row_Recordset1['hora']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Nom:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="nom" type="text" value="<?php echo $row_Recordset1['nom']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">M&ograve;bil:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="tel" type="text" value="<?php echo $row_Recordset1['tel']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Fixe:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="fax" type="text" value="<?php echo $row_Recordset1['fax']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Email:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="email" type="text" value="<?php echo $row_Recordset1['email']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2">Idioma</td>
      <td width="300" bgcolor="#CCCCCC" class="llista">
	  
	  <!--<input name="lang" type="text" value="<?php echo $row_Recordset1['lang']; ?>" size="32" /> -->
        <select name="lang">
			<OPTION VALUE="cat" <?php if (substr($row_Recordset1['lang'],0,2)=="ca") echo "selected='selected'";?>/>CA
			<OPTION VALUE="esp" <?php if (substr($row_Recordset1['lang'],0,2)=="es") echo "selected='selected'";?>/>ES
			<OPTION VALUE="en" <?php if (substr($row_Recordset1['lang'],0,2)=="en") echo "selected='selected'";?>/>EN
        </select>       
	  
	  
	    (CA / ES / EN) </td>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Menu:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista">
        <select name="menu">
			<OPTION VALUE="0" <?php if ((int)$row_Recordset1['menu']==0) echo "selected='selected'";?>/>Men&uacute; nº1
			<OPTION VALUE="1" <?php if ((int)$row_Recordset1['menu']==1) echo "selected='selected'";?>/>Men&uacute; nº1 Celebraci&oacute;
			<OPTION VALUE="2" <?php if ((int)$row_Recordset1['menu']==2) echo "selected='selected'";?>/>Men&uacute; nº2
			<OPTION VALUE="3" <?php if ((int)$row_Recordset1['menu']==3) echo "selected='selected'";?>/>Men&uacute; nº2 Celebraci&oacute;
			<OPTION VALUE="4" <?php if ((int)$row_Recordset1['menu']==4) echo "selected='selected'";?>/>Men&uacute; nº3
			<OPTION VALUE="5" <?php if ((int)$row_Recordset1['menu']==5) echo "selected='selected'";?>/>Men&uacute; Cal&ccedil;otada
			<OPTION VALUE="6" <?php if ((int)$row_Recordset1['menu']==6) echo "selected='selected'";?>/>Men&uacute; Comuni&oacute;
			<OPTION VALUE="7" <?php if ((int)$row_Recordset1['menu']==7) echo "selected='selected'";?>/>Men&uacute; Casaments
			<OPTION VALUE="8" <?php if ((int)$row_Recordset1['menu']==8) echo "selected='selected'";?>/>Carta
			<OPTION VALUE="9" <?php if ((int)$row_Recordset1['menu']==9) echo "selected='selected'";?>/>Men&uacute; nº4
        </select> </td>
    <tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Adults:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="adults" type="text" value="<?php echo (int)$row_Recordset1['adults']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Nens10_14 / Men&uacute;:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="nens10_14" type="text" value="<?php echo (int)$row_Recordset1['nens10_14']; ?>" size="32" /> 
        / <input name="txt_1" type="text" size="14"  value="<?php echo $row_Recordset1['txt_1']; ?>"/>
          
          <br/>
          <span class="petita">men&uacute;: junior / jr_comu; / jr_casa 
          
          </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Nens4_9 / Men&uacute;:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="nens4_9" type="text" value="<?php echo (int)$row_Recordset1['nens4_9']; ?>" size="32"> 
        / 
          <input name="txt_2" type="text" size="14"  value="<?php echo $row_Recordset1['txt_2']; ?>"/>
          <br/>
        <span class="petita">men&uacute;: infantil / inf_comu / inf_casa </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Cotxets:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="cotxets" type="text" value="<?php echo (int)$row_Recordset1['cotxets']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Observacions:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><textarea name="observacions" cols="10" rows="6"><?php echo $row_Recordset1['observacions']; ?></textarea>
          </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2">Resposta</td>
      <td valign="baseline" bgcolor="#CCCCCC" class="llista"><textarea name="resposta" cols="10" rows="6"><?php echo $row_Recordset1['resposta']; ?></textarea>
	  
<!--	  <input name="resposta" type="text" value="<?php echo $row_Recordset1['resposta']; ?>" size="32" /></td>
 -->    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Estat:</span></td>
      <td width="300" valign="baseline" bgcolor="#CCCCCC" class="llista"><table>
        <tr>
          <td class="llista"><input   checked="checked" type="radio" name="estat" value="1" style="background:#CCCCCC;" <?php if (!(strcmp((int)$row_Recordset1['estat'],1))) {echo "CHECKED";} ?>>
            Pendent</td>
        </tr>
        <tr>
          <td class="llista"><input type="radio" name="estat" value="2" style="background:#CCCCCC;" <?php if (!(strcmp((int)$row_Recordset1['estat'],2))) {echo "CHECKED";} ?>>
            Confirmada</td>
        </tr>
        <tr>
          <td class="llista"><input type="radio" name="estat" value="3" style="background:#CCCCCC;" <?php if ((int)$row_Recordset1['estat']==3)  {echo "CHECKED";} ?>>
            Pagada Transfer</td>
        </tr>
        <tr>
          <td class="llista"><input type="radio" name="estat" value="7" style="background:#CCCCCC;" <?php if ((int)$row_Recordset1['estat']==7)  {echo "CHECKED";} ?>>
            Pagada Tarja</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#333333" class="Estilo2"><span class="Estilo8">Preu_reserva:</span></td>
      <td width="300" bgcolor="#CCCCCC" class="llista"><input name="preu_reserva" type="text" value="<?php echo $row_Recordset1['preu_reserva']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap class="Estilo2 Estilo8">&nbsp;</td>
      <td width="300" bgcolor="#FFFFFF" class="llista"><input type="submit" value="Actualitzar registre"></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="id_reserva" value="<?php echo $row_Recordset1['id_reserva']; ?>">
</p>
  <p>&nbsp;  </p>
</form>	</td>
  </tr>
</table>
<p>&nbsp;</p>


<p>&nbsp;</p>
</body>
</html>
<?php
((mysqli_free_result($reserves) || (is_object($reserves) && (get_class($reserves) == "mysqli_result"))) ? true : false);
?>