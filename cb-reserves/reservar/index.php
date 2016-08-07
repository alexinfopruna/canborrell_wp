<?php 
header("Location: form.php");
exit();
$RedirectLoginSuccess="form.php";
$ruta_lang="../taules/";
define("ROOT", "../taules/");

if (!isset($_SESSION)) session_start();
$_SESSION['config']="config.xml";

require_once($ruta_lang."gestor_reserves.php");

$gestor=new gestor_reserves();
if ($gestor->valida_login()) header("Location: ". $RedirectLoginSuccess );

$estil="winterblues.css";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" /> ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login Form Reserves Online</title>

<link href="../taules/css/admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $ruta_lang."css/$estil" ?>" rel="stylesheet" type="text/css" />
</head>

<body>
  <h1>Login Form Reserves Online</h1>
  <form id="flogin" name="form1" method="POST" action="<?php echo $loginFormAction;  ?>">
    <table width="0" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr height="50px">
      <td class="etinput" ><div align="right">Usuari</div></td>
      <td width="7">&nbsp;</td>
      <td><input type="text" name="usr" /></td>
    </tr>
    <tr>
      <td class="etinput"><div align="right">Contrassenya</div></td>
      <td width="7">&nbsp;</td>
      <td>
	  <input type="password" name="pass" /></td>
    </tr>
  </table>
  <br/><br/><input type="submit" name="Submit" value="Entrar" /><br/><br/>
</form>
</body>
</html>