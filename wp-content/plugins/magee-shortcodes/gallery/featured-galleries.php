<?php

require_once('components/enqueuing.php' );
require_once('components/metabox.php' );
require_once('components/ajax-update.php' );
require_once('components/readmethods.php' );

add_action( 'add_meta_boxes', 'magee_register_metabox' );
add_action( 'save_post', 'magee_save_perm_metadata', 1, 2 );
add_action( 'admin_enqueue_scripts', 'magee_enqueue_stuff' );
add_action( 'wp_ajax_magee_update_temp', 'magee_update_temp' );