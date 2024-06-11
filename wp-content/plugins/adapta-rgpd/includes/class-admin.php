<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package ARGPD
 * @subpackage Admin
 * @since 0.0.0
 *
 * @author César Maeso <info@superadmin.es>
 *
 * @copyright (c) 2018, César Maeso (https://superadmin.es)
 */

/**
 * Admin class.
 *
 * @since  0.0.0
 */
class ARGPD_Admin {

	/**
	 * Parent plugin class.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Plugin title
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $title = 'Adapta RGPD';

	/**
	 * Plugin menu title
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $menu_title = 'Adapta RGPD';

	/**
	 * This is the key
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $key = 'argpd';

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param string $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

		if ( ! is_admin() ) {
			return false;
		}

		// add menu page.
		add_action( 'admin_menu', array( $this, 'custom_menu' ) );

		// actions to store settings.
		add_action( 'admin_post_argpd_setup', array( $this, 'setup' ) );
		add_action( 'admin_post_argpd_pages_setup', array( $this, 'pages_setup' ) );
		add_action( 'admin_post_argpd_cookies_setup', array( $this, 'cookies_setup' ) );
		add_action( 'admin_post_argpd_disclaimer', array( $this, 'accept_disclaimer' ) );
		add_action( 'admin_post_argpd_addons_setup', array( $this, 'addons_setup' ) );
		add_action( 'admin_post_argpd_consents_setup', array( $this, 'consents_setup' ) );

		// add settings to plugin menu.
		add_filter( 'plugin_action_links_' . $this->plugin->basename, array( $this, 'plugin_add_settings_link' ) );
	}


	/**
	 * Add main menu
	 *
	 * @since  0.0.0
	 */
	public function custom_menu() {

		add_menu_page(
			$this->title,
			$this->menu_title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' ),
			'dashicons-welcome-write-blog'
		);

		add_submenu_page(
			$this->key,
			__( 'Ajustes', 'argpd' ),
			__( 'Ajustes', 'argpd' ),
			'manage_options',
			'argpd-home',
			array( $this, 'admin_page_display' )
		);

		add_submenu_page(
			$this->key,
			__( 'Consentimientos', 'argpd' ),
			__( 'Consentimientos', 'argpd' ),
			'manage_options',
			'argpd-consents',
			array( $this, 'consents_page_display' )
		);

		add_submenu_page(
			$this->key,
			__( 'Clave de API', 'argpd' ),
			__( 'Clave de API', 'argpd' ),
			'manage_options',
			'argpd-addons',
			array( $this, 'addons_page_display' )
		);

		remove_submenu_page( $this->key, $this->key );
	}


	/**
	 * Add admin user interface
	 *
	 * @since  0.0.0
	 */
	public function admin_page_display() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_ui->options_ui();
	}


	/**
	 * Add settings interface
	 *
	 * @since  1.3.5
	 */
	public function addons_page_display() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_ui->addons_ui();
	}


	/**
	 * Add consents view
	 *
	 * @since  1.3.7
	 */
	public function consents_page_display() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_ui->consents_ui();
	}


	/**
	 * Accept Disclaimer
	 *
	 * @since  0.0.0
	 */
	public function accept_disclaimer() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_settings->update_setting( 'renuncia', 1 );

		$this->plugin->pages->create_all();

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd',
					'message' => null,
				),
				admin_url( 'admin.php?page=argpd' )
			)
		);
	}

	/**
	 *
	 * Save settings from pages setup
	 *
	 * @since  0.0.0
	 */
	public function pages_setup() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_settings->update_setting( 'avisolegalID', intval( $_POST['avisolegal'] ) );
		$this->plugin->argpd_settings->update_setting( 'privacidadID', intval( $_POST['privacidad'] ) );
		$this->plugin->argpd_settings->update_setting( 'cookiesID', intval( $_POST['cookies'] ) );
		$this->plugin->argpd_settings->update_setting( 'custom-cookies-page-id', intval( $_POST['custom-cookies-page-id'] ) );

		$disabled = isset( $_POST['avisolegal-enabled'] ) ? 0 : 1;
		$this->plugin->argpd_settings->update_setting( 'avisolegal-disabled', $disabled );
		if ( $disabled ) {
			$this->plugin->argpd_settings->update_setting( 'avisolegalID', 0 );
		}

		$disabled = isset( $_POST['cookies-enabled'] ) ? 0 : 1;
		$this->plugin->argpd_settings->update_setting( 'cookies-disabled', $disabled );
		if ( $disabled ) {
			$this->plugin->argpd_settings->update_setting( 'cookiesID', 0 );
		}

		$disabled = isset( $_POST['privacidad-enabled'] ) ? 0 : 1;
		$this->plugin->argpd_settings->update_setting( 'privacidad-disabled', $disabled );
		if ( $disabled ) {
			$this->plugin->argpd_settings->update_setting( 'privacidadID', 0 );
		}

		$disabled = isset( $_POST['custom-cookies-page-enabled'] ) ? 0 : 1;
		$this->plugin->argpd_settings->update_setting( 'custom-cookies-page-disabled', $disabled );
		if ( $disabled ) {
			$this->plugin->argpd_settings->update_setting( 'custom-cookies-page-id', 0 );
		}

		$enabled = isset( $_POST['robots-index'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'robots-index', $enabled );

		$option_comments = isset( $_POST['option-comments'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-comments', $option_comments );

		$option_forms = isset( $_POST['option-forms'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-forms', $option_forms );

		$option_footer = isset( $_POST['option-footer'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-footer', $option_footer );

		$option_wc_top_layer = isset( $_POST['option-wc-top-layer'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-wc-top-layer', $option_wc_top_layer );

		$option_wc_promo = isset( $_POST['option-wc-promo'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-wc-promo', $option_wc_promo );

		$this->plugin->argpd_settings->update_setting( 'consentimiento-label', sanitize_text_field( wp_unslash ( $_POST['consentimiento-label'] ) ) );
		$this->plugin->argpd_settings->update_setting( 'wc-consent-promo', sanitize_text_field( wp_unslash ( $_POST['wc-consent-promo'] ) ) );
		$this->plugin->argpd_settings->update_setting( 'informbox-theme', sanitize_text_field( wp_unslash ( $_POST['informbox-theme'] ) ) );

		$message = 'saved';
		if ( wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd',
					'message' => $message,
				),
				admin_url( 'admin.php?page=argpd&tab=paginas' )
			)
		) ) {
			exit;
		}
	}

	/**
	 * Guardar la configuración de la pestaña Ley de Cookies.
	 *
	 * @since  0.0.0
	 */
	public function cookies_setup() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$option_cookies = isset( $_POST['option-cookies'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-cookies', $option_cookies );

		$cookies_filter_known_scripts = isset( $_POST['cookies-filter-known-scripts'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'cookies-filter-known-scripts', $cookies_filter_known_scripts );

		$cookies_reload = isset( $_POST['cookies-reload'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'cookies-reload', $cookies_reload );

		$cookies_fixed = isset( $_POST['cookies-sticky-button'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'cookies-sticky-button', $cookies_fixed );

		$cookies_settings_button = isset( $_POST['cookies-settings-button'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'cookies-settings-button', $cookies_settings_button );

		$remove_iframes = isset( $_POST['remove-iframes'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'remove-iframes', $remove_iframes );

		$this->plugin->argpd_settings->update_setting( 'lista-cookies', $_POST['cookies-list'], 'kses' );
		$this->plugin->argpd_settings->update_setting( 'cookies-linklabel', sanitize_text_field( wp_unslash( $_POST['cookies-linklabel'] ) ) );
		$this->plugin->argpd_settings->update_setting( 'cookies-btnlabel', sanitize_text_field( wp_unslash( $_POST['cookies-btnlabel'] ) ) );
		$this->plugin->argpd_settings->update_setting( 'cookies-rejectlabel', sanitize_text_field( wp_unslash( $_POST['cookies-rejectlabel'] ) ) );
		$this->plugin->argpd_settings->update_setting( 'cookies-label', wp_kses_data( $_POST['cookies-label'] ), 'kses_data' );
		$this->plugin->argpd_settings->update_setting( 'cookies-theme', sanitize_text_field( wp_unslash( $_POST['cookies-theme'] ) ) );
		
		$cookies_id = wp_unslash( $_POST['cookies-id'] );
		$this->plugin->argpd_settings->update_setting( 'cookiesID', $cookies_id > 0 ? intval( $cookies_id ) : 0 );

		// Scripts to reject.
		$scripts_reject = [];
		foreach ( $_POST as $k => &$v ) {
			if ( strpos( $k, 'scripts-reject' ) === 0 ) {
				$k = trim( sanitize_text_field( wp_unslash( $k ) ) );
				$i = substr( $k, 15 );
				array_push( $scripts_reject, $i );
			}
		}
		$this->plugin->argpd_settings->update_setting( 'scripts-reject', join( ',', $scripts_reject ) );

		$message = 'saved';
		if ( wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd',
					'message' => $message,
				),
				admin_url( 'admin.php?page=argpd&tab=cookies' )
			)
		) ) {
			exit;
		}
	}

	/**
	 * Persist addons configuration.
	 *
	 * @since  1.3.5
	 */
	public function addons_setup() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$this->plugin->argpd_settings->update_setting( 'apikey', sanitize_text_field( wp_unslash( $_POST['apikey'] ) ) );

		$message = 'saved';
		if ( wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd-addons',
					'message' => $message,
				),
				admin_url( 'admin.php?page=argpd' )
			)
		) ) {
			exit;
		}
	}

	/**
	 * Persist consents configuration.
	 *
	 * @since  1.3.7
	 */
	public function consents_setup() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		$option_store_consents = isset( $_POST['option-store-consents'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'option-store-consents', $option_store_consents );

		$message = 'saved';
		if ( wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd-consents',
					'message' => $message,
				),
				admin_url( 'admin.php?page=argpd' )
			)
		) ) {
			exit;
		}
	}

	/**
	 *
	 * Save settings from setup
	 *
	 * @since  0.0.0
	 */
	public function setup() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'argpd' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'argpd' ) );
		}

		// reset settings.
		$settings = $this->plugin->argpd_settings->reset();
		$settings = $this->plugin->argpd_settings->get_settings();

		// save every setting.
		foreach ( $settings as $name => $text ) {
			if ( isset( $_POST[ $name ] ) ) {
				$this->plugin->argpd_settings->update_setting( $name, sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) );
			}
		}

		// checkboxes.
		$disabled = isset( $_POST['es-empresa'] ) ? 1 : 0;
		$this->plugin->argpd_settings->update_setting( 'es-empresa', $disabled );

		$message = 'saved';
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'argpd',
					'message' => $message,
				),
				admin_url( 'admin.php?page=argpd&tab=ajustes' )
			)
		);
	}

	/**
	 *
	 * Add settings to plugin menu
	 *
	 * @param string $links links.
	 * @since  0.0.0
	 */
	public function plugin_add_settings_link( $links ) {
		$settings = '<a href="admin.php?page=argpd">' . __( 'Settings' ) . '</a>';

		if ( ! empty( $links ) ) {
			array_unshift( $links, $settings );
		} else {
			$links = array( $settings );
		}
		return $links;
	}

}
