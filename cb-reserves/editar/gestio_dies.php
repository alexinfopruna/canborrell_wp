<?php
header('Content-Type: text/html; charset=UTF-8');

if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();   
if (!$gestor->valida_sessio())  header("Location: index.php");

$showBlancs=true;
if (isset($_GET['hideBlancs'])) $showBlancs=false;

require_once(ROOT . INC_FILE_PATH."llista_dies_taules.php");
$fitxer=ROOT . INC_FILE_PATH."bloq.txt";
//if (!empty($_REQUEST['f'])) $fitxer=ROOT . INC_FILE_PATH."llista_dies_negra.txt";

if (isset($_GET['f'])) $fitxer=$_GET['f'];

//$dies=llegir_dies($fitxer);

if (isset($_POST["bloq"]))
{

  $dat=$_POST["datab"];
  $dat.="\n";
      $gestor->xgreg_log("<span class='grups'>Bloqueja dia GRUPS: <span class='idr'>".$_POST["bloq"]."</span> > $dat </span>",0,'/log/logGRUPS.txt');
  
  	$gestor = @fopen($fitxer, "a");
	if ($gestor) 
    {
       $d=strtok($dat, "-/");
       $m=strtok( "-/"); $m++;
       $y=strtok( "\n\t\r");
       $dat=$d."-".$m."-".$y."\n";
         
        
       fputs($gestor,$dat);
         //($gestor, $dat);   
	   fclose ($gestor);	

    }
    else
    {
        echo "ERROR ESCRIVINT DATA!!!";    
    }

}

$dies=llegir_dies($fitxer	);


if (isset($_POST["dbloq"]))
{
  $dat=$_POST["datab"];
       $d=strtok($dat, "-/");
       $m=strtok( "-/"); //$m++;
       $y=strtok( "\n\t\r");
       $dat=$d."-".$m."-".$y;
    
      $gestor->xgreg_log("<span class='grups'>Desbloqueja dia GRUPS: <span class='idr'>".$_POST["bloq"]."</span> > $dat </span>",0,'/log/logGRUPS.txt');
       
       
    $key = array_search($d, $dies[$m]);  
    //unset ($dies[$m][$key]);
    $dies[$m][$key]=0;
    
    guarda_dies($fitxer, $dies, $y);
}

?>

<HTML>
<HEAD>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<TITLE> Masia Can Borrell </TITLE>
	<LINK rel="stylesheet" type="text/css" href="../css/estils.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" media="all" href="../css/calendari.css">
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/lang/calendar-ca.js"></script>
<script type="text/javascript" src="../js/calendar-setup.js"></script>


<style type="text/css">
<!--
.special { background-color: #CC0000; color: #999999; }
.disabled { background-color: #CC0000; color: #999999; }

body {
	margin-top: 20px;
}
.Estilo5 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style></HEAD>
<BODY>
<CENTER>

<div style="background:white;padding:10px;width:753px;">
<?php echo "Editem: ".$fitxer;
	echo '
	<h4>ELS DIES BLOQUEJATS AFECTEN NOMÉS AL FORMULARI DE RESERVES GRUPS</h4>
';
?>

	<br/>
	<br/>
	<br/>
</div>

<form name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

  <table width="773" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td>	
      <a href="llistat.php">Torna a la gestió de reserves GRUPS</a></td>
     <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
 <tr>
  <tr>
    <td>&nbsp;</td>
    <td>	
	 </td>
    <td>&nbsp;</td>
   </tr>
 <tr>
    <td width="262">&nbsp;</td>
    <td width="200" align="center"><strong>BLOQUEJA DIES (RECORDA QUE DILLUNS I DIMARTS SEMPRE QUEDEN BLOQUEJATS)</strong> </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
  <tr>
    <td width="250">&nbsp;</td>
    <td>
	<div align="center" style="float:left; border:1px solid #999966;" id="calendar-container"></div>
						<div align="center">
						  <script type="text/javascript">
//ALEX						
						
<?php

echo crea_llista_js($dies);  
?>


						
						
						  function dateChanged(calendar) {
							if (calendar.dateClicked) {
							
						      var y = calendar.date.getFullYear();
						      var m = calendar.date.getMonth();     // integer, 0..11
						      var d = calendar.date.getDate();      // integer, 1..31
						      document.getElementById('DATA').value = calendar.date;
								//alert(y+" "+m+" "+d);
							  if (dateIsSpecial(y, m, d))
							  {							  
 							      document.getElementById("desbloq").style.display = "";
								  document.getElementById("bloq").style.display = "none";
							  }
							  else
							  {
								  document.getElementById("desbloq").style.display = "none";
								  document.getElementById("bloq").style.display = "";							  
							  }
							  
							  ara = new Date();
							  calend = new Date(y,m,d+1);
							  
							  if (calend<ara)
							  {
							 // alert("VA!");
								  document.getElementById("desbloq").style.display = "none";
								  document.getElementById("bloq").style.display = "none";						  
							  }



							  document.getElementById('datab').value=d+"-"+m+"-"+y;
							  
							  var d = new Date();
							  d = calendar.date;
							  document.getElementById('DATA').value = Setmana[d.getDay()]+", "+calendar.date.getDate()+" "+Mesos[calendar.date.getMonth()]+ " de "+calendar.date.getFullYear();
							  
							  
							  
						    }
						  };
						  
///// ALEX						  
function dateIsSpecial(year, month, day) {
var m = SPECIAL_DAYS[month];
if (!m) return false;
for (var i in m) if (m[i] == day) return true;
return false;
};


function disableFunc(date) {
alert("RRR");
return true;
        if (date.getDay() == 1 || date.getDay() == 2  || date.getDay() == 3  || date.getDay() == 4  || date.getDay() == 5  ) {
            return true;
        } else {
            return true;
        }
    }


function ourDateStatusFunc(date, y, m, d) {

if (dateIsSpecial(y, m, d))
{
//return "disabled";
return "special";
}
else
{return false; }// other dates are enabled
// return true if you want to disable other dates
};
				  

						  Calendar.setup(
						    {
								firstDay:1,
								weekNumbers: false,
						      flat         : "calendar-container", // ID of the parent element
						      flatCallback : dateChanged,          // our callback function
							  dateStatusFunc : ourDateStatusFunc
						    });
						  
						  
						  
						</script>
                        </div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">
	<input type="text" value="" ID="DATA" name="Data" style="width: 100%; border:0px; font-weight:bold; background-color:#F8F8F0; color:#999966;" VAL="OB" ALT="Si us plau, triï una data." READONLY>	</td>
    <td valign="top"><input id="datab"  type="hidden" name="datab" value=""></td>
    </tr>
</table>
<table width="773" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>
	  <div align="center">
	    <input  id="bloq" type="submit" name="bloq" value="Bloquejar">
	    <input id="desbloq" type="submit" name="dbloq" value="Desbloquejar">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </div></td>
    </tr>
 
 <tr>
    <td>	<p>&nbsp;</p>
      <p>
	  
		<?php if ($showBlancs):?>
			<iframe width="100%" height="300px" src="gestio_nits.php" style="border:0"></iframe>
		<?php endif; ?>
	</p></td>
    </tr>
	
</table>
<p>&nbsp;</p>
</form>



<p>
  <SCRIPT>
var Setmana = ["Diumenge","Dilluns","Dimarts","Dimecres","Dijous","Divendres","Dissabte"];
var Mesos = ["de Gener","de Febrer","de Març","d'Abril","de Maig","de Juny","de Juliol", "d'Agost","de Setembre","d'Octubre","de Novembre", "de Desembre"];
// NO MODIFICAR RES A PARTIR D'AQUEST PUNT *************************************************
// Comprova si n és un valor numéric.
function isInt(n) {
	if (!((n >= "0") && (n <= "9")))
		return false
	else
		return true;
}
// quindiaes(nom_input_dia,nom_input_mes,nom_input_any,nom_input_on_imprimim_resultat)
function quindiaes(dd,mm,aa,ii){
	dia = document.getElementById(dd).value;
	mes = document.getElementById(mm).value;
	any = document.getElementById(aa).value;
	if(!isInt(dia)) {document.getElementById(ii).value ="";return;}
	if(!isInt(mes)) {document.getElementById(ii).value ="";return;}
	if(!isInt(any)) {document.getElementById(ii).value ="";return;}
	var d = new Date();
	d.setDate(dia);
	d.setMonth(mes - 1);
	d.setFullYear(any);
	document.getElementById(ii).value = Setmana[d.getDay()]+", "+dia+" "+Mesos[mes-1]+ " de "+any;
	

}
////////////////////////////////////////
  document.getElementById("desbloq").style.display = "none";
  document.getElementById("bloq").style.display = "none";



</SCRIPT>
</p>
<p>&nbsp; </p>
</CENTER>
</BODY>
</HTML>