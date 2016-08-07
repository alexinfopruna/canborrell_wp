/*****************************************************************/
/*****************************************************************/
// alex garcia 2012
//
// carrega via ajax el menu de navegació
/*****************************************************************/
/*****************************************************************/
window.onload=loadMenu;
loadMenu();
var fet=false;
	var xmlhttp;

function loadMenu()
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	  
	xmlhttp.onreadystatechange=function ()
  {
 //if (fet) return;
	var t=document.getElementsByTagName("table")[0];
	if (!t) return;
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		t=t.getElementsByTagName("table")[0];
		var div= document.createElement("div");
		div.innerHTML=xmlhttp.responseText;
		var parent = t.parentNode || t.parent;
		parent.replaceChild(div, t);
		t.setAttribute("HEIGHT","19");
		fet=true;
	}
  }

	xmlhttp.open("GET","../menu.php?url="+window.location.href,true);
	xmlhttp.send();
}