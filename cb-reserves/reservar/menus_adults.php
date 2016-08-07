<?php if(!isset($carta)){
	if (!defined('ROOT')) define('ROOT', "../taules/");

	require_once(ROOT . "Carta.php");
	$carta=new Carta();
}

?>
<?php l('Menú per a adults');?>					
<h3><a href="#" v="0"><?php l("titol_menu_2001");?></a></h3>
<div>
<?php echo $carta->parsePreus(2001);//l("menu_2001");?>
</div>


<h3><a href="#" v="1"><?php l("titol_menu_2024");?></a></h3>
<div>
<?php echo $carta->parsePreus(2024);//l("menu_2024");?>
</div>


<h3><a href="#" v="2"><?php l("titol_menu_2003");?></a></h3>
<div>
<?php echo $carta->parsePreus(2003);//l("menu_2003");?>
</div>


<h3><a href="#" v="3"><?php l("titol_menu_2023");?></a></h3>
<div>
<?php echo $carta->parsePreus(2023);//l("menu_2023");?>
</div>


<h3><a href="#" v="4"><?php l("titol_menu_2012");?></a></h3>
<div>
<?php echo $carta->parsePreus(2012);//l("menu_2012");?>
</div>


<h3><a href="#" v="9"><?php l("titol_menu_2007");?></a></h3>
<div>
<?php echo $carta->parsePreus(2007);//l("menu_2007");?>
</div>

<?php if (calsoton===true){ ?>
<h3><a href="#" v="5"><?php l("titol_menu_2010");?></a></h3>
<div>
<?php echo $carta->parsePreus(2010)//l("menu_2010");?>
</div>
<?php } ?>


<h3><a href="#" v="6"><?php l("titol_menu_2013");?></a></h3>
<div>
<?php echo $carta->parsePreus(2013);//l("menu_2013");?>
</div>


<h3><a href="#" v="7"><?php l("titol_menu_2016");?></a></h3>
<div>
<?php echo $carta->parsePreus(2016);//l("menu_2016");?>
</div>