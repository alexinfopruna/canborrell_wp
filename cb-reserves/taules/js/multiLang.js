var TRANSLATE_DEBUG=false;
var translateKey=new Array("test");
var translateJS=new Array("Test translata OK");


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