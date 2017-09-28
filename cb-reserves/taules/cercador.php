<?php
if (!defined('ROOT')) define('ROOT', "");
//include(ROOT."Gestor.php");
include(ROOT."GestorCercador.php");

$gestor=new GestorCercador();

//$dbdel="canborrell_del.";

$tot1=($_REQUEST['data1']=="01/01/2011" || $_REQUEST['data1']=="01-01-2011" || $_REQUEST['data1']=="*");
$tot2 = ($_REQUEST['data2'] == "31/12/2050" || $_REQUEST['data2'] == "31-12-2050" || $_REQUEST['data2'] == "*");


$data1 = $data2 = $_REQUEST['data1'];
if (isset($_REQUEST['data2'])) $data2=$_REQUEST['data2'];


$d1=$gestor->cambiaf_a_mysql($data1);
$d2=$gestor->cambiaf_a_mysql($data2);

$torn1=$_REQUEST['torn1']?1:0;
$torn2=$_REQUEST['torn2']?2:0;
$torn3=$_REQUEST['torn3']?3:0;
$del=$dbdel=$_REQUEST['del']?"canborrell_del.":"";
// %d/%m/%Y
		$query = "SELECT id_reserva AS idR , DATE_FORMAT(data,'%Y/%m/%d') AS data,hora,estat_taula_torn AS T,adults,nens10_14 AS nens,nens4_9 as jun ,cotxets AS cotx,CONCAT(client_cognoms,', ',client_nom) AS nom,client_mobil,  estat_taula_nom AS taula, IF(reserva_info & 1,'online','') AS online, '' AS controls_taula FROM ".$dbdel.T_RESERVES." 
		LEFT JOIN client ON ".$dbdel.T_RESERVES.".client_id=client.client_id
		INNER JOIN ".$dbdel.ESTAT_TAULES." ON ".$dbdel.T_RESERVES.".id_reserva = ".$dbdel.ESTAT_TAULES.".reserva_id
		WHERE data >= '$d1'  AND data <= '$d2'
		AND (estat_taula_torn=$torn1 || estat_taula_torn=$torn2 || estat_taula_torn=$torn3)
		";
		

if (isset($_REQUEST['sql'])) $query=$_REQUEST['sql'];

//echo $query;
$res=mysqli_query($GLOBALS["___mysqli_ston"], $query); 
if (!$gestor->valida_sessio(1))  die("Sense permisos. Logat primer al panel!");
$nr=mysqli_num_rows($res);
$row=mysqli_fetch_assoc($res);
$columnes = count($row);



function controlsTaula($fila)
{
  $fila['del_id']=isset($fila['del_id'])?  $fila['del_id']:"";

  
	$columnes = count($fila);
	$botons = '<a href="'.$_SERVER['PHP_SELF'].'?d='.$fila['del_id'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
	$botons .= '<a href="eee"><span class="ui-icon ui-icon-trash"></span></a>';
	//$botons = 555;
	
	return $botons;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		
		<title>Cercador Reserves</title>
<!--	--><link type="text/css" href="css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
<link type="text/css" href="css/taules.css" rel="stylesheet" />	


		<style type="text/css">
		  @import "js/DataTables/media/css/demo_page.css";
		  @import "js/DataTables/media/css/demo_table.css";
		 /* td{min-width:100px;}*/
		 .ui-button{padding:0 4px;}
		 html, body{width:880px}
		 table{width:100%;}
		 thead{font-weigth:bold}
		 .ffila:hover{backgroung:red}
			.ui-icon{float:left;}
		</style>
		<script type="text/javascript" language="javascript" src="js/DataTables/media/js/jquery.js"></script>
		<script class="jsbin" src="js/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="js/ui/js/jquery-ui-1.8.9.custom.min.js"></script>
			
		<script>
			<?php
				echo "var DATA1='$data1';";
				echo "var DATA2='$data2';";
				echo "var TORNS1=$torn1;";
				echo "var TORNS2=$torn2;";
				echo "var TORNS3=$torn3;";
				echo "var DEL=".($del?1:0).';';
			?>
		
			$(function(){			
				$("#grid").dataTable({
					"bJQueryUI": true,					
					"bStateSave": true,
					"fnDrawCallback":addTableListeners,
					"sPaginationType": "full_numbers"
				});
				
/*		*/			

				$( "#end" ).button({
					text: false,
					icons: {
						primary: "ui-icon-seek-end"
					}
				});
				
				$( "#cerca_calendari1" ).datepicker().change(function(){DATA1=$(this).val();cercadorRefresh();});				
				$( "#cerca_calendari2" ).datepicker().change(function(){DATA2=$(this).val();cercadorRefresh();});									
				
				$( "#tot1" ).button().click(function(){
					if ($(this).is(":checked"))	DATA1="01/01/2011";
					else DATA1=$.datepicker.formatDate('dd/mm/yy', new Date());
					
					$("#cerca_calendari1").val(DATA1);
					cercadorRefresh();				
				});			
				$( "#tot2" ).button().click(function(){					
					if ($(this).is(":checked"))	DATA2="31/12/2050";
					else DATA2=$.datepicker.formatDate('dd/mm/yy', new Date());
					$("#cerca_calendari2").val(DATA2);
					cercadorRefresh();
				
				});			

				$( "#cerca_torn1" ).button().click(function(){TORNS1=$(this).is(":checked")?1:0;cercadorRefresh();});			
				$( "#cerca_torn2" ).button().click(function(){TORNS2=$(this).is(":checked")?1:0;cercadorRefresh();});
				$( "#cerca_torn3" ).button().click(function(){TORNS3=$(this).is(":checked")?1:0;cercadorRefresh();});
				$( "#cerca_esborrades" ).button().click(function(){DEL=$(this).is(":checked")?1:0;cercadorRefresh();});
				$( "#cerca_actives" ).button().click(function(){});
				
				
				
				addTableListeners();
				
				//$("#grid").change(function(){alert("rrrr");});
		

				$("#popup_cercador").show("fade");
			});
			
			function addTableListeners()
			{
				$(".ffila td[col=idR]").each(function(){$(this).html('<a href="#">'+$(this).html()+'</a>')});;
				$("#grid td[col=idR]").click(function(e){	
					var torn=$(this).attr("torn");
					var data=$(this).attr("data");
                                        var dat=$.datepicker.parseDate( "yy/mm/dd", data );
                                        data=$.datepicker.formatDate('dd/mm/yy', dat);
					var id=$(this).attr("id");
					e.preventDefault();
					window.opener.FROM_CERCADOR_obreDetallReserva(id,data,torn);
					return false;
					window.close();
				});
			}
			
			
			function cercadorRefresh()
			{
				window.location.href="cercador.php?data1="+DATA1+"&data2="+DATA2+"&torn1="+TORNS1+"&torn2="+TORNS2+"&torn3="+TORNS3+"&del="+DEL+"&act="+0
			}
		</script>
	</head>
	<body>
		<div id="popup_cercador" style="display:none">
<div class="demo">
<!--
	<span id="repeat">
		<input type="radio" id="repeat0" name="repeat" checked="checked" /><label for="repeat0">1</label>
		<input type="radio" id="repeat1" name="repeat" /><label for="repeat1">2</label>
		<input type="radio" id="repeatall" name="repeat" /><label for="repeatall">3</label>
	</span>
-->
	<table>
		<tr>
			<td>
				Des de: <input type="text" id="cerca_calendari1" name="data1" value="<?php echo $gestor->cambiaf_a_normal($data1) ?>"	style="width:70px; <?php echo $tot1?'display:none;':""?> "/>
				<input type="checkbox" id="tot1"  <?php echo $tot1?'checked="checked"':""?> /><label for="tot1">Tot</label>				
			</td>
			<td> 
			-
			</td>
				<td>
				Fins a: <input type="text" id="cerca_calendari2" name="data2" value="<?php echo $gestor->cambiaf_a_normal($data2) ?>" style="width:70px;<?php echo $tot2?'display:none;':""?>" />
				<input type="checkbox" id="tot2"  <?php echo $tot2?'checked="checked"':""?> /><label for="tot2">Tot</label>
			</td>
			<td style="width:60px;">
			
			</td>
			<td>
				<input type="checkbox" id="cerca_torn1"  <?php echo $torn1?'checked="checked"':""?> /><label for="cerca_torn1">Torn1</label>
				<input type="checkbox" id="cerca_torn2" <?php echo $torn2?'checked="checked"':""?> /><label for="cerca_torn2">Torn2</label>
				<input type="checkbox" id="cerca_torn3" <?php echo $torn3?'checked="checked"':""?> /><label for="cerca_torn3">Sopar</label>
			</td>
			<td>
				<input type="checkbox" id="cerca_esborrades" <?php echo $del?'checked="checked"':""?> /><label for="cerca_esborrades">Esborrades</label>
			</td>
		</tr>
	</table>

	<script type="text/javascript" src="js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
	
	
	
	
	
	
<?php if($nr) {?>	

</div><!-- End demo -->
		
		
			<table id="grid">
				<thead>
					<tr>
			<?php
				foreach($row as $k => $v)
					echo "<th>$k</th>";
			?>
					</tr>				
				</thead>
				<tbody>
			<?php
			while ($row)
			{	
				if (isset($row['controls_taula'])) $row['controls_taula']=controlsTaula($row);

			
			?>
					<tr style="<?php echo (!empty($dbdel)?"background:#fee;":""); ?>" class="ffila">
			<?php
				foreach($row as $k => $v) 
				{
					echo '<td col="'.$k.'" id="'.$row["idR"].'" data="'.$row["data"].'" hora="'.$row["hora"].'" torn="'.$row["T"].'" >';
					echo Gestor::upperNoTilde($v);
					echo "</td>";
				}
			?>
					</tr>
			<?php
				$row=mysqli_fetch_assoc($res);
			}
			?>
				</tbody>
			</table>
		</div>
<?php } else {echo '<p style="color:red">SENSE DADES</p>';}// if ($nr)	?> 			
		<form method="post" class="amagat">
			<textarea name="sql" style="margin-top:200px;width:100%;height:300px;">
				<?php echo $query; ?>
			</textarea>
			<input type="submit"/>
		</form>
		
	<body>
<html>





