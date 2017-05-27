		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		
		<title>Cercador Reserves</title>
		<link type="text/css" href="../css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
		<link type="text/css" href="../css/taules.css" rel="stylesheet" />	
		<link type="text/css" href="css/DBTable.css" rel="stylesheet" />	
		
		<!----------------------------------------------------------------------------->
		<!---- VARIABLES 														------->
		<script>
		<?php 
			if (!isset($_REQUEST['idR'])) $_REQUEST['idR']=0;
		?>
			var TABLE="<?php echo $TABLE;?>";
			var IDR=<?php echo $_REQUEST['idR']?$_REQUEST['idR']:0;?>;
			var EDITABLE=<?php echo $EDITABLE?$EDITABLE:"false"?>;	
		</script>		
		<!----------------------------------------------------------------------------->
                
               <?php echo Gestor::loadJQuery("2.0.3"); ?>
                 
		<script class="jsbin" src="../js/DataTables/media/js/jquery.dataTables.min.js"></script>
		
		<!----------------------------------------------------------------------------->
		<!---- EDIT FORM 														------->
		<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>		
		<script type="text/javascript" src="../js/jquery.metadata.js"></script>		
		<script type="text/javascript" src="../js/jquery.form.js"></script>		
		<script type="text/javascript" src="../js/jquery.bestupper.min.js"></script>		
		<!----------------------------------------------------------------------------->
		
		
		
		<script type="text/javascript" src="../js/multiLang.js"></script>			
		<script type="text/javascript" src="js/DBTable.js"></script>			
		<!--<script type="text/javascript" src="js/uitableedit/jquery.uitableedit.js"></script>	-->	
		<script type="text/javascript" src="js/jquery.editinplace.js"></script>	
		
