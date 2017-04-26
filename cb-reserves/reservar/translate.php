<?php 
/*********************************************/
if (!defined('TRANSLATE_DEBUG')) define('TRANSLATE_DEBUG', FALSE);
/*********************************************/

$ruta_lang="../$lang/";
if (TRANSLATE_DEBUG) //ESTILS
{
	define('TRANSLATE_NO_TRANS','!*!');
	echo "<style>
			.no-trans{background-color:red;color:white;}
			.translated{color:LawnGreen ;}
			.js-no-trans{background-color:Magenta;color:white;}
			.js-no-trans{background-color:Magenta;color:white;}
			.js-translated{color:Magenta ;}
		</style>";
}
else define('TRANSLATE_NO_TRANS','');
?><script type="text/javascript">
var translateKey=new Array("test translate: ERROR");
//var translateJS=new Array("<span class=\'js-translated\'>Test translate: OK</span>");
var translateJS=new Array("<span class=\'js-translated\'>Test translate: OK</span>");
var TRANSLATE_DEBUG=false;//<?php echo TRANSLATE_DEBUG?"true":"false";?>;
var lang="<?php echo $lang;?>";


if (TRANSLATE_DEBUG) 
{
		document.write("TRADUCTOR: "+lang);//TEST TRAnslate
		document.write(l("test translate: ERROR")+"  *** "+l("Aquest text no té traducció"));//TEST TRAnslate
		
		alert("TRADUCTOR DEBUG: "+lang);
}
<?php  
	//TRANSLATES
if (!isset($translateJS)) $translateJS=array();
if (!isset($translateDirectJS)) $translateDirectJS=array();
	foreach($translateJS as $k=>$v) 
	{
		echo "translateKey.push('".$k."');\n";
		//echo "translateJS.push('".htmlentities($v)."');\n";
		echo "translateJS.push('".$v."');\n";
	}
	
	foreach($translateDirectJS as $k=>$v) 
	{
		echo "translateKey.push('".$k."');\n";
		echo "translateJS.push('".$v."');\n";
	}
?>

function l(t)
{
	var i=translateKey.indexOf(t);
	
	if (TRANSLATE_DEBUG)//DEBUG
	{
	  if (i>=0) return '<span class="js-translated">'+"..TRANS.."+translateJS[i]+"</span>";
	  else return '<span class="js-no-trans">'+"..NO-TRANS.."+t+"</span>";

	}
	else
	{
		if (i>=0) return translateJS[i];
		else return t;
	}
}

</script>

<?php
/****************************************************************************************************/	
/*************************************************     FUNCIONS   ***********************************/	
/****************************************************************************************************/	
//LX ********* global $translate;
function l($text,$echo=true)
{
	global $translate;
	global $notrans;
	if (TRANSLATE_DEBUG)
	{
		/*
		// DEBUG
		*/
		if (isset($translate[$text])) 
			if ($translate[$text]=="=")	$trans='<span class=\'igual\'>'.$text.'</span>';
			else $trans='<span class=\'translated\'>'.$translate[$text].'</span>';
		else $trans=TRANSLATE_NO_TRANS.'<span class=\'no-trans\'>'.$text.'</span>';
	}
	else
	{
		if (isset($translate[$text])) 
		{
			if ($translate[$text]=="=")	$trans=$text;
			else $trans=$translate[$text];
		}
		else $trans=$text;
	}
	//echo "---$text - ".(isset($translate[$text])?"ok":"ko")." > ";
	if ($echo) echo $trans;
	
	return ($trans);
}

function lv($text){
  return l($text, FALSE);
}