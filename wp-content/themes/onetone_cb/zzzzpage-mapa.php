<?php
/*
$mapa['sanadjuntori']  = 'sanadjuntori.pdf';
$mapa['pantacanborrell']  = 'sanadjuntori.pdf';
$mapa['fontdelarata']  = 'sanadjuntori.pdf';
$mapa['pidenxandri']  = 'sanadjuntori.pdf';
$mapa['bicistcugat']  = 'sanadjuntori.pdf';
$mapa['santmedir']  = 'sanadjuntori.pdf';
$mapa['fontermeta']  = 'sanadjuntori.pdf';
$doc=$mapa[$_GET['m']];
//header('Location: /view-document?doc='.$doc);
 * */
 
/*
Template Name: Premsa Template
*/
get_header(); 

//the_post();
//global $post;
//print_r($post);die();

$sidebar                   = isset($page_meta['page_layout'])?$page_meta['page_layout']:'none';
$left_sidebar              = isset($page_meta['left_sidebar'])?$page_meta['left_sidebar']:'';
$right_sidebar             = isset($page_meta['right_sidebar'])?$page_meta['right_sidebar']:'';
$full_width                = isset($page_meta['full_width'])?$page_meta['full_width']:'no';
$display_breadcrumb        = isset($page_meta['display_breadcrumb'])?$page_meta['display_breadcrumb']:'yes';
$display_title             = isset($page_meta['display_title'])?$page_meta['display_title']:'yes';
$padding_top               = isset($page_meta['padding_top'])?$page_meta['padding_top']:'';
$padding_bottom            = isset($page_meta['padding_bottom'])?$page_meta['padding_bottom']:'';

if( $full_width  == 'no' )
 $container = 'container';
else
 $container = 'container-fullwidth';
 
$aside          = 'no-aside';
if( $sidebar =='left' )
$aside          = 'left-aside';
if( $sidebar =='right' )
$aside          = 'right-aside';
if(  $sidebar =='both' )
$aside          = 'both-aside';

$container_css = '';
if( $padding_top )
$container_css .= 'padding-top:'.$padding_top.';';
if( $padding_bottom )
$container_css .= 'padding-bottom:'.$padding_bottom.';';



?>
<article id="post-<?php the_ID(); ?>" <?php post_class('pagina-premsa'); ?>>
  <?php if (  $display_breadcrumb == 'yes' ): ?>
  
  <section class="page-title-bar title-left no-subtitle" style="">
    <div class="container">
      <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?>
      <hgroup class="page-title">
        <h1>
          <?php the_title();?>
        </h1>
      </hgroup>
      <div class="clearfix"></div>
    </div>
  </section>
  <?php endif;?>
  <div class="post-wrap">
    <div class="<?php echo $container;?>">
      <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css;?>">
        <div class="col-main">
          <section class="post-main " role="main" id="content">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="post type-post" id="">
              <?php if (  has_post_thumbnail() ): ?>
              <div class="feature-img-box">
                <div class="img-box">
                  <?php the_post_thumbnail();?>
                </div>
              </div>
              <?php endif;?>
              <div class="entry-main">
            
                <div class="entry-content">
                  <?php the_content();?>
                  <?php
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'onetone' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>
                </div>
                
              </div>
            </article>
            <div class="post-attributes">
              <!--Comments Area-->
              <div class="comments-area text-left">
                <?php
				  ?>
              </div>
              <!--Comments End-->
            </div>
            <?php endwhile; // end of the loop. ?>
              
              
              
              
                                  <div id="premsa-posts">
                                      <ul>
                  <?php
                  
                              $args = array(
	'posts_per_page'   => 0,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'premsa',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
                              wp_reset_postdata();
                              $premsa_array = get_posts( $args ); 
                              
                              foreach( $premsa_array as $post ) : 
                                $meta = get_post_meta($post->ID);
                              
                              $video="premsa-pdf";
                                
                             // echo substr($meta['file'][0],0,4);die();
                              if (substr($meta['file'][0],0,4)=='http'){
                                
                                $dir=$meta['file'][0];
                                $video="premsa-video";
                              }else{
                                $updir = wp_upload_dir();
                                $dir = $updir['baseurl'].'/premsa/' . $meta['file'][0];
                              }
                                ?>
                                          <li>
                                               <a href="<?php echo $dir;?>" class="<?php echo $video; ?>" target="_blank" class="publi">
  <div class="panel panel-default">
  <div class="panel-heading">
                                             <?php the_title();?>                                   </div>
  <div class="panel-body"><span class="publicacio-premsa">  <?php echo $post->post_content;?></span></div>
</div>
                                              
                                          
                                      </a>
                                              
                                           <!--   
                                          <a href="<?php echo $dir;?>" target="_blank" class="publi">
                                              <?php the_title();?>
                                          <br>
                                          <span class="publicacio-premsa">  <?php echo $post->post_content;?></span>
                                      </a>
                                           -->
                                           
    <?php
    
    ?>
                                          </li>
<?php endforeach; ?>
                                      </ul>
                </div>
              
              
              
              <br><br><br>
              
          </section>
        </div>
        <?php if(  $sidebar =='left' || $sidebar =='both' ):?>
        <div class="col-aside-left">
          <aside class="blog-side left text-left">
            <div class="widget-area">
              <?php get_sidebar('pageleft');?>
            </div>
          </aside>
        </div>
        <?php endif; ?>
        <?php if(  $sidebar =='right' || $sidebar =='both' ):?>
        <div class="col-aside-right">
          <?php get_sidebar('pageright');?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</article>
<?php get_footer(); ?>
