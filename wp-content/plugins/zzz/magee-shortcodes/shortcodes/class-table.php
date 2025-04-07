<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;

class Magee_Table {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_table', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		Helper::get_style_depends(['bootstrap', 'magee-shortcodes']);

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'style' =>'simple',
				'striped' => 'yes'
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		
		$class .= ' magee-shortcode magee-table';
		
		$table_style = ' table';
		if( $style == 'normal')
			$table_style .= ' table-bordered';
		
		if( $striped == 'yes')
			$table_style .= ' table-striped';

		$html = sprintf('<div id="%1$s" class="%2$s" data-style="%3$s">%4$s</div>', $id, $class, $table_style, do_shortcode( Helper::fix_shortcodes($content)));
		return $html;
	}
	
}

new Magee_Table();