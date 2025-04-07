<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Magee_GoogleMap {

	private $map_id;

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'magee_attr_google-map-shortcode', array( $this, 'attr' ) );
		add_shortcode( 'ms_google_map', array( $this, 'render' ) );
       
	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '' ) {

		Helper::get_style_depends(['magee-shortcodes']);
		Helper::get_script_depends(['magee-shortcodes']);

		global $magee_options;

		$defaults = Helper::set_shortcode_defaults(
			array(
				'class'						=> '',
				'id'						=> '',
				'animation'					=> 'no',
				'address'					=> '',
				'height'					=> '300px',				
				'icon'						=> '',
				'infobox'					=> 'custom',
				'infobox_background_color'	=> '',
				'infobox_content'			=> '',
				'infobox_text_color'		=> '',
				'map_style'					=> 'custom',
				'overlay_color'				=> '',
				'popup'						=> 'yes',
				'scale'						=> 'yes',				
				'scrollwheel'				=> 'yes',				
				'type'						=> 'roadmap',
				'width'						=> '100%',
				'zoom'						=> '14',
				'zoom_pancontrol'			=> 'yes',
				'api_key'					=> '',
				'is_preview' => ''
			), $args
		);
		

		extract( $defaults );
		
		if( $api_key == '' )
			$api_key = isset($magee_options['magee_gmap_api'])?$magee_options['magee_gmap_api']:'';
		
		$api_key = apply_filters('magee_gmap_api', $api_key);

		self::$args = $defaults;
        $map_api = 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://maps.googleapis.com/maps/api/js?key='.trim($api_key).'&amp;language=' . substr(get_locale(), 0, 2);
		wp_enqueue_script( 'google-maps-api', $map_api, array(), '', false );
		wp_enqueue_script( 'google-maps-infobox', MAGEE_SHORTCODES_URL.'assets/js/infobox.js', array(), '', false);
		wp_enqueue_script( 'magee-map',MAGEE_SHORTCODES_URL.'assets/js/jquery.magee_maps.js', array('jquery'), '', false);

		$html = '';
		if( $address ) {
			$addresses = explode( '|', $address );
			
			if( $addresses ) {
				self::$args['address'] = $addresses;
			}
			
			$num_of_addresses = count( $addresses );			

			if( $infobox_content ) {
				$infobox_content_array = explode( '|', $infobox_content );
			} else {
				$infobox_content_array = '';
			}
			
			if( $icon ) {
				$icon_array = explode( '|', $icon );
			} else {
				$icon_array = '';
			}		
		
			if( $map_style == 'theme' ) {
				$map_style = 'custom';
				$icon = 'theme';
				$animation = 'yes';
				$infobox = 'custom';
				$infobox_background_color = Helper::hex2rgb( $magee_options['scheme'] );
				$infobox_background_color = 'rgba(' . $infobox_background_color[0] . ', ' . $infobox_background_color[1] . ', ' . $infobox_background_color[2] . ', 0.8)';
				$overlay_color = $magee_options['scheme'];
				$brightness_level = Helper::calc_color_brightness( $magee_options['scheme'] );

				if( $brightness_level > 140 ) {
					$infobox_text_color = '#fff';
				} else {
					$infobox_text_color = '#747474';
				}				
			}
			
			// If only one custom icon is set, use it for all markers
			if ( $map_style == 'custom' && $icon && $icon != 'theme' && $icon_array && count( $icon_array ) == 1 ) {
				$icon_url = $icon_array[0];
				for ( $i = 0; $i < $num_of_addresses; $i++ ) {
					$icon_array[$i] = $icon_url;				
				}
			}				
			
			if( $icon == 'theme' && $map_style == 'custom' ) {
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					$icon_array[$i] = MAGEE_SHORTCODES_URL. 'assets/images/map_marker.png';				
				}
			}			

			// wp_print_scripts( 'google-maps-api' );
			// wp_print_scripts( 'google-maps-infobox' );
			// wp_print_scripts( 'magee-map' );
			

			foreach( self::$args['address'] as $add ) {

				$add = trim( $add );
				$add_arr = explode( "\n", $add );
				$add_arr = array_filter( $add_arr, 'trim' );
				$add = implode( '<br/>', $add_arr );
				$add = str_replace( "\r", '', $add );
				$add = str_replace( "\n", '', $add );

				$coordinates[]['address'] = $add;
			}

			if( ! is_array( $coordinates ) ) {
				return;
			}
			
			for( $i = 0; $i < $num_of_addresses; $i++ ) {
				if( strpos( self::$args['address'][$i], 'latlng=' ) === 0 ) {
					self::$args['address'][$i] = $coordinates[$i]['address'];
				}
			}
			
			if( is_array( $infobox_content_array ) && 
				! empty( $infobox_content_array ) 
			) {
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					if( ! array_key_exists( $i, $infobox_content_array ) ) {
						$infobox_content_array[$i] = self::$args['address'][$i];
					}
				}
				self::$args['infobox_content'] = $infobox_content_array;
			} else {
				self::$args['infobox_content'] = self::$args['address'];
			}

			$cached_addresses = get_option( 'magee_map_addresses' );

			foreach( self::$args['address'] as $key => $address ) {
				$json_addresses[] = array(
					'address' => $address,
					'infobox_content' => self::$args['infobox_content'][$key]
				);

				if( isset( $icon_array ) && is_array( $icon_array ) ) {
					$json_addresses[$key]['marker'] = $icon_array[$key];
				}

				if( strpos( $address, strtolower( 'latlng=' ) ) !== false ) {
					$json_addresses[$key]['address'] = str_replace( 'latlng=', '', $address );
					$latLng = explode(',', $json_addresses[$key]['address']);
					$json_addresses[$key]['coordinates'] = true;
					$json_addresses[$key]['latitude'] = $latLng[0];
					$json_addresses[$key]['longitude'] = $latLng[1];
					$json_addresses[$key]['cache'] = false;

					if( strpos( self::$args['infobox_content'][$key], strtolower( 'latlng=' ) ) !== false ) {
						$json_addresses[$key]['infobox_content'] = '';
					}

					if( isset( $cached_addresses[ trim( $json_addresses[$key]['latitude'] . ',' . $json_addresses[$key]['longitude'] ) ] ) ) {
						$json_addresses[$key]['geocoded_address'] = $cached_addresses[ trim( $json_addresses[$key]['latitude'] . ',' . $json_addresses[$key]['longitude'] ) ]['address'];
						$json_addresses[$key]['cache'] = true;
					}
				} else {
					$json_addresses[$key]['coordinates'] = false;
					$json_addresses[$key]['cache'] = false;

					if( isset( $cached_addresses[ trim( $json_addresses[$key]['address'] ) ] ) ) {
						$json_addresses[$key]['latitude'] = $cached_addresses[ trim( $json_addresses[$key]['address'] ) ]['latitude'];
						$json_addresses[$key]['longitude'] = $cached_addresses[ trim( $json_addresses[$key]['address'] ) ]['longitude'];
						$json_addresses[$key]['cache'] = true;					
					}
				}
			}

			$json_addresses = json_encode( $json_addresses );

			$map_id = Utils::rand_str( 'magee_map_' ); // generate a unique ID for this map
			$this->map_id = $map_id;

			$script = "
			   var map_".$map_id.";
				var markers = [];
				var counter = 0;
				function magee_run_map_".$map_id."() {
					jQuery('#".$map_id."').magee_maps({
						addresses: ".$json_addresses.",
						animations: ".(($animation == 'yes') ? 'true' : 'false').",
						infobox_background_color: '".$infobox_background_color."',
						infobox_styling: '".$infobox."',
						infobox_text_color: '".$infobox_text_color."',
						map_style: '".$map_style."',
						map_type: '".$type."',
						marker_icon: '".$icon."',
						overlay_color: '".$overlay_color."',
						overlay_color_hsl: ".json_encode( Helper::rgb2hsl( $overlay_color ) ).",
						pan_control: ".(($zoom_pancontrol == 'yes') ? 'true' : 'false').",
						show_address: ".(($popup == 'yes') ? 'true' : 'false').",
						scale_control: ".(($scale == 'yes') ? 'true' : 'false').",
						scrollwheel: ".(($scrollwheel == 'yes') ? 'true' : 'false').",
						zoom: ".$zoom.",
						zoom_control: ".(($zoom_pancontrol == 'yes') ? 'true' : 'false').",
					});
				}
				google.maps.event.addDomListener(window, 'load', magee_run_map_".$map_id.");	
			";
			
			if( $defaults['id'] ) {
				$html .= sprintf( '<div id="%1$s"><div %2$s></div></div>', $defaults['id'], Helper::attributes( 'google-map-shortcode' ) );
			} else {
				$html .= sprintf( '<div %s></div>', Helper::attributes( 'google-map-shortcode' ) );
			}
		}
		
		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$is_preview = "1";
		}

		if ($is_preview == "1"){
			$html = sprintf( '%1$s<script>%2$s</script>', $html, $script);
		}else{
			wp_add_inline_script('magee-map', $script, 'after');
		}

		return $html;
	}

	function attr() {
	
		$attr['class'] = 'magee-shortcode shortcode-map magee-google-map';

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		$attr['id'] = $this->map_id;
		
		$attr['style'] = sprintf('height:%1$s;width:%2$s;',  self::$args['height'], self::$args['width'] );

		return $attr;
	}

}

new Magee_GoogleMap();