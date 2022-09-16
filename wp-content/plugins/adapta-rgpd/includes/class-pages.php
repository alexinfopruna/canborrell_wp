<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package ARGPD
 * @subpackage Pages
 * @since 0.0.0
 *
 * @author César Maeso <info@superadmin.es>
 *
 * @copyright (c) 2018, César Maeso (https://superadmin.es)
 */

/**
 * Pages class.
 *
 * @since  0.0.0
 */
class ARGPD_Pages {

	/**
	 * Parent plugin class.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Parent plugin class.
	 *
	 * @var    class
	 * @since  0.0.0
	 */
	protected $compiler = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {

		// set parent plugin.
		$this->plugin = $plugin;

		// Init mustache.
		if ( ! class_exists( 'Mustache_Autoloader' ) ) {
			require_once dirname( __FILE__ ) . '/../lib/vendor/Mustache/Autoloader.php';
			Mustache_autoloader::register();
		}

		// Init template engine.
		$this->compiler = new Mustache_Engine(
			array(
				'loader' => new Mustache_Loader_FilesystemLoader( dirname( __FILE__ ) . '/../views' ),
				'helpers' => [
					'__' => function($text){
						return esc_html__($text, 'argpd');
					},
				],
			)
		);

		// initiate our hooks.
		$this->hooks();
	}


	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

		// create shortcodes for main views.
		add_shortcode(
			'argpd_aviso-legal',
			function() {
				return $this->render_legal_notice_page(true);
			}
		);

		add_shortcode(
			'argpd_politica-cookies',
			function() {
				return $this->politica_cookies(true);
			}
		);

		add_shortcode(
			'argpd_politica-privacidad',
			function() {
				return $this->politica_privacidad(true);
			}
		);

		add_shortcode(
			'argpd_preferencias-cookies',
			function() {
				return $this->custom_cookies_page_render(true);
			}
		);

		add_shortcode(
			'argpd_consentimiento',
			function() {
				return $this->consentimiento_view();
			}
		);

		add_shortcode(
			'argpd_deber_de_informar',
			function( $atts = [] ) {
				$purpose = isset( $atts['finalidad'] ) ? $atts['finalidad'] : null;
				$communication = isset( $atts['destinatarios'] ) ? $atts['destinatarios'] : null;
				$legitimacy = isset( $atts['legitimacion'] ) ? $atts['legitimacion'] : null;
				return $this->first_layer_privacy_view( $purpose, $communication, $legitimacy );
			}
		);

		// filter legal pages.
		add_filter(
			'the_content',
			function( $content ) {

				$page_id  = get_the_ID();
				if ( 0 == $page_id ) {
					return $content;
				}

				$settings = $this->plugin->argpd_settings->get_settings();
				switch ( $page_id ) {
					case $settings['avisolegalID']:
						$content = $this->render_legal_notice_page() . $content;
						break;
					case $settings['privacidadID']:
						$content = $this->politica_privacidad() . $content;
						break;
					case $settings['cookiesID']:
						$content = $this->politica_cookies() . $content;
						break;
					case $settings['custom-cookies-page-id']:
						$content = $this->custom_cookies_page_render() . $content;
						break;
					default:
						break;
				}
				return $content;
			}
		);
	}


	/**
	 * Create Legal Pages
	 *
	 * @since  0.0.0
	 */
	public function create_all() {
		$this->create_legal_page();
		$this->create_privacy_page();
		$this->create_cookies_page();
		$this->create_custom_cookies_page();
	}

	/**
	 * Create legal page
	 *
	 * @since  1.0.1
	 */
	public function create_legal_page() {
		$id = $this->create_page( 'Aviso Legal' );
		( 0 != $id ) && $this->plugin->argpd_settings->update_setting( 'avisolegalID', $id );
		return $id;
	}

	/**
	 * Create privacy page
	 *
	 * @since  1.0.1
	 */
	public function create_privacy_page() {
		$id = $this->create_page( 'Política de Privacidad' );
		( 0 != $id ) && $this->plugin->argpd_settings->update_setting( 'privacidadID', $id );
		return $id;
	}

	/**
	 * Create cookies page
	 *
	 * @since  1.0.1
	 */
	public function create_cookies_page() {
		$id = $this->create_page( 'Política de Cookies' );
		( 0 != $id ) && $this->plugin->argpd_settings->update_setting( 'cookiesID', $id );
		return $id;
	}

	/**
	 * Crear la página para personalizar cookies.
	 *
	 * @since  1.3
	 */
	public function create_custom_cookies_page() {
		$id = $this->create_page( 'Personalizar Cookies' );
		( 0 != $id ) && $this->plugin->argpd_settings->update_setting( 'custom-cookies-page-id', $id );
		return $id;
	}

	/**
	 * Create Page by Name
	 *
	 * @param string $name page title.
	 *
	 * @return int the page_id if created else 0
	 */
	public function create_page( $name ) {

		if ( ! get_page_by_title( $name ) ) {
			$page = array(
				'post_content' => '',
				'post_title'   => $name,
				'post_status'  => 'publish',
				'post_parent'  => 0,
				'post_type'    => 'page',
			);

			return wp_insert_post( $page );
		}
		return 0;
	}


	/**
	 * Echo "Aviso Legal" page
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function render_legal_notice_page($check_disabled=false) {
		$settings = $this->plugin->argpd_settings->get_settings();
		$settings['site-url'] = get_site_url();
		if ( $check_disabled || ! $settings['avisolegal-disabled'] ) {
			return $this->compiler->render( 'page-legal-notice', $settings );
		}
	}

	/**
	 * Echo Disclaimer page
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function disclaimer() {
		return $this->compiler->render( 'tab-disclaimer', null );
	}

	/**
	 * Echo "Politica de cookies" page
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function politica_cookies($check_disabled=false) {

		$settings = $this->plugin->argpd_settings->get_settings();

		if ( $check_disabled || ! $settings['cookies-disabled'] ) {
			//$settings['cookies-html'] = nl2br ( esc_textarea( $settings[ 'lista-cookies'] ) );
			$settings['cookies-html'] =  nl2br ( $settings[ 'lista-cookies'] );
			return $this->compiler->render( 'page-cookies-policy', $settings );
		}
	}

	/**
	 * Echo "Politica de privacidad" page
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function politica_privacidad($check_disabled=false){
		$settings = $this->plugin->argpd_settings->get_settings();
		// controles utilizados en el template.
		$settings['procedimientosderecogida-control'] = ( 
			$settings['option-forms']  				||
			$settings['option-comments']  			||
			$settings['thirdparty-mailchimp']  		||
			$settings['thirdparty-sendinblue']  	||
			$settings['thirdparty-mailpoet']  		||
			$settings['thirdparty-activecampaign'] 	||
			$settings['thirdparty-mailerlite'] );

		if ( $check_disabled || ! $settings['privacidad-disabled'] ) {
			return $this->compiler->render( 'page-privacy-policy', $settings );
		}
	}

	/**
	 * Crea el contenido de la página de personalización de cookies.
	 *
	 * @since  1.3
	 * @return string
	 */
	public function custom_cookies_page_render($check_disabled=false) {
		$settings = $this->plugin->argpd_settings->get_settings();


		if ( isset( $_COOKIE['hasConsents'] ) ) {
			$has_consents = wp_kses_data( $_COOKIE['hasConsents'] );
			$consents = explode( " ", $has_consents );
			if ( in_array("ANLTCS", $consents) ){
				$settings['consent-analytics'] = true;
			}		

			if ( in_array("SCLS", $consents) ){
				$settings['consent-social'] = true;
			}
		}

		if ( $check_disabled || ! $settings['custom-cookies-page-disabled'] ) {
			return $this->compiler->render( 'page-custom-cookies', $settings );
		}
	}


	/**
	 * Echo "consentimiento" View
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function consentimiento_view() {
		$settings = $this->plugin->argpd_settings->get_settings();
		return $this->compiler->render( 'statement-consent-privacy', $settings );
	}


	/**
	 * Echo "Deber de informar" View
	 *
	 * @since  0.0.0
	 * @param  string $purpose valor personalizado para el campo finalidad.
	 * @param  string $communication valor personalizado para el campo destinatarios.
	 * @param  string $legitimacy valor personalizado para el campo base legal de legitimación.
	 * @return string
	 */
	public function first_layer_privacy_view( $purpose = null, $communication = null, $legitimacy = null ) {
		$settings = $this->plugin->argpd_settings->get_settings();

		if ( isset( $purpose ) ) {
			$settings['purpose'] = trim( sanitize_text_field( $purpose ) );
		}

		if ( isset( $communication ) ) {
			$settings['communication'] = trim( sanitize_text_field( $communication ) );
		}

		if ( isset( $legitimacy ) ) {
			$settings['legitimacy'] = trim( sanitize_text_field( $legitimacy ) );
		}

		return $this->compiler->render( 'statement-first-layer-privacy', $settings );
	}


	/**
	 * Render Help Page
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function help_tab_view() {
		$settings = array(
			'url' => $this->plugin->url,
		);
		return $this->compiler->render( 'tab-help', $settings );
	}

	/**
	 * Echo cookies banner
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function cookiesbanner_view() {
		$settings = $this->plugin->argpd_settings->get_settings();
		return $this->compiler->render( 'statement-cookie-consent', $settings );
	}



	/**
	 * Echo footer links
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function footer_links_view() {
		$settings = $this->plugin->argpd_settings->get_settings();
		return $this->compiler->render( 'statement-footer', $settings );
	}

}
