<?php 
if (!defined('ROOT')) define('ROOT',"../../taules/");
require_once(ROOT."Gestor.php");


if (!isset($lang)) $lang="esp";
require_once(ROOT.INC_FILE_PATH.'valors.php'); 
$titol['cat']="EL PAGAMENT S'HA REALITZAT AMB ÈXIT.<br><br>Gràcies per utilitzar aquest servei.";
$titol['esp']="EL PAGO SE HA REALIZADO CON ÉXITO.<br><br>Gracias por utilizar este servicio";
$titol['en']="THE PAYMENT IS COMPLETE.<br><br>Thank you for using this service";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagament correcte</title>
<link href="../reserves.css" rel="stylesheet" type="text/css" />
<link href="../../css/estils.css" rel="stylesheet" type="text/css" />

</head>

<body>
		
<table width="725" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td width="775" colspan="2" align="right" background="../../img/fons_9a.jpg"><a href="../../index.html"><img src="../../img/lg_sup.gif" alt="img" width="303" height="114" border="0" title="INICI" /></a></td>
  </tr>
  <tr>
    <td bgcolor="#570600" colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
<table width="725" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><span class="titol"><?php echo $titol[$lang] ?></span></td>
  <td width="12">  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  <td>  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  <td>  </tr>
  <tr>
    <td width="12">&nbsp;</td>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td><p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">
      <p><?php echo $txt[9][$lang] ?></p>
      </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>