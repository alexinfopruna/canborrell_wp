<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;

class Magee_Imagebanner {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_image_banner', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		Helper::get_style_depends(['magee-shortcodes']);

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'horizontal_align' =>'center', //left/center/right
				'vertical_align' => 'middle',  //top/middle/bottom 
				'zoom_effect' => 'in', // in/out
				'image' =>'',
				'link'=>'',
				'target'=>'_blank'
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		
		$class .= ' magee-shortcode magee-image-banner';
		$text_align = '';
		switch( $horizontal_align ){
			case "center":
			$text_align = 'text-center';
			break;
			case "left":
			$text_align = 'text-left';
			break;
			case "right":
			$text_align = 'text-right';
			break;
			
			}
		$html = '';
		if( $image != '' ):
		
			$image = $link == ''? '<img src="'.esc_url($image).'" class="feature-img">':'<a href="'.esc_url($link).'" target="'.esc_attr($target).'"><img src="'.esc_url($image).'" class="feature-img">';
			
			$html = '<div class="img-box figcaption-'.$vertical_align.' '.$text_align.' img-zoom-'.$zoom_effect.'">
													'.$image.'
													<div class="img-overlay">
														<div class="img-overlay-container">
															<div class="img-overlay-content">
															'.do_shortcode( Helper::fix_shortcodes($content)).'
															</div>
														</div>
													</div>  '.($link == ''?'':'</a>').'                                                 
												</div>';

			$html = sprintf('<div id="%1$s" class="%2$s">%3$s</div>', $id, $class, $html);
		endif;
  	
		return $html;
	}
	
}

new Magee_Imagebanner();