<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");

 require(ROOT.DB_CONNECTION_FILE); 
 require_once(ROOT . INC_FILE_PATH.'valors.php'); 
 require_once(ROOT . INC_FILE_PATH.'alex.inc'); valida_admin('editar.php') ;

 $bodi="";
?>
<?php
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


$maxRows_reserves = 30;
$pageNum_reserves = 0;
if (isset($_GET['pageNum_reserves'])) {
  $pageNum_reserves = $_GET['pageNum_reserves'];
}
$startRow_reserves = $pageNum_reserves * $maxRows_reserves;

/******************************************************************************/	

$were="WHERE TRUE ";     
$were.=" AND num_2=666 ";  //// MOSTRA L'HISTORIC!!!!

$query_reserves = "SELECT *  FROM reserves ";
$order="ORDER BY IF(data < NOW(),1,0), IF(estat = 1,0,1),IF(estat = 2,0,1), IF(estat = 3,0,1),IF(estat = 7,0,1),estat, data";

$query_reserves .= $were.$order;

$query_limit_reserves = sprintf("%s LIMIT %d, %d", $query_reserves, $startRow_reserves, $maxRows_reserves);
$reserves = mysqli_query( $canborrell, $query_limit_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_reserves = mysqli_fetch_assoc($reserves);
if (isset($_GET['totalRows_reserves'])) {
  $totalRows_reserves = $_GET['totalRows_reserves'];
} else {
  $all_reserves = mysqli_query($GLOBALS["___mysqli_ston"], $query_reserves);
  $totalRows_reserves = mysqli_num_rows($all_reserves);
}
$totalPages_reserves = ceil($totalRows_reserves/$maxRows_reserves)-1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gestió de reserves</title>
<link href="reserves.css" rel="stylesheet" type="text/css" />
<link href="../css/estils.css" rel="stylesheet" type="text/css" />
               <?php echo Gestor::loadJQuery("2.0.3"); ?>
<script>
	$(function(){
		$(".cerca").click(function(e){
			$(this).attr("href",$(this).attr("href")+$("#ipcerca").val());
			return true;		
		});
		
		
	
	});

</script>
<style type="text/css">
<!--
.Estilo5 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {font-size: 16px}
INPUT {
	font-family: verdana, arial, helvetica;
	font-size: 11px;
	font-weight: bold;
	color: #770000;
	border:1px Solid #999999;
	background-color: #FFFFFF;
	}
.inputblanc {
	font-family: verdana, arial, helvetica;
	font-size: 11px;
	font-weight: bold;
	color: #770000;
	border:1px Solid #999999;
	background-color: #FFFFFF;
}

-->
</style>
</head>

<body <?php echo $bodi?>>
<table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td bgcolor="#570600" colspan="2" align="center"><table cellpadding="0" cellspacing="0" width="716" height="19" border="0">
      <tr>
        <td><span class="Estilo5">GESTI&Oacute; RESERVES</span>  
		<img src="../img/separa_mn.gif" alt="1" width="1" height="8" border="0" />
		<a href="../panel/gestio_calendari.php?f=../../../canBorrell_inc_LOCAL/llista_dies_negra_grups.txt"> GESTI&Oacute; DIES PLENS </a> 
		<img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" /> 
		<font color="#FFFFFF"><b><a href="editar.php?id=-1">EDITAR PREUS I SUGGERIMENTS </a></b>
		<img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" /> 
		<font color="#FFFFFF"><b><a href="llistat_historic.php">HISTÒRIC</a></b></font></font>
		
		</td>
		
        <td align="right">
<a href="dumpBD.php"> BACKUP</a>
<img src="../img/separa_mn.gif" alt="1" width="1" height="8" border="0" />
<a href="../cat/index.html">CAN BORRELL</a></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFDAC1">
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><div align="center">
      <p align="center" class="gran">Llistat HISTORIC de Reserves</p>
      </div></td>
  </tr>
  <tr>
    <td>
		<form method="post"  action="llistat.php"  onsubmit="JavaScript: if (confirm('Segur que vols esborrar les reserves marcades?\nRecordi que les reserves amb estat Eliminada s´esborraran definitivament')){return true;} else {return false;}">

	<table width="773" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#666666">
      <tr>
        <td width="60" align="center" bgcolor="#333333" class="Estilo2"><input id="ipcerca" name="cercaid" type="text" size="3" maxlength="5" style="height:15px;text-align:right;" />
          <a href="detall_historic.php?id=" class="cerca" ><img src="lupa.gif" alt="Cerca" width="20" height="20" border="0" style="vertical-align:bottom" /></a> </td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">estat</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">data</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">hora</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">nom</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">Tel&egrave;fon</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">e-mail</div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">adults + nens </div></td>
        <td bgcolor="#333333" class="Estilo2"><div align="center">preu reserva</div></td>
      </tr>
      <?php do { 
          	       $d1=cambiaf_a_normal($row_reserves['data']);
                   $d2=date("d/m/y");
                   $dif=compara_fechas($d1,$d2);
                   $color_data=($dif<0)?"#ff3333":"#CCCCCC";
          
          ?>
      <tr>
        <td align="center" bgcolor="#333333" class="llista"><div align="right"><a href="detall_historic.php?id=<?php echo $row_reserves['id_reserva']; ?>">&nbsp;&nbsp;<?php echo $row_reserves['id_reserva']; ?>&nbsp;&nbsp;</a></div></td>
        <td align="center" bgcolor="<?php echo $color[(int) $row_reserves['estat']]; ?>" class="estat"><?php echo $estat[(int) $row_reserves['estat']]; ?></td>
        <td align="right" bgcolor="<?php echo $color_data; ?>" class="estat"><?php echo data_llarga($row_reserves['data']); ?></td>
        <td align="right" bgcolor="#CCCCCC" class="estat"><?php echo substr($row_reserves['hora'],0,5); ?></td>
        <td bgcolor="#CCCCCC" class="llista" ><?php echo substr($row_reserves['nom'],0,15); ?></td>
        <td bgcolor="#CCCCCC" class="llista" ><?php echo $row_reserves['tel']; ?></td>
        <td bgcolor="#CCCCCC" class="llista" ><a href="mailto: <?php echo $row_reserves['email']; ?>" class="llista"><?php echo $row_reserves['email']; ?></a></td>
        <td align="right" bgcolor="#CCCCCC" class="llista"><?php echo (int)$row_reserves['adults']." + "; echo ((int)$row_reserves['nens10_14'])+((int)$row_reserves['nens4_9']); ?></td>
        <td align="right" bgcolor="#999999" class="llista"><span class="estat"><?php echo $row_reserves['preu_reserva']; ?></span></td>
		    <!--<td align="right" bgcolor="#999999" class="llista">
	<div align="center"><a href="llistat.php?del=xxxxx<?php echo $row_reserves['id_reserva']; ?>" class="llista Estilo6" onclick="JavaScript: if (confirm('Segur que vols esborrar la reserva <?php echo $row_reserves['id_reserva']; ?>?')){return true;} else {return false;}"> 
		  
		  X</a></div>   
          <div align="center"><input type="checkbox" style="background:#999999;" name="pdel[<?php echo $row_reserves['id_reserva'];?>]" value="checkbox" /></div></td> --> 
      </tr>
      <?php } while ($row_reserves = mysqli_fetch_assoc($reserves)); ?>
      <tr>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td>
        <td class="Estilo2">&nbsp;</td
          ><!-- <td class="Estilo2"><input type="submit" name="Submit" value="Del" />
     <br/><input type="submit" name="HISTORIC" value="Hist" />
        </td> -->   
      </tr>
	  
    </table>
	</form>
	
    </td>
  </tr>
  <tr>
    <td>
<table border="0" width="50%" align="center">
        <tr>
          <td width="10%" align="center">
		  
		  <?php 
		  $currentPage=$_SERVER['SCRIPT_NAME'];		  
		  $queryString_reserves='';// $_SERVER['QUERY_STRING'];
		  		  
		  if ($pageNum_reserves > 0) { // Show if not first page 
          ?>
		  	
                <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, 0, $queryString_reserves); ?>"><img src="../img/First.gif" border=0></a>
                <?php } // Show if not first page ?>
          </td>
          <td width="10%" align="center"><?php if ($pageNum_reserves > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, max(0, $pageNum_reserves - 1), $queryString_reserves); ?>"><img src="../img/Previous.gif" border=0></a>
                <?php } // Show if not first page ?>
          </td>
          <td wodth="60%"  align="center"> Registres <?php echo ($startRow_reserves + 1) ?> a <?php echo min($startRow_reserves + $maxRows_reserves, $totalRows_reserves) ?> de <?php echo $totalRows_reserves ?> </td>
          <td width="10%" align="center"><?php if ($pageNum_reserves < $totalPages_reserves) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, min($totalPages_reserves, $pageNum_reserves + 1), $queryString_reserves); ?>"><img src="../img/Next.gif" border=0></a>
                <?php } // Show if not last page ?>
          </td>
          <td width="10%" align="center"><?php if ($pageNum_reserves < $totalPages_reserves) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, $totalPages_reserves, $queryString_reserves); ?>"><img src="../img/Last.gif" border=0></a>
                <?php } // Show if not last page ?>
          </td>

    </td>
        </tr>
  </table>	
	</td>
  </tr>
</table>
</body>
</html>
<?php
((mysqli_free_result($reserves) || (is_object($reserves) && (get_class($reserves) == "mysqli_result"))) ? true : false); 
?>