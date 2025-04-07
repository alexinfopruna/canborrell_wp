<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;

class Magee_Animation {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
		add_shortcode( 'ms_animation', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {

		Helper::get_style_depends(['animate', 'magee-shortcodes']);
		Helper::get_script_depends(['jquery-waypoints', 'magee-shortcodes']);

		$defaults = Helper::set_shortcode_defaults(
			array(
				'class'		=> '',			
				'id'		=> '',
				'animation_speed' => '0.5',
				'animation_type' => 'bounce',
				'image_animation' =>'no'
			), $args 
		);

		extract( $defaults );

		self::$args = $defaults;

		$animation = 'data-animationduration="'.$animation_speed.'" data-animationtype="'.$animation_type.'" data-imageanimation="'.$image_animation.'"';

		$html = '<div class="magee-shortcode magee-animated magee-animation '.$class.'" '.$animation.' id="'.$id.'">'.do_shortcode( Helper::fix_shortcodes($content)).'</div>';

		return $html;

	}

}

new Magee_Animation();