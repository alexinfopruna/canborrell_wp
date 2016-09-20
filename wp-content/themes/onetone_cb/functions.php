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



//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );




/*
  function isard_after_setup_theme() {
  add_filter('body_class', 'add_archive_class');
  }
 */

function cb_preu_plat_func($atts) {
  require_once(ROOT . "Carta.php");
  $carta = new Carta();

  $id = $atts['id'];
  return '<span class="preu">' . $carta->preuPlat($id) . '</span>';
}
function cb_constant_func($atts) {
  $name = $atts['name'];
  
  //return "DDDDD";
  return '<span class="preu">' . constant($name) . '</span>';
}

add_shortcode('cb_preu_plat', 'cb_preu_plat_func');
add_shortcode('cb_constant', 'cb_constant_func');


/**** MENU ACTIVE ****/
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
   global $post;
   
    if (is_object($post)) {
      $post_slug=$post->post_name;
      $post_meta = get_post_meta( $post->ID);
    }
    
    $current_rel_uri = add_query_arg( NULL, NULL );
    /*   
    echo $post_slug;
    echo '<br>';
    echo '<br>';
    echo '<br>';
   
    //echo '<br>';echo '<br>';echo '<br>';
    //var_dump($post_meta );
    die();
  */
   
    
    if (isset($post_meta ["_wp_page_template"]) && $post_meta ["_wp_page_template"][0] == 'page_historia_template.php' && $item->title == "Història"){
       $classes[] = "current";
    }
    if (isset($post_meta ["_wp_page_template"]) && $post_meta ["_wp_page_template"][0] == 'page_excursions_template.php' && $item->title == "Excursions"){
       $classes[] = "current";
    }
    if (isset($post->post_type) && $post->post_type == 'menus' && $item->title == "Carta-Menu"){
       $classes[] = "current";
    }
    if (isset($post_slug) && $post_slug == 'premsa' && $item->title == "Premsa"){
       $classes[] = "current";
    }
  
    if (isset($post_slug) && $post_slug == 'horari-general-de-cuina' && $item->title == "Horaris"){
       $classes[] = "current";
    }
    
    if (substr($current_rel_uri, 0,9) == '/reservar'  && $item->title == "Reservar"){
      $classes[] = "current";
    }
  /*
     if(is_single() && $item->title == "Blog"){ //Notice you can change the conditional from is_single() and $item->title
             $classes[] = "special-class";
     }*/
     return $classes;
}