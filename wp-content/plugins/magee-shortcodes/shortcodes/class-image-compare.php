<?php
if( !class_exists('Magee_Image_Compare') ):
class Magee_Image_Compare {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_image_compare', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'style' => '',
				'percent' => '',
				'image_left' =>'',
				'image_right' =>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$unqid = uniqid( 'class-');
		$class .= $unqid;
		$html = '<div  id="'.esc_attr($id).'" class="twentytwenty-container '.esc_attr($class).'">
				  <img src="'.$image_left.'">
		          <img src="'.$image_right.'">
				</div>' ;	
		$html .= '<script>
		jQuery(function($){
			$(document).ready(function(){
			$(".'.esc_attr($class).'").twentytwenty({default_offset_pct: '.esc_attr($percent).', orientation: "'.esc_attr($style).'"});
			});	
		});
		</script>';		
		return $html;
	}
	
}

new Magee_Image_Compare();		
endif;