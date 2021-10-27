<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package ARGPD
 * @subpackage Settings
 * @since 0.0.0
 *
 * @author César Maeso <info@superadmin.es>
 *
 * @copyright (c) 2018, César Maeso (https://superadmin.es)
 */

/**
 * Settings class.
 *
 * @since  0.0.0
 */
class ARGPD_Settings {


	/**
	 * Parent plugin class.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Property key
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $key = 'argpd';

	/**
	 * Property themes
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $informbox_themes = null;

	/**
	 * Property themes
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $cookie_themes = null;

	/**
	 * Property countries
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $countries = null;

	/**
	 * Property states
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $states = null;


	/**
	 * Property settings array
	 *
	 * @var    string
	 * @since  1.2
	 */
	const SETTINGS = array(
		'renuncia'                     => 0,
		// pages.
		'avisolegalID'                 => 0,
		'privacidadID'                 => 0,
		'cookiesID'                    => 0,
		'custom-cookies-page-id'       => 0,
		'avisolegalURL'                => '',
		'privacidadURL'                => '',
		'cookiesURL'                   => '',
		'custom-cookies-page-url'      => '',
		'avisolegal-disabled'          => 0,
		'cookies-disabled'             => 0,
		'privacidad-disabled'          => 0,
		'custom-cookies-page-disabled' => 0,
		'cookies-label'             => '',
		'cookies-btnlabel'          => '',
		'cookies-rejectlabel'       => '',
		'cookies-linklabel'         => '',
		'cookies-theme'             => 'modern-light',
		'cookies-unconsent'         => 0,
		'cookies-reload'            => 0,
		'cookies-fixed'             => 0,
		'consentimiento-label'      => '',
		'informbox-theme'           => 'simple',
		'robots-index'              => 0,
		'is-ssl'                    => 0,
		// owner.
		'dominio'                   => '',
		'titular'                   => '',
		'id-fiscal'                 => '',
		'id-fiscal-nombre'          => 'NIF',
		'colegio'                   => '',
		'mercantil-ciudad'          => '',
		'mercantil-tomo'            => '',
		'mercantil-libro'           => '',
		'mercantil-folio'           => '',
		'mercantil-seccion'         => '',
		'mercantil-hoja'            => '',
		'mercantil-inscripcion'     => '',
		'domicilio'                 => '',
		'provincia'                 => '',
		'provincia-code'            => '',
		'pais'                      => 'ES',
		'pais-nombre'               => '',
		'pais-ue'                   => 1,
		'correo'                    => '',
		'telefono'                  => '',
		'es-empresa'                => 0,
		'es-tienda'                 => 0,
		'edad-ue'                   => 18,
		'edad-otros'                => 13,
		// settings.
		'finalidad'                 => '',
		'hosting-info'              => '',
		// options.
		'option-comments'           => 0,
		'option-cookies'            => 0,
		'option-forms'              => 0,
		'option-footer'             => 0,
		// clauses.
		'clause-exclusion'          => 0,
		'clause-thirdparty'         => 0,
		'clause-edad'               => 0,
		'clause-terceros'           => 0,
		'clause-protegidos'         => 0,
		'clause-portabilidad'       => 0,
		'clause-fuero'              => 1,
		'clause-errores'            => 1,
		'thirdparty-dclick'         => 0,
		'thirdparty-adsense'        => 0,
		'thirdparty-advertising'    => 0,
		'thirdparty-analytics'      => 0,
		'thirdparty-ganalytics'     => 0,
		'thirdparty-fanalytics'     => 0,
		'thirdparty-social'         => 0,
		'thirdparty-mailchimp'      => 0,
		'thirdparty-mailerlite'     => 0,
		'thirdparty-mailrelay'      => 0,
		'thirdparty-amazon'         => 0,
		'thirdparty-sendinblue'     => 0,
		'thirdparty-mailpoet'       => 0,
		'thirdparty-activecampaign' => 0,
		'thirdparty-getresponse'    => 0,
		// first layer privacy statement
		'purpose'           		=> '',
		'communication'       		=> '',
		'legitimacy' 				=> '',
		// 
		'lista-cookies'             => '',
		'scripts-reject'            => '',
		// WooCommerce
		// Control para la visualización de la capa informativa en el carrito de compra.
		'option-wc-top-layer'		=> 0,
		// Control para la visualización del consentimiento promocional.
		'option-wc-promo'		    => 0,
		// Mensaje para el consentimiento promocional.
		'wc-consent-promo'   		=> '',
	);


	/**
	 * Property settings array
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $settings = array();


	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {

		$this->informbox_themes = array(
			'simple'        => __( 'Simple', 'argpd' ),
			'border'        => __( 'Con borde', 'argpd' ),
			'border-number' => __( 'Borde + Números', 'argpd' ),
			'in-line'       => __( 'Compacto en una línea', 'argpd' ),
			'hidden'        => __( 'Compacto con botón ver más', 'argpd' ),
		);

		$this->cookie_themes = array(
			'classic'      => __( 'Clásico', 'argpd' ),
			'classic-top'  => __( 'Clásico en parte superior', 'argpd' ),
			'modern-light' => __( 'Moderno Claro', 'argpd' ),
			'modern-dark'  => __( 'Moderno Oscuro', 'argpd' ),
			'modern-flex'  => __( 'Moderno en columnas', 'argpd' ),
		);


		$this->countries = array(
			'AR' => __( 'Argentina', 'argpd' ),
			'AD' => __( 'Andorra', 'argpd' ),
			'DE' => __( 'Alemania', 'argpd' ),
			'AT' => __( 'Austria', 'argpd' ),
			'BE' => __( 'Bélgica', 'argpd' ),
			'BG' => __( 'Bulgaria', 'argpd' ),
			'BU' => __( 'Bolivia', 'argpd' ),
			'BR' => __( 'Brasil', 'argpd' ),
			'CA' => __( 'Canadá', 'argpd' ),
			'CO' => __( 'Colombia', 'argpd' ),
			'CL' => __( 'Chile', 'argpd' ),
			'CR' => __( 'Costa Rica', 'argpd' ),
			'CY' => __( 'Chipre', 'argpd' ),
			'CU' => __( 'Cuba', 'argpd' ),
			'DK' => __( 'Dinamarca', 'argpd' ),
			'EC' => __( 'Ecuador', 'argpd' ),
			'SV' => __( 'El Salvador', 'argpd' ),
			'SK' => __( 'Eslovaquia', 'argpd' ),
			'SI' => __( 'Eslovenia', 'argpd' ),
			'EE' => __( 'Estonia', 'argpd' ),
			'ES' => __( 'España', 'argpd' ),
			'US' => __( 'Estados Unidos', 'argpd' ),
			'FI' => __( 'Finlandia', 'argpd' ),
			'FR' => __( 'Francia', 'argpd' ),
			'GR' => __( 'Grecia', 'argpd' ),
			'GT' => __( 'Guatemala', 'argpd' ),
			'HT' => __( 'Haití', 'argpd' ),
			'HN' => __( 'Honduras', 'argpd' ),
			'HU' => __( 'Hungría', 'argpd' ),
			'IT' => __( 'Italia', 'argpd' ),
			'IE' => __( 'Irlanda', 'argpd' ),
			'LV' => __( 'Letonia', 'argpd' ),
			'LT' => __( 'Lituania', 'argpd' ),
			'LU' => __( 'Luxemburgo', 'argpd' ),
			'MT' => __( 'Malta', 'argpd' ),
			'MX' => __( 'México', 'argpd' ),
			'NI' => __( 'Nicaragua', 'argpd' ),
			'NL' => __( 'Países Bajos', 'argpd' ),
			'PE' => __( 'Perú', 'argpd' ),
			'PA' => __( 'Panamá', 'argpd' ),
			'PY' => __( 'Paraguay', 'argpd' ),
			'PL' => __( 'Polonia', 'argpd' ),
			'PT' => __( 'Portugal', 'argpd' ),
			'GB' => __( 'Reino Unido', 'argpd' ),
			'CZ' => __( 'República Checa', 'argpd' ),
			'DO' => __( 'República Dominicana', 'argpd' ),
			'RO' => __( 'Rumania', 'argpd' ),
			'SE' => __( 'Suecia', 'argpd' ),
			'RU' => __( 'Federación Rusa', 'argpd' ),
			'CH' => __( 'Confederación Suiza', 'argpd' ),
			'UY' => __( 'Uruguay', 'argpd' ),
			'VE' => __( 'Venezuela', 'argpd' ),
		);

		$this->plugin = $plugin;

		$this->init_settings();
	}


	/**
	 * Init settings.
	 *
	 * @since  0.0.0
	 */
	public function init_settings() {

		$this->settings = self::SETTINGS;

		$network_id = null;
		if ( is_multisite() ) {
			$network_id = get_current_blog_id();
		}

		// get all settings.
		$options = get_network_option( $network_id, sprintf( '%s_%s', $this->key, 'settings' ) );
		if ( $options ) {
			foreach ( $options as $name => $value ) {
				$this->settings[ $name ] = $value;
			}
		} else {
			// delete old options.
			foreach ( $this->settings as $name => $value ) {
				$existing = get_network_option( $network_id, sprintf( '%s_%s', $this->key, $name ) );
				$this->update_setting( $name, $existing );
				delete_network_option( $network_id, sprintf( '%s_%s', $this->key, $name ) );
			}
		}

		// Obtener la dirección del sitio web.
		$dominio = $this->settings['dominio'];
		$this->settings['dominio'] = esc_url( strlen( $dominio ) == 0 ? get_site_url() : $dominio );

		// Obtener las paginas legales y los permalinks.
		$cookies_id = intval( $this->settings['cookiesID'] );
		if ( is_int( $cookies_id ) && $cookies_id > 0 ) {
			$this->settings['cookiesURL'] = get_permalink( $cookies_id );
		} else {
			$this->settings['cookiesURL'] = '';
		}

		$this->settings['avisolegalURL'] = '';
		$avisolegal_id = intval( $this->settings['avisolegalID'] );
		if ( is_int( $avisolegal_id ) && $avisolegal_id > 0 ) {
			$this->settings['avisolegalURL'] = get_permalink( $avisolegal_id );
		}

		$this->settings['privacidadURL'] = '';
		$privacidad_id = intval( $this->settings['privacidadID'] );
		if ( is_int( $privacidad_id ) && $privacidad_id > 0 ) {
			$this->settings['privacidadURL'] = get_permalink( $privacidad_id );
		}

		$this->settings['custom-cookies-page-url'] = '';
		$custom_cookies_page_id = intval( $this->settings['custom-cookies-page-id'] );
		if ( is_int( $custom_cookies_page_id ) && $custom_cookies_page_id > 0 ) {
			$this->settings['custom-cookies-page-url'] = get_permalink( $custom_cookies_page_id );
		}

		// scripts-reject.
		if ( is_string( $this->settings['scripts-reject'] ) && strlen( $this->settings['scripts-reject'] ) ) {
			$this->settings['scripts-reject'] = explode( ',', $this->settings['scripts-reject'] );
		}

		// configure cookies-btnlabel default value.
		if ( ! strlen( $this->settings['cookies-btnlabel'] ) ) {
			$this->settings['cookies-btnlabel'] = __( 'Aceptar', 'argpd' );
		}

		if ( ! strlen( $this->settings['cookies-rejectlabel'] ) ) {
			$this->settings['cookies-rejectlabel'] = __( 'Rechazar', 'argpd' );
		}

		// configure cookies-linklabel default value.
		if ( ! strlen( $this->settings['cookies-linklabel'] ) ) {
			$this->settings['cookies-linklabel'] = __( 'Configurar y más información', 'argpd' );
			if ( $custom_cookies_page_id > 0 ) {
				$this->settings['cookies-linklabel'] = __( 'Más información', 'argpd' );
			}
		}

		// default 'edad' setting.
		if ( ! strlen( $this->settings['edad-ue'] ) ) {
			$this->settings['edad-ue'] = self::SETTINGS['edad-ue'];
		}

		if ( ! strlen( $this->settings['edad-otros'] ) ) {
			$this->settings['edad-otros'] = self::SETTINGS['edad-otros'];
		}

		if ( $this->settings['thirdparty-adsense'] || $this->settings['thirdparty-amazon'] || $this->settings['thirdparty-dclick'] ) {
			$this->settings['thirdparty-advertising'] = 1;
		}

		if ( $this->settings['thirdparty-fanalytics'] || $this->settings['thirdparty-ganalytics'] ) {
			$this->settings['thirdparty-analytics'] = 1;
		}

		if ( $this->settings['thirdparty-advertising'] || $this->settings['thirdparty-analytics'] ) {
			$this->settings['clause-thirdparty'] = 1;
		}

		// variables según el país.
		$this->convert_regional_codes();

		// configure wc-consent-promo default value.
		if ( ! strlen( $this->settings['wc-consent-promo'] ) ) {
			$this->settings['wc-consent-promo'] = __( 'Acepto recibir ofertas, noticias y otras recomendaciones sobre productos o servicios', 'argpd' );
		}

		// Registra si el sitio web tiene SSL activado
		if ( is_ssl() ) {
			$this->settings['is-ssl'] = 1;
		}
	}

	/**
	 * Convert_regional_codes
	 *
	 * @since  0.0.0
	 */
	private function convert_regional_codes() {

		if ( strlen( $this->settings['pais'] ) == 0 ) {
			$this->settings['pais'] = 'ES';
		}

		// convert cc2 to string.
		$cc2 = $this->settings['pais'];

		foreach ( $this->countries as $key => $value ) {
			if ( $key == $cc2 ) {
				$this->settings['pais-nombre'] = $value;
			}
		}

		// ¿es un país europeo?.
		$this->settings['pais-ue'] = ( in_array( $cc2, array( 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' ), true ) ) ? 1 : 0;

		// convert state-cc2 to string.
		$state_code = $this->settings['provincia-code'];
		$states     = $this->get_states( $cc2 );
		foreach ( $states as $i ) {
			if ( $i['code'] == $state_code ) {
				$this->settings['provincia'] = $i['name'];
			}
		}

		// Documento de identidad.
		switch ( $this->settings['pais'] ) {
			case 'AR':
			case 'PE':
				$this->settings['id-fiscal-nombre'] = 'Documento Nacional de Identidad';
				break;
			case 'CO':
				$this->settings['id-fiscal-nombre'] = 'NIT';
			case 'EC':
				$this->settings['id-fiscal-nombre'] = 'Cédula de ciudadanía';
				break;
			case 'VE':
			case 'BO':
			case 'CH':
			case 'CR':
			case 'NI':
			case 'UY':
				$this->settings['id-fiscal-nombre'] = 'Cédula de identidad';
				break;
			case 'PA':
				$this->settings['id-fiscal-nombre'] = 'Cédula de identidad personal';
				break;
			default:
				$this->settings['id-fiscal-nombre'] = 'NIF';
		}
	}

	/**
	 * Reset settings.
	 *
	 * @since  0.0.0
	 */
	public function reset() {
		$this->update_setting( 'clause-exclusion', 0 );
		$this->update_setting( 'clause-terceros', 0 );
		$this->update_setting( 'clause-edad', 0 );
		$this->update_setting( 'clause-protegidos', 0 );
		$this->update_setting( 'clause-portabilidad', 0 );
		$this->update_setting( 'clause-fuero', 0 );
		$this->update_setting( 'clause-errores', 0 );

		$this->update_setting( 'thirdparty-dclick', 0 );
		$this->update_setting( 'thirdparty-advertising', 0 );
		$this->update_setting( 'thirdparty-adsense', 0 );
		$this->update_setting( 'thirdparty-analytics', 0 );
		$this->update_setting( 'thirdparty-ganalytics', 0 );
		$this->update_setting( 'thirdparty-fanalytics', 0 );
		$this->update_setting( 'thirdparty-social', 0 );
		$this->update_setting( 'thirdparty-mailchimp', 0 );
		$this->update_setting( 'thirdparty-mailrelay', 0 );
		$this->update_setting( 'thirdparty-amazon', 0 );
		$this->update_setting( 'thirdparty-sendinblue', 0 );
		$this->update_setting( 'thirdparty-mailpoet', 0 );
		$this->update_setting( 'thirdparty-activecampaign', 0 );
		$this->update_setting( 'thirdparty-getresponse', 0 );
		$this->update_setting( 'thirdparty-mailerlite', 0 );

		$this->update_setting( 'es-tienda', 0 );

		$this->update_setting( 'option-wc-top-layer', 0 );
		$this->update_setting( 'option-wc-promo', 0 );
		// $this->settings = self::SETTINGS;
	}


	/**
	 * Returns all settings
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Returns themes
	 *
	 * @return array
	 */
	public function get_cookie_themes() {
		return $this->cookie_themes;
	}

	/**
	 * Returns themes
	 *
	 * @return array
	 */
	public function get_informbox_themes() {
		return $this->informbox_themes;
	}

	/**
	 * Returns countries
	 *
	 * @return array
	 */
	public function get_countries() {
		return $this->countries;
	}


	/**
	 * Returns states
	 *
	 * @param  string $country country.
	 * @return array
	 */
	public function get_states( $country ) {

		$fn = sprintf( '%s/../assets/json/%s.json', dirname( __FILE__ ), strtolower( $country ) );
		if ( file_exists( $fn ) ) {
			$str  = file_get_contents( $fn );
			$json = json_decode( $str, true );

			// catch error.
			if ( null === $json && JSON_ERROR_NONE !== json_last_error() ) {
				return array();
			}

			$states = array();
			foreach ( $json as $state ) {
				array_push(
					$states,
					array(
						'name' => $state['name'],
						'code' => $state['code'],
					)
				);
			}
			return $states;
		}

		return array();
	}


	/**
	 * Returns the value of given setting key, based on if network settings are enabled or not
	 *
	 * @param string $name Setting to fetch.
	 * @param string $default Default Value.
	 *
	 * @return bool|mixed|void
	 */
	public function get_setting( $name = '', $default = false ) {

		if ( empty( $name ) ) {
			return false;
		}

		return $this->settings[ $name ];
	}

	/**
	 * Update value for given setting key
	 *
	 * @param string $name Key.
	 * @param string $value Value.
	 *
	 * @return bool If the setting was updated or not
	 */
	public function update_setting( $name = '', $value = '', $type = 'text_field' ) {

		if ( empty( $name ) ) {
			return false;
		}

		$network_id = null;
		if ( is_multisite() ) {
			$network_id = get_current_blog_id();
		}

		switch ( $type ) {
			case 'kses_data':
				$value = wp_kses_data( $value );
				break;
			case 'textarea_field':
				$value = trim( sanitize_textarea_field( $value ) );
				break;
			default:
				$value = trim( sanitize_text_field( $value ) );
		}

		// $value = trim ( ( $textarea ) ? sanitize_textarea_field( $value ) : sanitize_text_field( $value ) );
		$old_settings = $this->settings;

		$this->settings[ $name ] = $value;
		( 'provincia-code' == $name || 'pais' == $name ) && $this->convert_regional_codes();

		if ( update_network_option( $network_id, sprintf( '%s_%s', $this->key, 'settings' ), $this->settings ) ) {
			return true;
		} else {
			// restaurar viejos settings.
			$this->settings = $old_settings;
		}
		return false;
	}
}
