<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$translation_array = array(
  'exterior' => __('Outdoor', 'WordPress'),
  'interior' => __('Indoor', 'WordPress'),
  'cuina' => __('Kitchen', 'WordPress'),
  'graella' => __('Grill', 'WordPress'),
  'equip' => __('Team', 'WordPress'),
  'plats' => __('Dishes', 'WordPress')
);
//
// TIPUS
require_once('tipus/premsa-functions.php'); // Testimonial Post Type
require_once('tipus/menus-functions.php'); // Testimonial Post Type
// require_once('tipus/menusz-functions.php'); // Testimonial Post Type

/*
add_action( 'init', 'process_post' );

function process_post() {
     echo "OOO";die();
}
*/

add_filter('icl_set_current_language', 'my_icl_set_current_language');

function my_icl_set_current_language($lang) {

  die();
  $lang = 'nl';
  return $lang;
}

add_filter('the_content', 'filter_the_content_in_the_main_loop');

function filter_the_content_in_the_main_loop($content) {

  if (isset($_REQUEST['gallery']) && isset($_REQUEST['title'])) {
    $galeria = bwg_shortcode(array('id' => $_REQUEST['gallery']));
    $title = $_REQUEST['title'];
    $content = '<h1>' . $title . '</h1><div class="well cb-ajax-gallery">' . $galeria . '</div>' . $content;

    $contentxxx = '<div class="panel panel-default">
  <div class="panel-heading">' . $title . '</div>
  <div class="panel-body"><div class=" cb-ajax-gallery">' . $galeria . '</div></div>
</div>' . $content;

    // $content .= $galeria;
  }



  return $content;
}

function canborrell_enqueue_styles() {
  global $translation_array;

  $parent_style = 'parent-style';

  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  // wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style)  );
  wp_enqueue_script('galeria', get_stylesheet_directory_uri() . '/js/galeria.js', array('jquery'), '1.0', true);
  //print_r($translation_array);die();
  wp_localize_script('galeria', 'gallery_texts', $translation_array);

  capsaleres_geleria();
  //cho get_stylesheet_directory_uri() .'/js/galeria.js';die();
 
  //echo is_page('carta-alergogens'); echo the_slug();die();
   //   global $post;
   // $post_slug=$post->post_name;echo $post_slug;
  // die();
   wp_enqueue_script('alergogens', get_stylesheet_directory_uri() . '/js/alergogens.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'canborrell_enqueue_styles');




add_action('wp_ajax_nopriv_ajax_galeria', 'my_ajax_galeria');
add_action('wp_ajax_ajax_galeria', 'my_ajax_galeria');

function capsaleres_geleria() {
  global $translation_array;


  echo '<style id="puf">';

  echo '
    .col-md-4:nth-child(1) i.fa.fa-link:after{
	content: " ' . $translation_array['exterior'] . '";
}
 .col-md-4:nth-child(2) i.fa.fa-link:after{
	content: " ' . $translation_array['interior'] . '";
}
 .col-md-4:nth-child(3) i.fa.fa-link:after{
	content: " ' . $translation_array['cuina'] . '";
}
#gallery .row:nth-child(4)  .col-md-4:nth-child(1) i.fa.fa-link:after{
	content: " ' . $translation_array['graella'] . '";
}
#gallery  .row:nth-child(4) .col-md-4:nth-child(2) i.fa.fa-link:after{
	content: " ' . $translation_array['equip'] . '";
}
#gallery  .row:nth-child(4) .col-md-4:nth-child(3) i.fa.fa-link:after{
	content: " ' . $translation_array['plats'] . '";
}';

  echo '</style>';
}

function my_ajax_galeria() {
  echo "EOEEEEEOEOEO";
  die();
}

//Page Slug Body Class
function add_slug_body_class($classes) {
  global $post;
  if (isset($post)) {
    $classes[] = $post->post_type . '-' . $post->post_name;

    $slug = $post->post_name;
    if (ICL_LANGUAGE_CODE !='ca'){
    $original_ID = icl_object_id($post->ID, 'any', false, 'ca');
    $cat_post = get_post($original_ID);
       $slug = $cat_post->post_name;
       //print_r($cat_post);
       //echo "WEWE";die();
    }
    $classes[] = 'cb-caslug-' . $slug;
  }
  return $classes;
}

add_filter('body_class', 'add_slug_body_class');



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
add_shortcode( 'contact-form-cb', 'contact_cb' );

function contact_cb ($out, $pairs, $atts ) {
  global $lang;
  
  if (!isset($lang)) $lang = ICL_LANGUAGE_CODE;
  $contact['en']=1224;
  $contact['es']=1230;
  $contact['ca']=327;
  
  $out='[contact-form-7 id="'.$contact[$lang].'" title="Contacta con Can Borrell"]';
  $out=do_shortcode(''.$out.'');
 
  $title='<h1>'.__('Contact Can Borrell','canborrell').'</h1>';
  
    return $title.$out;
}
/* * ** MENU ACTIVE *** */
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

function special_nav_class($classes, $item) {
  global $post;

  if (is_object($post)) {
    $post_slug = $post->post_name;
    $post_meta = get_post_meta($post->ID);
  }

  $current_rel_uri = add_query_arg(NULL, NULL);
  /*
    echo $post_slug;
    echo '<br>';
    echo '<br>';
    echo '<br>';

    //echo '<br>';echo '<br>';echo '<br>';
    //var_dump($post_meta );
    die();
   */

  if (ICL_LANGUAGE_CODE != 'ca') {
    $lid = icl_object_id(get_the_ID(), 'any', false, 'ca');
    $cat_post = get_post($lid);

    if (!is_object($cat_post) || !isset($cat_post->post_name))
      return $classes;
    $cat_slug = $cat_post->post_name;
  }else {
    if (!is_object($post) || !isset($post->post_name))
      return $classes;
    $cat_slug = $post->post_name;
  }


  if (isset($post_meta ["_wp_page_template"]) && $post_meta ["_wp_page_template"][0] == 'page_historia_template.php' && $item->menu_order == 3) {
    $classes[] = "current";
  }
  if (isset($post_meta ["_wp_page_template"]) && $post_meta ["_wp_page_template"][0] == 'page_excursions_template.php' && $item->menu_order == 4) {


    $classes[] = "current";
  }
  if (isset($post->post_type) && $post->post_type == 'menus' && $item->menu_order == 1) {
    $classes[] = "current";
  }
  if ($cat_slug == 'premsa' && $item->menu_order == 5) {
    $classes[] = "current";
  }

  if ($cat_slug == 'horari-general-de-cuina' && $item->menu_order == 2) {
    $classes[] = "current";
  }

  if (substr($current_rel_uri, 0, 9) == '/reservar' && $item->menu_order == 6) {
    $classes[] = "current";
  }
  /*
    if(is_single() && $item->title == "Blog"){ //Notice you can change the conditional from is_single() and $item->title
    $classes[] = "special-class";
    } */
  return $classes;
}

function language_selector_flags() {
  $langs = "";
  if (function_exists('icl_get_languages')) {
    $languages = icl_get_languages('skip_missing=0');
    echo '<div class="lang_selector">';
    if (!empty($languages)) {
      foreach ($languages as $l) {
        $class = $l['active'] ? ' class="active"' : NULL;
        $langs .= '<a ' . $class . ' href="' . $l['url'] . '">' . strtolower($l['language_code']) . '</a> | ';
      }
      $langs = substr($langs, 0, -3);
      echo $langs;
    }
    echo '</div>';
  }
}

function arphabet_widgets_init() {


  
  
  register_sidebar(array(
    'name' => 'header_widget_1',
    'id' => 'header_widget_1',
    'before_widget' => '<div class="header_widget_1">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="rounded">',
    'after_title' => '</h2>',
  ));
}

add_action('widgets_init', 'arphabet_widgets_init');


/* */
add_action( 'template_redirect', function() {
        global $post;  
        if (!isset($post->ID)) $post->ID=0;
 session_start();
 // $_SESSION['permisos']=(isset($_SESSION['permisos']))?$_SESSION['permisos']:0;
 //$p=(isset($post))?$post->ID:0;
 $p=$post->ID;

if ($_SESSION['permisos']>250) return;  
    if ( $p== 1374 ) {
        return;
    }
    if (  $p== 1378 ) {
        return;
    }
    if (  $p== 1380 ) {
        return;
    }
    $node=array('ca'=>1374,'es'=>1378,'en'=>1380);
    
    if ($_SERVER['HTTP_HOST']=="cbwp-localhost"){

        if ( $p== 1362 ) {
            return;
        }
        if (  $p== 1364){
            return;
        }
        if (  $p== 1366 ) {
            return;
        }
        $node=array('ca'=>1366,'es'=>1362,'en'=>1364);
    }
    
    
   // 
   // wp_redirect( esc_url_raw( home_url( 'index.php?page_id='.$node[ICL_LANGUAGE_CODE] ) ) );
  //  exit;
} );
 
 
