<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$translation_array = array(
  'exterior' => __( 'Outdoor','WordPress'),
  'interior' => __( 'Indoor','WordPress' ),
  'cuina' => __( 'Kitchen','WordPress' ),
  'graella' => __( 'Grill','WordPress' ),
  'equip' => __( 'Team','WordPress' ),
  'plats' => __( 'Dishes','WordPress')
);
//

// TIPUS
require_once('tipus/premsa-functions.php'); // Testimonial Post Type
require_once('tipus/menus-functions.php'); // Testimonial Post Type
// require_once('tipus/menusz-functions.php'); // Testimonial Post Type


add_filter( 'the_content', 'filter_the_content_in_the_main_loop' );
 
function filter_the_content_in_the_main_loop( $content ) {
 
 if (isset($_REQUEST['gallery']) && isset($_REQUEST['title'])) {
   $galeria = bwg_shortcode(array('id' => $_REQUEST['gallery']));
   $title = $_REQUEST['title'];
   $content =  '<h1>'.$title.'</h1><div class="well cb-ajax-gallery">'.$galeria.'</div>'.$content;
   
   $contentxxx = '<div class="panel panel-default">
  <div class="panel-heading">'.$title.'</div>
  <div class="panel-body"><div class=" cb-ajax-gallery">'.$galeria.'</div></div>
</div>'.$content;
   
  // $content .= $galeria;
   
 }
 
 
 
    return $content;
}


function canborrell_enqueue_styles() {
  global $translation_array;

  $parent_style = 'parent-style';

  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style)  );
  wp_enqueue_script( 'galeria', get_stylesheet_directory_uri() .'/js/galeria.js', array('jquery'), '1.0', true );
  //print_r($translation_array);die();
wp_localize_script( 'galeria', 'gallery_texts', $translation_array );

capsaleres_geleria();
  //cho get_stylesheet_directory_uri() .'/js/galeria.js';die();
}
add_action('wp_enqueue_scripts', 'canborrell_enqueue_styles');




add_action( 'wp_ajax_nopriv_ajax_galeria', 'my_ajax_galeria' );
add_action( 'wp_ajax_ajax_galeria', 'my_ajax_galeria' );


function capsaleres_geleria(){
  global $translation_array;
  
  
  echo '<style id="puf">';
  
  echo '
    .col-md-4:nth-child(1) i.fa.fa-link:after{
	content: " '.$translation_array['exterior'].'";
}
 .col-md-4:nth-child(2) i.fa.fa-link:after{
	content: " '.$translation_array['interior'].'";
}
 .col-md-4:nth-child(3) i.fa.fa-link:after{
	content: " '.$translation_array['cuina'].'";
}
#gallery .row:nth-child(4)  .col-md-4:nth-child(1) i.fa.fa-link:after{
	content: " '.$translation_array['graella'].'";
}
#gallery  .row:nth-child(4) .col-md-4:nth-child(2) i.fa.fa-link:after{
	content: " '.$translation_array['equip'].'";
}
#gallery  .row:nth-child(4) .col-md-4:nth-child(3) i.fa.fa-link:after{
	content: " '.$translation_array['plats'].'";
}';
  
  echo '</style>';
}



function my_ajax_galeria() {
    echo "EOEEEEEOEOEO";
    die();
}



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
  return constant($name);
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



function language_selector_flags(){
  $langs="";  
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0&orderby=code&order=desc');           
        echo '<div class="lang_selector">';
            if(!empty($languages)){
                foreach($languages as $l){
                    $class = $l['active'] ? ' class="active"' : NULL;
                    $langs .=  '<a ' . $class . ' href="'.$l['url'].'">' . strtolower ($l['language_code']). '</a> | ';
                }
                $langs = substr($langs,0,-3);
                echo $langs;
            }
        echo '</div>';
    }
}



function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'header_widget_1',
		'id'            => 'header_widget_1',
		'before_widget' => '<div class="header_widget_1">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );
