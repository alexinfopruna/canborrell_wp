<?php
if ( ! defined( 'ABSPATH' ) ) { 
	exit; 
}

function unconsent_analytics_patterns($patterns){
	// https://support.count.ly/hc/en-us/articles/360037441932-Web-analytics-JavaScript-
	$patterns[] = 'countly.js';
	$patterns[] = 'countly.min.js';
	// https://developers.google.com/analytics/devguides/collection/analyticsjs
    $patterns[] = 'google-analytics.com/ga.js';
    $patterns[] = 'www.google-analytics.com/analytics.js';
    $patterns[] = '_getTracker';
    $patterns[] = 'apis.google.com/js/platform.js';
    $patterns[] = 'maps.googleapis.com';
    $patterns[] = 'google.com/recaptcha';    
    $patterns[] = 'googletagmanager.com';
    $patterns[] = "gtag('config'";    
    $patterns[] = "googletagmanager.com/gtag/";
    // https://developers.facebook.com/docs/mediaguide/pixel-and-analytics/
    $patterns[] = 'connect.facebook.net';
    
    return $patterns;
}
add_filter('argpd_unconsent_patterns', 'unconsent_analytics_patterns');
