<?php

$mapa['santadjuntori']  = 'https://www.google.com/maps/d/embed?mid=16Ck3t221OwId_SGeRq7TL_Ad3BE&hl=ca';
$mapa['pantacanborrell']  = 'https://www.google.com/maps/d/embed?mid=1Wxu0LV6OkAgqcpA8dkvSDyDoYEo&hl=ca';
$mapa['fontdelarata']  = 'https://www.google.com/maps/d/embed?mid=1bC_th5NbXHLinOhoihUejTsTiAo';//https://www.google.com/maps/d/viewer?hl=ca&authuser=0&mid=1bC_th5NbXHLinOhoihUejTsTiAo
$mapa['pidenxandri']  = '/view-document/?doc=google.com/maps/d/embed?mid=1r9ee1eaPo1klNnfykf6gply3ZuA';//
$mapa['bicistcugat']  = '/view-document/?doc=google.com/maps/d/embed?mid=10XfBFsws36NY4weQ32Srfp2oYPI';//https://www.google.com/maps/d/viewer?hl=ca&authuser=0&mid=10XfBFsws36NY4weQ32Srfp2oYPI
$mapa['santmedir']  = '/view-document/?doc=google.com/maps/d/embed?mid=1uQ47UCYNdJy5VLBAgc0w26s3rFw';//
$mapa['fontermeta']  = '/view-document/?doc=google.com/maps/d/embed?mid=120fX_RRJUcFgpAMoJP2MogGmwoI';//
//https://docs.google.com/gview?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true
/*
if (isset($_GET['map'])){
  $iframe_url = $mapa[$_GET['map']];
 //echo $mapa[$_GET['map']];die();
}

elseif(isset($_GET['pdf'])) $iframe_url = $mapa[$_GET['pdf']];
*/
if(isset($_GET['doc'])) {
  $iframe_url = $_GET['doc'];
}

if(isset($_GET['embedded'])) {
  $iframe_url .= '&embedded=true';
}

if(substr($iframe_url,0,4)!='http') $iframe_url = 'https://'.$iframe_url;


//echo $iframe_url;die();
/**
 * The template for displaying all single posts.
 *
 * @package onetone
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
<script type="application/javascript">
jQuery(document).ready( function($) {
    var iFrame = document.getElementById( 'iFrame1' );
    resizeIFrameToFitContent( iFrame );
    
    $( window ).resize(function(){
      resizeIFrameToFitContent( document.getElementById( 'iFrame1' ) );
    });
    
    // or, to resize all iframes:
    /*
    var iframes = document.querySelectorAll("iframe");
    for( var i = 0; i < iframes.length; i++) {
        resizeIFrameToFitContent( iframes[i] );
    }
    */
});

function resizeIFrameToFitContent( iFrame ) {
  var h= iFrame.contentWindow.document.body.scrollHeight;
  //if (h<500) h=500;

    iFrame.width  = '100%';
    
      var w = iFrame.contentWindow.document.body.scrollWidth;
  h = w * 1.4;
h = w * 0.5;
    iFrame.height = h;
    
}
</script>

  
  
  
<style>
    body, html{
        min-height: 100% ;
    }
    article, .post-inner{ background:#333;}
</style>
    
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
          <section class="post-main" role="main" id="content">
              <a class="dins btn btn-success" href="#" target="_self" onclick=" window.history.back();"> <i class="fa  fa-arrow-left" style="color:white;"></i>  <?php echo __('Go back','canborrell');?></a>
           
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
            
                <div class="entry-content ">
                  <?php the_content();?>
                    
                    <iframe id="iFrame1" src="<?php echo $iframe_url;?>" width="100%" height="499px"></iframe>
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
					  // If comments are open or we have at least one comment, load up the comment template
					  if ( comments_open()  ) :
						  comments_template();
					  endif;
				  ?>
              </div>
              <!--Comments End-->
            </div>
            <?php endwhile; // end of the loop. ?>
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
