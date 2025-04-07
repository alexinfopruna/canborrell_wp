<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;

class Magee_Blog {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
		add_shortcode( 'ms_blog', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {
		
		Helper::get_style_depends(['font-awesome', 'magee-shortcodes']);
		Helper::get_script_depends(['magee-shortcodes']);

	    $date_format = MAGEE_DATE_FORMAT;
		
		$defaults    =	Helper::set_shortcode_defaults(
			array(
				'num' 	                     => '10',
				'category'                 	 => '',
				'column'                     => '3',
				'style'                      => '1',
				'id'                         =>'',
				'class'                      =>'',
				'page_nav'                   =>'yes',
				'offset'                     => '0',
				'exclude_category'           => '',
				'display_image'              => '',
				'display_title'              => '',
				'display_meta'               => '',
				'display_excerpt'            => '',
				'excerpt_length'             => '',
				'strip'                      =>''
 			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		global $paged;
		 
		$class_column = 'col-md-4'; 
		switch( $column ) {
			case "1":
				$class_column = 'col-md-12';
				break;
			case "2":
				$class_column = 'col-md-6';
				break;
			case "3":
				$class_column = 'col-md-4';
				break;
			case "4":
				$class_column = 'col-md-3';
				break;
		}

		if( !is_numeric($column) || $column<=0 )
			$column = 3;
		
		if ( '' == $display_image ) $display_image = MAGEE_DISPLAY_IMAGE;
		
		
		if( intval($offset) || intval($offset)>0):
			$offset = intval($offset);
		else:
			$offset = 0;
		endif;	
		$style = absint($style);
			
		$html = '<div id="'.esc_attr($id).'" class="magee-blog-list-wrap magee-shortcode magee-blog  '.esc_attr($class).'">';
		$paged =(get_query_var('paged'))? get_query_var('paged'): 1;
		$wp_query = new \WP_Query();
		$exclude_id = array();
		$exclude_categories = explode(',', $exclude_category);
		foreach($exclude_categories as $exclude_category ) {
			$exclude_id_obj = get_category_by_slug( $exclude_category );
			if ( $exclude_id_obj ) {
				$exclude_id[] = '-'.$exclude_id_obj->term_id;
			}
		}
		$exclude_ids = implode(',', $exclude_id);

		if( absint($offset) >0 ):
			$wp_query -> query('showposts='.$num.'&category_name='.$category.'&paged='.$paged.'&offset='.$offset.'&cat= '.$exclude_ids."&post_status=publish&ignore_sticky_posts=1"); 
		else:
			$wp_query -> query('showposts='.$num.'&category_name='.$category.'&paged='.$paged.'&cat= '.$exclude_ids."&post_status=publish&ignore_sticky_posts=1"); 
		endif;

		$i = 1 ;
		$html_item = '';
		
		if( $style == '4'  ):			 
			$html .= '<div class="blog-timeline-wrap">
				<div class="blog-timeline-icon">
					<i class="fa fa-comments"></i>
				</div>
				<div class="blog-timeline-inner">
					<div class="blog-timeline-line"></div>
					<div class="blog-list-wrap blog-timeline clearfix">';
											
		endif;
	
		if ($wp_query -> have_posts()) :
			while ( $wp_query -> have_posts() ) : $wp_query -> the_post();
			
				$featured_image = '';
				if( has_post_thumbnail() ) {
				
					$thumbnail_id     = get_post_thumbnail_id(get_the_ID());
					$image_attributes = wp_get_attachment_image_src( $thumbnail_id, "related-post" );
					
					$imageInfo     = get_post($thumbnail_id);
					$image_title   = get_the_title();
					if( isset( $imageInfo->post_title) )
						$image_title   = $imageInfo->post_title;
					
					if( $display_image == 'yes'):
						$featured_image = '<div class="feature-img-box"><div class="img-box figcaption-middle text-center from-top fade-in">
												<a href="'.get_permalink().'" >
													<img src="'.$image_attributes[0].'" alt="'.$image_title.'" class="feature-img">
													<div class="img-overlay dark">
														<div class="img-overlay-container">
															<div class="img-overlay-content">
																<i class="fa fa-link"></i>
															</div>
														</div>                                                        
													</div>
												</a>
											</div> </div>';
					endif;													
				}
				
				if( $style == '1' ):
			
					$html_item .= '<div class="'.$class_column.'">
									<div class="entry-box-wrap">
										<article class="entry-box" role="article">
											
												'.$featured_image.'                                             
											
											<div class="entry-main">
												<div class="entry-header">' ;
												
													if( $display_title == 'yes')  
														$html_item .= '<a href="'.get_permalink().'"><h4 class="entry-title">'.get_the_title().'</h4></a>' ;
													
													if( $display_meta == 'yes')
														$html_item .= '<ul class="entry-meta" >
															<li class="entry-date"><i class="fa fa-calendar"></i><a href="'.get_month_link(get_the_time('Y'), get_the_time('m')).'">'.get_the_date( $date_format ).'</a></li>
															<li class="entry-comments pull-right">'.Helper::get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'magee-shortcodes'), __( '<i class="fa fa-comment"></i> % ', 'magee-shortcodes'), 'read-comments', '').'</li>
														</ul>';
													
												$html_item .= '</div>';
												
												if( $display_excerpt == 'yes'):
													$html_item .= '<div class="entry-summary" >';
														if( $strip == 'yes'):
															if(intval($excerpt_length) || intval($excerpt_length)>0):
																$html_item .= strip_tags(Helper::get_summary($excerpt_length)) ;
															else:
																$html_item .= strip_tags(Helper::get_summary()) ;
															endif;
														else:
															if(intval($excerpt_length) || intval($excerpt_length)>0):
																$html_item .= Helper::get_summary($excerpt_length);
															else:
																$html_item .= Helper::get_summary() ;
															endif;
														endif;	 
													$html_item .= '</div>';
												else:
													$html_item .= '<div class="entry-summary" ></div>';        
												endif;
											$html_item .=  '</div> 
										</article>
									</div>
								</div>';

					if( $i%$column == 0 ):
						$html .= '<div class="row">'.$html_item.'</div>';
						$html_item = '';
					endif;
				endif;

				if( $style == '2' ):
					$col_image   = '';
					$col_content = 'col-md-12';
					if($featured_image) {
						$col_image   = 'col-md-4';
						$col_content = 'col-md-8';
					}
					$html_item .= '<div class="'.$class_column.'">
									<div class="entry-box-wrap">
										<article class="entry-box row" role="article">
											<div class="entry-aside '.$col_image.'">
												'.$featured_image.'
											</div>
											<div class="entry-main '.$col_content.'">
												<div class="entry-header">';
												
													if($display_title == 'yes')
													$html_item .= '<a href="'.get_permalink().'"><h4 class="entry-title">'.get_the_title().'</h4></a>' ;
													
													if($display_meta == 'yes')
													$html_item .= ' <ul class="entry-meta">
														<li class="entry-date"><i class="fa fa-calendar"></i><a href="'.get_month_link(get_the_time('Y'), get_the_time('m')).'">'.get_the_date( $date_format ).'</a></li>
														<li class="entry-comments pull-right">'.Helper::get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'magee-shortcodes'), __( '<i class="fa fa-comment"></i> % ', 'magee-shortcodes'), 'read-comments', '').'</li>
													</ul>';
													
									$html_item .= '</div>' ;
									
												if( $display_excerpt == 'yes') {
												$html_item .= '<div class="entry-summary" style="display:block;">';
														if( $strip == 'yes'):
																if(is_int($excerpt_length) || $excerpt_length>0):
																$html_item .= strip_tags(Helper::get_summary($excerpt_length)) ;
																else:
																$html_item .= strip_tags(Helper::get_summary()) ;
																endif;
														else:
																if(is_int($excerpt_length) || $excerpt_length>0):
																$html_item .= Helper::get_summary($excerpt_length) ;
																else:
																$html_item .= Helper::get_summary() ;
																endif;
														endif;	
												$html_item .= '</div>';
												}
										$html_item .= '</div>
										</article>
									</div>
								</div>';
										
					if( $i%$column == 0 ) {
						$html .= '<div class="row">'.$html_item.'</div>';
						$html_item = '';
					}
				endif;

				if( $style == '3' ):
				
					$col_image   = '';
					$col_content = 'col-md-12';
					if($featured_image) {
						$col_image   = 'col-md-4';
						$col_content = 'col-md-8';
					}

					$html_item .= '<div class="'.$class_column.'">
								<div class="entry-box-wrap">
									<article class="entry-box row">
										<div class="entry-aside '.$col_image.'">
											'.$featured_image.'
										</div>
										<div class="entry-main '.$col_content.'">
											<div class="entry-header">';
									if( $display_title == 'yes')		
										$html_item .= '<a href="'.get_permalink().'"><h4 class="entry-title">'.get_the_title().'</h4></a>' ;
									if( $display_meta == 'yes')
										$html_item .=  Helper::posted_on(false, $defaults);
									$html_item .= '</div>' ;
									if( $display_excerpt == 'yes') {
										$html_item .= '<div class="entry-summary">';
										if( $strip == 'yes'):
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html_item .= strip_tags(substr(Helper::get_summary(),0, $excerpt_length)) ;
												else:
													$html_item .= strip_tags(Helper::get_summary()) ;
												endif;
										else:
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html_item .= Helper::get_summary().substring(0, $excerpt_length) ;
												else:
													$html_item .= Helper::get_summary() ;
												endif;
										endif;	
										$html_item .= '</div>';
									}
									$html_item .= '<div class="entry-footer">
										<a href="'.get_permalink().'" class="pull-right">'. __('Read More', 'magee-shortcodes').' &gt;&gt;</a>
									</div>
											</div>
										</article>
									</div>
								</div>';
										
					if( $i%$column == 0 ):
						$html .= '<div class="row">'.$html_item.'</div>';
						$html_item = '';
					endif;
				
				endif;
				
				if( $style == '4' ):
				
					if( $i % 2 == 0 )
						$position = 'left';
					else
						$position = 'right';
					
					$html .= '<div class="entry-box-wrap timeline-'.$position.'">
								<article class="entry-box" role="article">
									'.$featured_image.'
									<div class="entry-main">
										<div class="entry-header">';
										
											if( $display_title == 'yes') 
												$html .= '<a href="'.get_permalink().'" style="display:block;"><h4 class="entry-title">'.get_the_title().'</h4></a>';
											
											if( $display_meta == 'yes')
												$html .=  Helper::posted_on(false, $defaults);
											
										$html .= '</div>';
										
										if( $display_excerpt == 'yes') {
										$html .= '<div class="entry-summary">';
											if( $strip == 'yes'):
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html .= strip_tags(substr(Helper::get_summary(),0, $excerpt_length)) ;
												else:
													$html .= strip_tags(Helper::get_summary()) ;
												endif;
											else:
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html .= Helper::get_summary().substring(0, $excerpt_length) ;
												else:
													$html .= Helper::get_summary() ;
												endif;
											endif;		 
										$html .= '</div>';
										}
									$html .= '</div>
								</article>
							</div>';
				endif;
				$i++;
			endwhile;
		endif;
	
		if( $html_item != '' && $style != '4' )
			$html .= '<div class="row">'.$html_item.'</div>';
		
		if($style == '4') {
			$html .= '</div></div></div>';
		}
		
		if( $page_nav == 'yes')
			$html .= '<div class="row"><div class="list-pagition text-center">'.Helper::paging_nav("", $wp_query).'</div></div>';
		$html .= '</div>';

		wp_reset_postdata();
		return $html ;	

	}
}
new Magee_Blog();