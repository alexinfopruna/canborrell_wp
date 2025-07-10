<?php
return $config_tpv = array(
    'Environment' => $url=='https://sis-t.redsys.es:25443/sis/realizarPago'?"test":"real", // Puedes indicar test o real
    'MerchantCode' => $fuc,
    'Key' => $clave256,
    'Terminal' => $terminal,
    'TransactionType' => $trans,
    'Currency' => $moneda,
    'MerchantName' => $merchantName ,
    'Titular' => $merchantName ,
    'ConsumerLanguage' => '001',
    'SignatureVersion' => $version
);


    // 'Keytest' => 'sq7HjrUOBfKmC576ILgskD5srU870gJ7',
    // 'Keyvvv' => 'L+85E7+Jlj+Jf4QaMyqaWBb58iRRWb8',
    // 'Keyzzz' => 'sq7HjrUOBfKmC576ILgskD5srU870gJ7',




