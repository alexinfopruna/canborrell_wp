<?php

include 'vendor/autoload.php';

$ve = new hbattat\VerifyEmail('alex.maildosxx@gmail.com', 'alexinfopruna@gmail.com');

var_dump($ve->verify());

echo '<pre>';print_r($ve->get_debug());
