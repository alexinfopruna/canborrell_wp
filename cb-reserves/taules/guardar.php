<?php 
$filename = 'print.png';
$somecontent = base64_decode($_REQUEST['imagen']);
    if ($handle = fopen("print/".$filename, 'w+'))
    if (!fwrite($handle, $somecontent) ===FALSE) fclose($handle);
    echo "print/".$filename;
?>