<?php
global $onetone_animated, $onetone_section_id, $allowedposttags;
 $i                   = $onetone_section_id ;
 $detect              = new Mobile_Detect;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$i );
 $section_css_class   = onetone_option( 'section_css_class_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 $full_width          = onetone_option( 'full_width_'.$i );


  if( !isset($section_content) || $section_content=="" ) 
  $section_content = onetone_option( 'sction_content_'.$i );
  
  $section_id      = sanitize_title( onetone_option( 'menu_slug_'.$i ) );
  if( $section_id == '' )
   $section_id = 'section-'.$i;
   
   $section_id  = strtolower( $section_id );
  
  $container_class = "container";
  if( $full_width == "yes" ){
  $container_class = "";
  }
  
  if(($parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on") && !$detect->isIOS()){
	 $section_css_class  .= ' onetone-parallax';
  }
  
?>

<section id="<?php echo esc_attr($section_id); ?>" class="home-section-<?php echo $i; ?> <?php echo esc_attr($section_css_class);?>">

    	<div class="home-container <?php echo $container_class; ?> page_container">
		<?php if($section_title){ ?>
        	<h2 class="section-title <?php echo 'section_title_'.$i;?>"><?php echo esc_attr($section_title);?></h2>
            <?php } ?>
          
            <div class="home-section-content <?php echo 'section_content_'.$i;?>">
            <?php 
			if(function_exists('Form_maker_fornt_end_main'))
             {
                 $section_content = Form_maker_fornt_end_main($section_content);
              }
			 echo do_shortcode(wp_kses($section_content, $allowedposttags));
			?>
            </div>
        </div>
  <div class="clear"></div>
</section>