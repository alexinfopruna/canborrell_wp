<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Magee_Portfolio {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode( 'ms_portfolio', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults    =	Helper::set_shortcode_defaults(
			array(
				'num' 	=> '10',
				'category' 	=> '',
				'layout' => '',
				'style' => '1',
				'overlay_content' => '1',
				'overlay_color' => '',
				'overlay_opacity' => '0.5',
				'orientation' =>'top',
				'id' =>'',
				'columns' =>'4',
				'class' =>'',
				'page_nav'=>'yes',
				'filter' =>'no',
				'offset' => '',
				'exclude_category' => '',
				'align' => '',
				'display_title' => '',
				'display_tags' => '',
				'display_excerpt' => '',
				'excerpt_length' => '',
				'strip' => '',
				'is_preview' => ''
			), $args
		);
		
		global $paged, $overlay_content, $orientation;

		extract( $defaults );
		if('carousel' == $layout){
			Helper::get_style_depends(['font-awesome', 'bootstrap', 'owl-carousel', 'owl-theme', 'magee-shortcodes']);
			Helper::get_script_depends(['font-awesome', 'bootstrap', 'owl-carousel', 'magee-shortcodes']);
		}else
		{
			Helper::get_style_depends(['font-awesome', 'bootstrap', 'magee-shortcodes']);
			Helper::get_script_depends(['font-awesome', 'bootstrap', 'magee-shortcodes']);
		}
		

		self::$args = $defaults;
		$cat_arrs = $excat_arrs = array();
		$cat_st   = explode(',', $category);
		foreach($cat_st as $key) {
			$cat_arrs[] = sanitize_title($key);
		}
		$category = implode(',', $cat_arrs);
		$excat_st = explode(',', $exclude_category);
		foreach($excat_st as $key) {
			$excat_arrs[] = sanitize_title($key); 
		}	
		$exclude_category = implode(',', $excat_arrs);	
		
		if (!is_numeric($category)) {
			$cat_arr   = explode(',', $category);
			foreach($cat_arr as $key) {
				$val      = get_term_by('slug', $key, 'portfolio-category');
				$term[]   = isset($val->slug)?$val->slug:"";
			} 	 
			$term = implode(',', $term);
		}else{
			$val      =  get_term_by('id', $category, 'portfolio-category');
			$term     =  isset($val->slug)?$val->slug:"";
		}

		$term_slug = isset($term)?$term:"";

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		 
		$overlay_content = absint($overlay_content);
		$style           = absint($style);
		
		$uniq_class = Utils::rand_str('portfolio-');
		$class     .= ' '.$uniq_class;
		
		switch( $style ) {
			case "1":
			$class .= ' clearfix no-text';
			break;
			case "2":
			$class .= ' clearfix no-text full-width masonry';
			break;
		}
		$item_class = '';
		switch( $columns ) {
			case "2":
			$item_class = 'col-md-6';
			break;
			case "3":
			$item_class = 'col-md-4';
			break;
			case "4":
			$item_class = 'col-md-3';
			break;
			case "5":
			$item_class = 'col-md-1_5';
			break;
			case "6":
			$item_class = 'col-md-2';
			break;
			default:
			$item_class = 'col-md-4';
			break;
			
		} 
			
		$html  = '<div class="magee-portfolio">';
		$css_style = '';
		$script = '';

		if ( $overlay_color ) {
			$rgb = Helper::hex2rgb( $overlay_color );
			$css_style  .= '.'.$uniq_class.' .img-overlay{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$overlay_opacity.')}';
		}
		
		if ( $align ) {
			$css_style  .= '.'.$uniq_class.' .entry-main.text-center{text-align:'.$align.'}';
		}
		
		if ( $filter == '1' || $filter == 'yes' ) {
		    $html  .= '<nav class="portfolio-list-filter list-filter text-center">
							<ul id="filters" class="clearfix list-inline">';
						
							$taxonomy     = 'portfolio-category';
							$tax_terms    = get_terms($taxonomy) ;
							$cats         = array() ;
							$all_cats     = array() ;
							$i            = 0 ;
							if ( $tax_terms ) {
								foreach ($tax_terms as $tax_term) {
									$cats[$i]['slug'] = $tax_term->slug ;
									$cats[$i]['name'] = $tax_term->name ;
									$all_cats[]       = $tax_term->slug ;
									$i++;
								}
							}
			if (count($cats)>0)	
            	$html  .= '<li class="active"><span class="filter active" data-filter="all"><a href="javascript:;">'. __( 'All', 'magee-shortcodes').'</a></span></li>';
							  $i = 0;
                              if ( $cats ):
                              	foreach ($cats as $cat):
							  		if ( ($exclude_category == '' || !stristr($exclude_category, $cat['slug'])) && (stristr($category, $cat['slug']) || $category == '')) {
							  			$html  .= '<li><span class="filter" data-filter="'.$cat['slug'].'"><a href="javascript:;">'.$cat['name'].'</a></span></li>';
							  		}
							  		$i++;
                             	endforeach;
                              endif;
            	$html  .= '</ul></nav>';
                $class .= ' portfolio-list-filter';    
        }else{
			if ($layout == 'carousel' ) {
				$class  .= ' portfolio-carousel';
			}
			else{
				$class  .= ' magee-masonry';
			}
		}
		
                     
		$html  .= '<div class="portfolio-list-wrap portfolio-list-wrap-shortcode portfolio-list-style-'.$style.' '.$class.'" id="'.$id.'">';
		$html  .= '<div class="portfolio-list-items">';

		if ( $layout == 'carousel') {
			$html .= '<div class="multi-carousel  owl-carousel owl-theme " id="owl-theme">';
		}
		if ( intval($offset) || intval($offset)>0):
			$offset = intval($offset);
		else:
			$offset = 0;
		endif;
	
		if ($exclude_category !== '' && $category == ''):
			
			$exclude_category = explode(',', $exclude_category);
			foreach($exclude_category as $val) {
				$val = get_term_by('slug', $val, 'portfolio-category');
				$exclude[] = isset($val->term_id)? $val->term_id:"";
			}
			
			$query = new \WP_Query(array(
				'post_type' => MAGEE_PORTFOLIO,
				'paged' => $paged,
				'offset' => $offset,
				'orderby' => 'menu_order',
				'post_status' => 'publish',
				'posts_per_page' => $num,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio-category',
						'field'    => 'term_id',
						'terms'    => $exclude,
						'operator' => 'NOT IN',
					),
				),
			));

		else:
			$query = new \WP_Query('post_type='.MAGEE_PORTFOLIO.'&paged='.$paged.'&offset='.$offset.'&orderby=menu_order&post_status=publish&portfolio-category='.$term_slug.'&posts_per_page='.$num);
		endif;

		if ($query->have_posts() ):
			while ($query->have_posts() ) :
				$query->the_post();

				$post_id    =  get_the_ID();
				$permalink  =  get_post_permalink( $post_id  );
				$post_title =  get_the_title();

				$taxonomy  = 'portfolio-category';
				$cats      = array();
				$term_list = wp_get_post_terms( $post_id, $taxonomy, array("fields" => "all"));
				foreach( $term_list as $term ) {
					$cats[] = $term->slug;
				}
					
				if ( $layout == 'carousel') {
					$html .= '<div class="item"> 
						<div class="portfolio-box-wrap '.implode(' ', $cats ).'" data-cat="'.implode(' ', $cats ).'">';	 
			
				} else {
					$html .= '<div class="portfolio-box-wrap '.$item_class.' '.implode(' ', $cats ).'" data-cat="'.implode(' ', $cats ).'">';
				}

				if ( !$orientation ) $orientation = 'top';
				if ( !$overlay_content ) $overlay_content = '1';

				//overlay_content: 1, button 2, title 3, title & tags 4, link
				$taxonomy  = 'portfolio-tag';
				$tax_terms = wp_get_post_terms( get_the_ID(), $taxonomy);
				$tags      = array();
				if ( $tax_terms ) {
					foreach ($tax_terms as $tax_term) {
						$term_link = get_term_link( $tax_term );
							if ( is_wp_error( $term_link ) ) {
								continue;
							}
						$tags[] = '<a href="' . esc_url( $term_link ) . '" title="' . sprintf( __( "View all posts in %s" ,'magee-shortcodes'), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a>';
					}
				}
				$tags_str = '';
				if ($tags)
					$tags_str = implode(', ', $tags);

				$action = 'from-'.$orientation;
				if ($overlay_content == '5')
					$action = 'img-zoom-in';

				$html .= '<article id="portfolio-'.$post_id.'" class="portfolio-box" role="article">
							<div class="feature-img-box">
								<div class="img-box figcaption-middle text-center '.$action.' fade-in">';
			
									if ($overlay_content == '2' || $overlay_content == '4' || $overlay_content == '5'):
										$html .= ' <a href="'.get_permalink().'">';
									endif;

									ob_start();
									the_post_thumbnail("portfolio-thumb");
									$html .= ob_get_contents();  
									ob_end_clean();

									$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
									$featured_image = $image[0];
											
									$html .= '<div class="img-overlay '.( $overlay_content == '4' ? 'light':'').' '. ( $overlay_content == '5' ? 'primary':'').'">
												<div class="img-overlay-container">
													<div class="img-overlay-content">';
													
													if ($overlay_content == '1'):
														$html .= '<div class="img-overlay-icons">
														<a href="'.$permalink.'"><i class="fa fa-link"></i></a>
														<a rel="magee-portfolio-image" href="'.$featured_image.'"><i class="fa fa-search"></i></a>
														</div>';
													endif;
													
													if ($overlay_content == '2'):
														$html .= '<h3 class="img-overlay-title">'.$post_title.'</h3>';
													endif;
													
													if ($overlay_content == '3'):
														$html .= '<a href="'.$permalink.'"><div class="img-overlay-total-link"></div></a>
														<a href="'.$permalink.'"><h3 class="img-overlay-title">'.$post_title.'</h3></a>
														<div class="entry-category">'.$tags_str.'</div>';
													endif;
														
													if ( $overlay_content == '4' || $overlay_content == '5' ):
														$html .= '<i class="fa fa-link"></i>';
													endif;
														
													$html .= '</div>
												</div>
											</div>';

										if ( $overlay_content == '2' || $overlay_content == '4' || $overlay_content == '5' ):
											$html .= '</a>';
										endif;
									$html .= '</div>
											</div>';


									$html .= '<div class="entry-main text-center">';

									if ($display_title != 'no' && $display_tags != 'no') {
										$html .= '<div class="entry-header">';

										if ( $display_title == 'yes'):
											$html .= '<h2 class="entry-title"><a href="'.$permalink.'">'.$post_title.'</a></h2>';
										endif;

										if ( $display_tags == 'yes'):
											$html .= '<div class="entry-meta">
														<div class="entry-category">
															'.$tags_str.'
														</div>														  
													</div>';	
										endif;	  											  												  
										$html .= '</div>';
									}
									if ( $display_excerpt == 'yes'):
										$html .= '<div class="entry-summary">';
										if ( $strip == 'yes'):
											if ( intval($excerpt_length) || intval($excerpt_length)>0):
												$html .= strip_tags(Helper::get_summary($excerpt_length)) ;
											else:
												$html .= strip_tags(Helper::get_summary()) ;
											endif;
										else:
											if (intval($excerpt_length) || intval($excerpt_length)>0):
												$html .= Helper::get_summary($excerpt_length);
											else:
												$html .= Helper::get_summary() ;
											endif;
										endif;	  
									$html .= '</div>';
									endif;
									$html .= ' </div>

						</article>';
				
				if ( $layout == 'carousel') {
					$html .= '</div>';
				}
				$html .= '</div>';

			endwhile;
		endif;
		if ( $layout == 'carousel') {
			$html .= '</div>
						<!-- Controls -->
						<div class="multi-carousel-nav style1 nav-bg ">
							<a  class="carousel-prev" role="button" data-slide="prev">
								<span class="multi-carousel-nav-prev"></span>
							</a>
							<a class="carousel-next" role="button" data-slide="next">
								<span class="multi-carousel-nav-next"></span>
							</a>
						</div>';

			$script .= 'jQuery(document).ready(function($) {
							var owl = $(".'.$uniq_class.' #owl-theme");
							owl.owlCarousel({
								autoPlay: 3000, //Set AutoPlay to 3 seconds
								items : '.$columns.',
								itemsDesktop : [1199,3],
								itemsDesktopSmall : [979,3]
							});
							
							$(".carousel-next").click(function() {
								owl.trigger("next.owl.carousel");
							})
							$(".carousel-prev").click(function() {
								owl.trigger("prev.owl.carousel");
							})
						});';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		if ( $page_nav == 'yes' )
			$html .= Helper::paging_nav('return', $query);
		wp_reset_postdata();
		
		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$is_preview = "1";
		}

		$script .= 'jQuery(document).ready(function($){

			$(".portfolio-list-filter .filter").click(function(){
				var value = $(this).attr("data-filter");
				var wrap = $(this).parents(".magee-portfolio");
				if(value == "all")
				{
					wrap.find(".portfolio-box-wrap").show("1000");
				}
				else
				{
					wrap.find(".portfolio-box-wrap").not("."+value).hide("3000");
					wrap.find(".portfolio-box-wrap").filter("."+value).show("3000");
				}
				if (wrap.find("li").removeClass("active")) {
					$(this).parent("li").removeClass("active");
				}
				$(this).parent("li").addClass("active");
			});
		
			});';

		if ($is_preview == "1"){
			$html = sprintf( '<style type="text/css" scoped="scoped">%1$s</style>%2$s ' ,$css_style, $html );
			$html = sprintf( '%1$s<script>%2$s</script>', $html, $script);
		}else{
			wp_add_inline_style('magee-shortcodes', $css_style);
			wp_add_inline_script('magee-shortcodes', $script, 'after');
		}

		return $html ;
	}

}

new Magee_Portfolio();