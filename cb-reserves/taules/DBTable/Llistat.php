<?php
//$EDITABLE = "true";

if (!defined('ROOT')) define('ROOT', "../");
require_once("DBTable.php");

$gestor=new DBTable($query);
if (!$gestor->valida_sessio(64)) header("Location: ".ROOT."../panel/");
$gestor->peticionsAJAX($TABLE);
$res = $gestor->query($FILTRE);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html>

	<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />
		<meta http-equiv="Content-Type"  content="text/html; charset=utf-8" />
	<?php 
		include("DBTableHead.php");
		if (file_exists("DBTHead.php")) include("DBTHead.php");
		?>
	</head>
	<body>
		<h2>ADMINISTRACIÓ DE <?php echo $TABLE;?></h2>
		<?php //include("DBTableFiltres.php");?>
        <header>
            
        </header>
		<div id="popup_cercador" style="display:none">



<?php 
	$row=mysqli_fetch_assoc($res);
	if($row) 
	{
	?>	
		
		
			<table id="grid">
				<thead>
					<tr>
			<?php
				foreach($row as $k => $v)
					echo "<th>".(substr($k,0,7)=="ui_icon"?'':$k)."</th>";
			?>
					</tr>				
				</thead>
				<tbody>
			<?php
			while ($row)
			{	
				$idr=$row['idR'];
		
			?>
					<tr style="<?php echo (!empty($dbdel)?"background:#fee;":""); ?>" class="ffila">
			<?php
                        $n=0;
				foreach($row as $k => $v) 
				{
                                    
                                        $bool=($v=='true' || $v=='false')?' bool ':' no-bool ';
					echo '<td id="'.$k.'__'.$idr.'" col="'.$k.'" tipus="'.substr($k,0,4).'" class="'.$row[$k].$bool.'" idR="'.$idr.'">';	
					
					echo $gestor->controlsTaula($row,$k);

					echo "</td>";
                                        $n++;
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
		<div id="popup" title="Informació"></div>
		<div id="edit" title="Edició de registre"></div>
		
	<body>
<html>