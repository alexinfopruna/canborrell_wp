<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
if (!defined('DB_CONNECTION_FILE')) define('DB_CONNECTION_FILE', "../Connections/DBConnection.php");

require_once(ROOT."Gestor.php");
require(ROOT."../Connections/".DB_CONNECTION_FILE);
if (Gestor::user_perm()<127) {header("Location: ../taules/taules.php");die();}

?>
<html>
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<title>
Info sistema
</title>
    
    
<style>
	h1{text-align:center;}
	table{width:600px;background:#eef;border-collapse:collapse;}
	td{padding:3px;border:#666 1px dotted}
	
	tr td{background:#CCC;}
	tr td:first-child{background:#CCF;width:70px;font-weight:bold;}
	.hightligh{background:#fdd !important;}
</style>
</head>
<body>
    <a href="http://cbwp-localhost/cb-reserves/panel/infoConn.php">http://cbwp-localhost/cb-reserves/panel/infoConn.php</a>
        <p>
      
            <?php
$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$externalIp = $m[1];
echo "EXTERNAL IP: ".$externalIp;
?>
            
    </p>
<?php
echo '<table id="info" style="margin:auto auto;">';
echo '<tr><td><h1>SISTEMA DE RESERVES</h1></td></tr>';
echo '</table>';
echo '<br/>';
echo '<table id="info" style="margin:auto auto;">';
echo '<tr><td>HOST</td><td class="dada">'.$_SERVER['HTTP_HOST'].'</td></tr>';
echo '<tr><td>DB_HOST</td><td class="dada">'.$hostname_canborrell.'</td></tr>';
echo '<tr ><td><b>Database</b></td><td class="hightligh"><b>'.$database_canborrell.'</b></td></tr>';
echo '<tr><td>DB_CONNECTION_FILE</td><td class="dada">'.DB_CONNECTION_FILE.'</td></tr>';
echo '<tr><td>INC_FILE_PATH</td><td class="dada">'.INC_FILE_PATH.'</td></tr>';
echo '</table>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';

ob_start();
phpinfo();
$variable = ob_get_contents();
ob_get_clean();

if (isset($_GET['mail'])){
  require(ROOT."/gestor_reserves.php");
  $g = new gestor_reserves();
      require_once(ROOT."../editar/mailer.php");

  echo ">> Enviem mail...";
  $er=mailer("alexinfopruna@gmail.com","Test mail - infoConn",$_GET['mail'].$variable);
  var_dump($er);
}
//phpinfo();

echo $variable;
?>
</body>
</html>