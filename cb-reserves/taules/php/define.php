<?php
define('SOL',"\n"); 
define('EOL',"\r\n");
define('TAB',"\t");
define('BR',"<br/>");
define('BYTES_x_KB', 1024);
define('BYTES_x_MB', 1048576);
define('S1'," *** "); 
define('S2', " --- "); 

$ips['87.111.255.201']="ALEX_MANRESA";

//define('BACKUP_INTERVAL',60000*30');

function mysqli_result($result, $row, $field = 0) {
    // Adjust the result pointer to that specific row
    $result->data_seek($row);
    // Fetch result array
    $data = $result->fetch_array();
 
    return $data[$field];
}


spl_autoload_register(function ($class_name) {
    
  $ruta=defined('ROOT')?ROOT:"../";
  
    include $ruta.$class_name . '.php';
});


?>