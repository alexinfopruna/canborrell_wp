<?php

/**
 * The template for displaying all single posts.
 *
 * @package onetone
 */


get_header(); 
//$left_sidebar   = onetone_option('left_sidebar_blog_posts','');
$left_sidebar   = 'sidebar-6';
//echo $left_sidebar;die(); 
$right_sidebar  = onetone_option('right_sidebar_blog_posts','');
$aside          = 'no-aside';
if( $left_sidebar !='' )
$aside          = 'left-aside';
if( $right_sidebar !='' )
$aside          = 'right-aside';
if(  $left_sidebar !='' && $right_sidebar !='' )
$aside          = 'both-aside';







/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/
if (!defined('ROOT'))
  define('ROOT', "cb-reserves/taules/");

define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

require_once(ROOT . '../reservar/' . "Gestor_form.php");
$gestorf = new Gestor_form();

$usr = new Usuari(USR_FORM_WEB, "webForm", 1);
if (!isset($_SESSION['uSer'])) {
  $_SESSION['uSer'] = $usr;
}

$_SESSION['admin_id'] = $_SESSION['uSer']->id;
$_SESSION['permisos'] = $_SESSION['uSer']->permisos;

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true && !$gestorf->valida_login())
  header("Location:/cb-reserves/reservar/fora_de_servei.html");

require_once(ROOT . INC_FILE_PATH . 'alex.inc');
require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");


global $sitepress;
$language_uri = substr($_SERVER['REQUEST_URI'], 0, 4);
//echo $language_uri;die();

  $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'ca';
  $gestorf->idioma($lang);


$gestorf->lng = $lang = Gestor::getLanguage();
$l = $gestorf->lng;

require(ROOT.'../reservar/translate_carta_'.$l.'.php');

/* * ******************************************************************************** */
$sitepress->switch_lang($lang);
/* * ******************************************************************************** */




?>
<style scoped>
   .carta li{border-bottom: #ccc dotted 1px;}
</style>  


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<section class="page-title-bar title-left no-subtitle cartaweb" style="">
            <div class="container">
                <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?> 
                <hgroup class="page-title">
                    <h1>
                          <?php echo __( 'Menus', 'canborrell' );//the_title();?>
                    
                    </h1>
                </hgroup>
                
                <div class="clearfix"></div>            
            </div>
        </section>
        
<div class="post-wrap">
            <div class="container">
                <div class="post-inner row <?php echo $aside; ?>">
                    <div class="col-main">
                        <section class="post-main" role="main" id="content">
                            
                            <div class="suggeriments alert alert-success ">
<span class="glyphicon glyphicon-info-sign" style="font-size:1.8em"></span>   <?php
switch (ICL_LANGUAGE_CODE){
  case 'en':
        echo SUGGERIMENTS_EN;
    break;
  case 'es':
          echo SUGGERIMENTS_ES;
    break;
  default:
    echo SUGGERIMENTS_CA;
    break;
}

 ?>
</div>
    
                            
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article class="post type-post" id="">
                            <?php if (  has_post_thumbnail() ): ?>
                                <div class="feature-img-box">
                                    <div class="img-box">
                                            <?php the_post_thumbnail();?>
                                    </div>                                                 
                                </div>
                                <?php endif;?>
                                <div class="entry-main aborder">
                                    
          <a href="#menus"> <button type="button" class="btn btn-primary veure-menus"><?php echo __("Veure tots els menús",'themedomain')?></button></a>
                                    
                                                                           <div class="panel panel-default">
  <div class="panel-heading"><?php the_title();?></div>
  <div class="panel-body menu-content">
    <a><img title="Ampliar" src="/wp-content/uploads/assets/plats/f_plats_7pt.jpg" alt="Foto"    width="80" height="80" border="0" /></a> <a><img title="Ampliar" src="/wp-content/uploads/assets/plats/f_plats_15pt.jpg" alt="Foto" width="80" height="80" border="0" /></a> <a><img title="Ampliar" src="/wp-content/uploads/assets/plats/f_plats_14pt.jpg" alt="Foto" width="80" height="80" border="0" /></a>
    
         
      
      <?php 
   
  /*****************************/
  /*****************************/
  /*****************************/
  /*****************************/
  /*****************************/
  
  
echo $string = do_shortcode( $gestorf->recuperaCartaWeb() );
//the_content();?></div>
</div>
                    

                                    
                                    
                                    
                                    <div class="entry-header">                                            
                                        <h3 class="entry-title"><?php //the_title();?></h3>
                                        
                                    </div>
                                    <div class="entry-content">                                        
                                        <?php //the_content();?>   
                                        <?php
				
                                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'onetone' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>    
                                    </div>
                                    <div class="entry-footer">
                                        <?php
												if(get_the_tag_list()) {
													echo get_the_tag_list('<ul class="entry-tags no-border pull-left"><li>','</li><li>','</li></ul>');
												}
												
												$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
												?>
                                    </div>
                                </div>
                            </article>

                            <div class="post-attributes">
                                
                                <?php 
									$related_number = onetone_option('related_number',8);
									$related        = onetone_get_related_posts($post->ID, $related_number,'post'); 
									
									?>
			                        <?php if($related->have_posts()): 
									        $date_format = onetone_option('date_format','M d, Y');
									?>
                                <!--About Author End-->
                                <!--Related Posts-->
                                <div class="related-posts">
                                        <h3><?php _e( 'Related Posts', 'onetone' );?></h3>
                                        <div class="multi-carousel onetone-related-posts owl-carousel owl-theme">
                                        
                                            <?php while($related->have_posts()): $related->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
                            <?php //$full_image  = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); 
							       $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'related-post');
							?>
                                            <div class="owl-item">
                                            <div class="post-grid-box">
                                                                <div class="img-box figcaption-middle text-center from-left fade-in">
                                                                    <a href="<?php the_permalink(); ?>">
                                                                        <img src="<?php echo $thumb_image[0];?>" class="feature-img"/>
                                                                        <div class="img-overlay">
                                                                            <div class="img-overlay-container">
                                                                                <div class="img-overlay-content">
                                                                                    <i class="fa fa-link"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>                                                  
                                                                </div>
                                                                <div class="img-caption">
                                                                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                                                    <ul class="entry-meta">
                                                                        <li class="entry-date"><i class="fa fa-calendar"></i><?php echo get_the_date( $date_format );?></li>
                                                                        <li class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            </div>
                                            <?php endif; endwhile; ?>
                                        </div>
                                    </div>
                                <!--Related Posts End-->
                                <?php wp_reset_postdata(); endif; ?>
                                <!--Comments Area-->                                
                                <div class="comments-area text-left">
                                     <?php
											// If comments are open or we have at least one comment, load up the comment template
											if ( comments_open()  ) :
												comments_template();
											endif;
										?>
                                </div>
                                <!--Comments End-->
                                  <?php echo onetone_post_nav();?>
                                      </div>
                            
                            <?php endwhile; // end of the loop. ?>
                        </section>
                    </div>
                        <?php if( $left_sidebar !='' ):?>
                    <div class="col-aside-left">
                        <a id="menus"></a>
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                                <?php get_sidebar('menus');?> 
                            </div>
                        </aside>
                    </div>
                    <?php endif; ?>

                    <?php if( $right_sidebar !='' ):?>
                    <div class="col-aside-right">
                       <?php get_sidebar('postright');?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>  
        </div>

      </article>
<?php get_footer(); ?>
