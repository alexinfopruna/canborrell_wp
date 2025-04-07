<?php
namespace MageeShortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

    /**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 2.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;
    /**
	 * Plugin constructor.
	 *
	 * Initializing MageeShortcodes plugin.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function __construct() {
		$this->register_autoloader();
		\MageeShortcodes\Classes\Helper::get_instance();
		\MageeShortcodes\Classes\MageeSlider::get_instance();
	}

    /**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			do_action( 'mageeshortcodes/loaded' );
		}

		return self::$instance;
	}
    /**
	 * Register autoloader.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function register_autoloader() {
		require_once MAGEE_SHORTCODES_INCLUDE_DIR . '/autoloader.php';
		Autoloader::run();
	}
}

Plugin::instance();
