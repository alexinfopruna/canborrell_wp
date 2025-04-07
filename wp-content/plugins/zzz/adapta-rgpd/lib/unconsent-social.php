<?php
if ( ! defined( 'ABSPATH' ) ) { 
	exit; 
}

function unconsent_social_patterns($patterns){    
    // linkedin
    $patterns[] = 'platform.linkedin.com/in.js';
    // twitter
    $patterns[] = 'twitter-widgets.js';
    // youtube
    $patterns[] = 'www.youtube.com/iframe_api';
    // instagram
    $patterns[] = 'instagram.com/embed.js';
    // https://help.disqus.com/en/articles/1717112-universal-embed-code
    $patterns[] = 'disqus.com/embed.js';    
    return $patterns;
}
add_filter('argpd_unconsent_patterns', 'unconsent_social_patterns');
