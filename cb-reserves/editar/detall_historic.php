<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");


require(ROOT.DB_CONNECTION_FILE); 
require_once(ROOT . INC_FILE_PATH.'valors.php'); 
require_once(ROOT . INC_FILE_PATH.'alex.inc'); valida_admin('editar.php') ;

?><?php
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

/******************************************************************************/	
$recordID = $_GET['id'];


if (!is_numeric($recordID)) $recordID=(int)substr($recordID,-6);
$query_DetailRS1 = "SELECT * FROM reserves WHERE id_reserva = $recordID AND num_2=666";
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query( $canborrell, $query_limit_DetailRS1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detall de reserva</title>
<link href="reserves.css" rel="stylesheet" type="text/css" />
<link href="../css/estils.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 12px}
.Estilo7 {color: #FFFFFF}
-->
</style>

  <link rel="stylesheet" type="text/css" media="all" href="../css/calendari.css">
  <script type="text/javascript" src="../js/calendar.js"></script>
  <script type="text/javascript" src="../js/lang/calendar-ca.js"></script>
  <script type="text/javascript" src="../js/calendar-setup.js"></script>
  <style type="text/css">
<!--
.Estilo8 {color: #660000}
-->
  </style>
</head>

<body>
		
<table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td bgcolor="#570600" colspan="2" align="center"><table cellpadding="0" cellspacing="0" width="716" height="19" border="0">
      <tr>
        <td><a href="llistat_historic.php" class="Estilo7">GESTI&Oacute; RESERVES </a> <img src="../img/separa_mn.gif" width="1" height="8" border="0" /><a href="gestio_dies.php"> GESTI&Oacute; DIES PLENS </a> <img src="../img/separa_mn.gif" width="1" height="8" border="0" /> <font color="#FFFFFF"><b><a href="editar.php?id=-1">EDITAR PREUS I SUGGERIMENTS</a></b></font></td>
        <td align="right"><a href="../cat/index.html">CAN BORRELL</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFDAC1">
  <tr>
    <td><div align="center">
      <p class="titol2">&nbsp;</p>
      <p class="titol2 Estilo8">Detall de Reserva (HISTORIC) </p>
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
          <td id="estat" width="320"  align="center" bgcolor="<?php if (($row_DetailRS1['estat']<0)||($row_DetailRS1['estat']>7)) $row_DetailRS1['estat']=0;echo $color[(int) $row_DetailRS1['estat']]; ?>" class="estat"><?php echo $estat[(int) $row_DetailRS1['estat']]; ?></td>
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
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['nom']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">tel</td>
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $row_DetailRS1['tel']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">fax</td>
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
          <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $mmenu[(int)$row_DetailRS1['menu']]['cat']; ?> </div></td>
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
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$row_DetailRS1['cotxets']; ?> </div></td>
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
          <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo data_llarga($row_DetailRS1['data_creacio']); ?></div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2">preu reserva</td>
          <td width="320" align="right" bgcolor="#999999" class="llista"><div align="left" class="estat"><?php echo $row_DetailRS1['preu_reserva']; ?> </div></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#333333" class="Estilo2 Estilo4">data l&iacute;mit pagament </td>
          <td align="right" bgcolor="#CCCCCC" class="llista Estilo4"><div align="left"><span class="estat"><?php if ($row_DetailRS1['data_limit']>0) echo data_llarga($row_DetailRS1['data_limit']); ?></span></div></td>
        </tr>
        <!--<tr>
          <td align="right" bgcolor="#FFFFFF" class="Estilo2 Estilo4">&nbsp;</td>
          <td width="320" align="right" bgcolor="#FFFFFF" class="llista Estilo4"><div align="left"><a href="edit_reserva.php?id=<?php echo $row_DetailRS1['id_reserva']; ?>" class="dins petita petita Estilo6">&lt;modificar valors&gt;</a></div></td>
        </tr> -->
      </table>
      <p>&nbsp;</p>
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
      button     :    "Confirmar",     // el id del bot�n que lanzar� el calendario
      displayArea: "cal",     // el id del bot�n que lanzar� el calendario
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
  if (confirm("Data l�mit de pagament "+d+"/"+m+"/"+y+". Comfirmar reserva?")) 
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
</body>
</html><?php
((mysqli_free_result($DetailRS1) || (is_object($DetailRS1) && (get_class($DetailRS1) == "mysqli_result"))) ? true : false);
?>