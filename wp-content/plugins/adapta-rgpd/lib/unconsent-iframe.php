<?php
if ( ! defined( 'ABSPATH' ) ) { 
	exit; 
}

function unconsent_iframe_patterns($patterns){    
    $patterns[] = 'youtube';
    return $patterns;
}
add_filter('argpd_unconsent_iframe_patterns', 'unconsent_iframe_patterns');

