<?php

function magee_enqueue_stuff() {

	wp_enqueue_media();

	wp_enqueue_script( 'magee-admin-script',  MAGEE_SHORTCODES_URL.'gallery/js/admin.js' );

	wp_localize_script( 'magee-admin-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	wp_enqueue_style( 'magee-admin-style', MAGEE_SHORTCODES_URL.'gallery/css/admin.css' );

}