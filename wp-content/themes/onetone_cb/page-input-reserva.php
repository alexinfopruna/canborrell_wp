<?php
/*
Template Name: Input reserva
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

if(!isset($_GET['a'])) {
  global $sitepress;
  $lang = $sitepress->get_current_language();
  header("Location: reservar/realizar-reserva/?lang=".$lang);
  $_GET['a']="edit";
}

$action_title['edit'] = 'Edit reservation';
$action_title['cancel'] = 'Cancel reservation';
$action_title['pay'] = 'Reservation payment';
$title = __($action_title[$_GET['a']],'canborrell');

?>

<script  type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js'></script>
<script>
   
  jQuery("#input-reserva").validate();
  
  });
</script>  

<style>
    label.error {
    color: red;
    font-style: italic;
    display:inline;
}

input{display:block;}

input.error {
    border: 1px dotted red;
}

form{
    padding:20px;
    background-color: #eee;
}
</style>
  
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if (  $display_breadcrumb == 'yes' ): ?>
  
  <section class="page-title-bar title-left no-subtitle" style="">
    <div class="container">
      <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?>
      <hgroup class="page-title">
        <h1>
          <?php 
          echo $title;
          //
          //
          //the_title();?>
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
                    
                    <?php
                       $required=__('This field is required','canborrell');
                       $number=__('Enter a valid number','canborrell');
                       $email=__('Enter a valid email','canborrell');
                       $submit=__('Continue','canborrell');
                    ?>
                    
                    <form id="input-reserva" method="post" >
                         <label for="rid">ID de reserva</label>
  <input name="rid" type="number" id="rid" required data-msg-required="<?php echo $required?>" data-msg-email="<?php echo $number?>">
  <br>
   <label for="email">Email</label>
  <input name="email" type="email" id="email" required data-msg-required="<?php echo $required?>" data-msg-email="<?php echo $email?>">
  <br>
  <button name="Continue" type="submit" id="submit"><?php echo $submit?></button>
  
</form>
                    
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
