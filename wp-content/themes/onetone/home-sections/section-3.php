<?php
// Section gallery
 global $onetone_animated, $onetone_section_id, $allowedposttags;
 $i                   = $onetone_section_id ;
 $detect              = new Mobile_Detect;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$i );
 $section_css_class   = onetone_option( 'section_css_class_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 $full_width          = onetone_option( 'full_width_'.$i );
	
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );

 
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
  
  if( ($parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on") && !$detect->isIOS() ){
	 $section_css_class  .= ' onetone-parallax';
  }
  
?>

<section id="<?php echo esc_attr($section_id); ?>" class="home-section-<?php echo $i; ?> <?php echo esc_attr($section_css_class);?>">
    	<div class="home-container <?php echo esc_attr($container_class); ?> page_container section_gallery_<?php echo $i; ?>">
         <?php
		if( $content_model == '0' || $content_model == ''  ):
		?>
        
         <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
       <?php  
		   $section_title_class = '';
		   if( $section_subtitle == '' && !(function_exists('is_customize_preview') && is_customize_preview()))
		   $section_title_class = 'no-subtitle';
		?>
       <h2 class="section-title <?php echo esc_attr($section_title_class); ?> <?php echo 'section_title_'.$i;?>"><?php echo wp_kses($section_title, $allowedposttags);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses($section_subtitle, $allowedposttags))?></div>
         <?php endif;?>
         <div class="home-section-content">
		 <?php
		$items = '';
		$item  = '';
		$j     = 0;
		$c     = 0;
		$animationtype = array('fadeInLeft','fadeInDown','fadeInRight','fadeInLeft','fadeInUp','fadeInRight','fadeInUp','fadeInUp','fadeInUp','fadeInUp','fadeInUp','fadeInUp');
		$section_gallery  = onetone_option( 'section_gallery_'.$i ); 
		if (is_array($section_gallery) && !empty($section_gallery) ){
			foreach($section_gallery as $gallery_item ){
				 $image  = $gallery_item[ "image" ];
				 $link   = esc_url($gallery_item[ "link" ]);
				 $target = esc_attr($gallery_item[ "target" ]);
				 if (is_numeric($image)) {
					$image_attributes = wp_get_attachment_image_src($image, 'full');
					$image       = $image_attributes[0];
				  }
				 
				 if($image !=''){
					 if( $link == "" )
						 $img_wrap = '<a href="'.esc_url($image).'" rel="onetone-portfolio-image section_image_'.$i.'_'.$c.'"><img src="'.esc_url($image).'" alt="'.sprintf(__('Portfolio Image %s', 'onetone'),($c+1)).'"  class="feature-img "><div class="img-overlay dark">
																						<div class="img-overlay-container">
																							<div class="img-overlay-content">
																								<i class="fa fa-search"></i>
																							</div>
																						</div>
																					</div></a>';
					 else
						 $img_wrap = '<a href="'.$link.'" target="'.$target.'"><img src="'.esc_url($image).'" alt="'.sprintf(__('Portfolio Image %s', 'onetone'),($c+1)).'" class="feature-img "><div class="img-overlay dark">
																						<div class="img-overlay-container">
																							<div class="img-overlay-content">
																								<i class="fa fa-link"></i>
																							</div>
																						</div>
																					</div></a>';
				  
					
						
				$item .= '<div class="col-md-4">
				<div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="'.$animationtype[$c].'" data-imageanimation="no">
			  <div class="magee-feature-box style1" data-os-animation="fadeOut">
				<div class="img-frame"><div class="img-box figcaption-middle text-center fade-in">'.$img_wrap.'</div></div>
			</div></div></div>';
				 if( ($j+1) % 3 == 0){
					 $items .= '<div class="row no-padding no-margin">'.$item.'</div>';
					 $item = '';
					 }
					 $j++;
				}
				$c++;
			}
		}
		if( $item != '' ){ $items .= '<div class="row no-padding no-margin">'.$item.'</div>';}
		echo $items;
		?>
        </div>
         <?php
		else:
		?>
        <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-title <?php echo 'section_title_'.$i;?>"><?php echo esc_attr($section_title);?></div>
        <?php endif;?>
          
            <div class="home-section-content <?php echo 'section_content_'.$i;?>">
            <?php 
			if(function_exists('Form_maker_fornt_end_main'))
             {
                 $section_content = Form_maker_fornt_end_main($section_content);
              }
			 echo do_shortcode(wp_kses($section_content, $allowedposttags));
			?>
            </div>
            <?php 
		endif;
		?>
        </div>
  <div class="clear"></div>
</section>