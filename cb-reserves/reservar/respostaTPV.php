<?php
$f=fopen('log_resposta_falsa.txt','a');
fwrite($f,"RESPOSTA FALSE ... ");
fwrite($f,date('d-m-y H:i:s'));
fclose($f);
?>