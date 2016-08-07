<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// TIPUS
require_once('tipus/premsa-functions.php'); // Testimonial Post Type
require_once('tipus/menus-functions.php'); // Testimonial Post Type
// require_once('tipus/menusz-functions.php'); // Testimonial Post Type

function canborrell_enqueue_styles() {

  $parent_style = 'parent-style';

  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style)
  );
}

add_action('wp_enqueue_scripts', 'canborrell_enqueue_styles');


function isard_after_setup_theme() {
  add_filter('body_class', 'add_archive_class');
}
