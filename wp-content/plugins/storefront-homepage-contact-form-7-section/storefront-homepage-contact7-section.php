<?php
/**
 * Plugin Name:			Storefront Homepage Contact Form 7 Section
 * Plugin URI:			http://wpdevhq.com/portfolio/storefront-homepage-contact7-section/
 * Description:			Adds a contact section to your Storefront site - powered by the Contact Form 7 plugin.
 * Version:				1.0.2
 * Author:				WPDevHQ
 * Author URI:			http://wpdevhq.com/
 * Requires at least:	4.0.0
 * Tested up to:		4.5
 *
 * Text Domain: shc7s
 * Domain Path: /languages/
 *
 * @package Storefront_Homepage_Contact7_Section
 * @category Core
 * @author WPDevHQ
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Returns the main instance of Storefront_Homepage_Contact7_Section to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Storefront_Homepage_Contact7_Section
 */
function Storefront_Homepage_Contact7_Section() {
	return Storefront_Homepage_Contact7_Section::instance();
} // End Storefront_Homepage_Contact7_Section()

Storefront_Homepage_Contact7_Section();

/**
 * Main Storefront_Homepage_Contact7_Section Class
 *
 * @class Storefront_Homepage_Contact7_Section
 * @version	1.0.0
 * @since 1.0.0
 * @package	Storefront_Homepage_Contact7_Section
 */
final class Storefront_Homepage_Contact7_Section {
	/**
	 * Storefront_Homepage_Contact7_Section The single instance of Storefront_Homepage_Contact7_Section.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		$this->token 			= 'shc7s';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'shc7s_load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'shc7s_setup' ) );
        
        add_action( 'widgets_init', array( $this, 'shc7s_contact_widget' ), 999 );		
	}

	/**
	 * Main Storefront_Homepage_Contact7_Section Instance
	 *
	 * Ensures only one instance of Storefront_Homepage_Contact7_Section is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Storefront_Homepage_Contact7_Section()
	 * @return Main Storefront_Homepage_Contact7_Section instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function shc7s_load_plugin_textdomain() {
		load_plugin_textdomain( 'shc7s', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'shc7s' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'shc7s' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();

		// get theme customizer url
		$url = admin_url() . 'customize.php?';
		$url .= 'url=' . urlencode( site_url() . '?storefront-customizer=true' ) ;
		$url .= '&return=' . urlencode( admin_url() . 'plugins.php' );
		$url .= '&storefront-customizer=true';

		$notices 		= get_option( 'shc7s_activation_notice', array() );
		$notices[]		= sprintf( __( '%sThanks for installing the Storefront Homepage Contact Section extension for Contact Form 7. To get started, visit the %sCustomizer%s.%s %sOpen the Customizer%s', 'shc7s' ), '<p>', '<a href="' . esc_url( $url ) . '">', '</a>', '</p>', '<p><a href="' . esc_url( $url ) . '" class="button button-primary">', '</a></p>' );

		update_option( 'shc7s_activation_notice', $notices );
	}

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

	/**
	 * Setup all the things.
	 * Only executes if Storefront or a child theme using Storefront as a parent is active and the extension specific filter returns true.
	 * Child themes can disable this extension using the storefront_homepage_contact_section_supported filter
	 * @return void
	 */
	public function shc7s_setup() {

		if ( 'storefront' == get_option( 'template' ) && apply_filters( 'storefront_homepage_contact7_section_supported', true ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'shc7s_styles' ), 999 );
			add_action( 'customize_register', array( $this, 'shc7s_customize_register' ) );
			add_action( 'admin_notices', array( $this, 'shc7s_customizer_notice' ) );
			add_action( 'homepage', array( $this, 'storefront_homepage_contact7_section' ), 90 );			

			// Hide the 'More' section in the customizer
			add_filter( 'storefront_customizer_more', '__return_false' );
		} else {
			add_action( 'admin_notices', array( $this, 'shc7s_install_storefront_notice' ) );
		}
	}

	/**
	 * Admin notice
	 * Checks the notice setup in install(). If it exists display it then delete the option so it's not displayed again.
	 * @since   1.0.0
	 * @return  void
	 */
	public function shc7s_customizer_notice() {
		$notices = get_option( 'shc7s_activation_notice' );

		if ( $notices = get_option( 'shc7s_activation_notice' ) ) {

			foreach ( $notices as $notice ) {
				echo '<div class="notice is-dismissible updated">' . $notice . '</div>';
			}

			delete_option( 'shc7s_activation_notice' );
		}
	}

	/**
	 * Storefront install
	 * If the user activates the plugin while having a different parent theme active, prompt them to install Storefront.
	 * @since   1.0.0
	 * @return  void
	 */
	public function shc7s_install_storefront_notice() {
		echo '<div class="notice is-dismissible updated">
				<p>' . __( 'Storefront Homepage Contact Form 7 Section requires that you use Storefront as your parent theme.', 'shc7s' ) . ' <a href="' . esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-theme&theme=storefront' ), 'install-theme_storefront' ) ) .'">' . __( 'Install Storefront now', 'shc7s' ) . '</a></p>
			</div>';
	}
	
	public function shc7s_contact_widget() {
		register_sidebar( array(
			'name'          => __( 'Homepage Contact Section', 'shc7s' ),
			'id'            => 'shc7s-1',
			'description'   => __( 'To be used in conjuction with the homepage contact section. Ideal for adding Business/Opening Hours!', 'shc7s' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	/**
	 * Customizer Controls and settings
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function shc7s_customize_register( $wp_customize ) {
		/**
	     * Add a new section
	     */
        $wp_customize->add_section( 'shc7s_section' , array(
		    'title'      	=> __( 'Contact Section', 'shc7s' ),
		    'priority'   	=> 55,
		) );

		/**
		 * Address
		 */
		$wp_customize->add_setting( 'shc7s_contact_address', array(
			'default'			=> '',
			'sanitize_callback'	=> 'wp_filter_post_kses'
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shc7s_contact_address', array(
			'label'         => __( 'Address', 'shc7s' ),
			'description'   => __( 'Enter contact address. This address will be used to generate a map displayed as a background to the Contact section.', 'shc7s' ),
			'section'       => 'shc7s_section',
			'settings'      => 'shc7s_contact_address',
			'type'          => 'textarea',
			'priority'      => 10,
		) ) );

		/**
		 * Phone Number
		 */
		$wp_customize->add_setting( 'shc7s_contact_phone_number', array(
			'default'			=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shc7s_contact_phone_number', array(
			'label'         => __( 'Phone Number', 'shc7s' ),
			'description'   => __( 'Enter phone number.', 'shc7s' ),
			'section'       => 'shc7s_section',
			'settings'      => 'shc7s_contact_phone_number',
			'type'          => 'text',
			'priority'      => 20,
		) ) );

		/**
		 * Email Address
		 */
		$wp_customize->add_setting( 'shc7s_contact_email_address', array(
			'default'			=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shc7s_contact_email_address', array(
			'label'         => __( 'Email Address', 'shc7s' ),
			'description'   => __( 'Enter email address.', 'shc7s' ),
			'section'       => 'shc7s_section',
			'settings'      => 'shc7s_contact_email_address',
			'type'          => 'text',
			'priority'      => 30,
		) ) );

		/**
		 * Contact Form Heading
		 */
		if ( class_exists( 'Arbitrary_Storefront_Control' ) ) {
			$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'shc7s_contact_form_heading', array(
				'section'  	=> 'shc7s_section',
				'type'		=> 'heading',
				'label'		=> __( 'Contact form', 'shc7s' ),
				'priority' 	=> 40,
			) ) );
		}

		/**
		 * Contact Form Jetpack Message
		 */
		$contact7_message = '';
		if ( ! class_exists( 'WPCF7' ) ) {
			$contact7_message = sprintf( __( 'To enable the Contact Form feature, please install the %sContact Form 7%s plugin and activate it.', 'shc7s' ), '<a href="https://wordpress.org/plugins/contact-form-7/">', '</a>' );
		}

		if ( '' !== $contact7_message && class_exists( 'Arbitrary_Storefront_Control' ) ) {
			$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'shc7s_contact_jetpack_warning', array(
				'section'		=> 'shc7s_section',
				'type'			=> 'text',
				'description'	=> $contact7_message,
				'priority'		=> 50,
			) ) );
		}

		/**
		 * Contact Form
		 */
		if ( class_exists( 'WPCF7' ) ) {
			$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'shc7s_contact_form_information', array(
				'section'		=> 'shc7s_section',
				'type'			=> 'text',
				'description'	=> sprintf( __( 'All submitted messages will be sent to the email address configured as the Admin email or that set as "To" in the Mail tab when creating the %scontact form%s.', 'shc7s' ), '<a href="' . esc_url( admin_url( 'admin.php?page=wpcf7' )  ) . '">', '</a>' ),
				'priority'		=> 60,
			) ) );

			$wp_customize->add_setting( 'shc7s_contact_form', array(
				'default'			=> true,
				'sanitize_callback'	=> 'absint',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shc7s_contact_form', array(
				'label'			=> __( 'Display contact form', 'shc7s' ),
				'description'	=> __( 'Toggle the display of the contact form.', 'shc7s' ),
				'section'		=> 'shc7s_section',
				'settings'		=> 'shc7s_contact_form',
				'type'			=> 'checkbox',
				'priority'		=> 70,
			) ) );
			
			$wp_customize->add_setting( 'contact_form_7_id', array( 
		        'default' => '', 
		        'sanitize_callback' => 'absint',
                'capability' => 'edit_theme_options',
	        ) );
	
	        $wp_customize->add_control( 'contact_form_7_id', array(
		        'type'      => 'text',
		        'label'     => __( 'Contact Form 7 ID', 'shc7s' ),
		        'description' => __( 'If using Contact Form 7 please enter the form ID here. Digits only i.e. 1234', 'shc7s' ),
		        'section'   => 'shc7s_section',
		        'priority'  => 80,
		    ));
		
		    $wp_customize->add_setting( 'contact_form_7_title', array( 
		        'default' => 'Contact form 1', 
		        'sanitize_callback' => 'sanitize_text_field',
                'capability' => 'edit_theme_options',
	        ) );
	
	        $wp_customize->add_control( 'contact_form_7_title', array(
		        'type'      => 'text',
		        'label'     => __( 'Contact Form 7 title', 'shc7s' ),
		        'description' => __( 'Please enter the contact form 7 title here i.e. Contact form 1', 'shc7s' ),
		        'section'   => 'shc7s_section',
		        'priority'  => 90,
		    ));
		}
	}

	/**
	 * Enqueue CSS and custom styles.
	 * @since   1.0.0
	 * @return  void
	 */
	public function shc7s_styles() {
		wp_enqueue_style( 'shc7s-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );

		$bg_color			= apply_filters( 'storefront_homepage_contact7_section_bg', storefront_get_content_background_color() );
		$accent_color		= get_theme_mod( 'storefront_accent_color', apply_filters( 'storefront_default_accent_color', '#ffffff' ) );
		$details_color		= get_theme_mod( 'storefront_button_text_color', apply_filters( 'storefront_default_button_text_color', '#ffffff' ) );
		$details_bg_color	= get_theme_mod( 'storefront_button_background_color', apply_filters( 'storefront_default_button_background_color', '#60646c' ) );
		$overlay_opacity	= apply_filters( 'storefront_homepage_contact7_section_overlay', .8 );

		// Get RGB color of overlay from HEX
		if ( Storefront_Homepage_Contact7_Section::sanitize_hex_color( $bg_color ) ) {
			list( $r, $g, $b ) = sscanf( $bg_color, "#%02x%02x%02x" );
		} else {
			$r = $g = $b = 255;
		}

		$shc7s_style = '
		.storefront-homepage-contact7-section .shc7s-overlay {
			background-color: rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $overlay_opacity .');
		}

		.storefront-homepage-contact7-section .shc7s-contact-details ul li:before {
			color: ' . $details_color . '; background-color: ' . $details_bg_color . ';
		}';

		wp_add_inline_style( 'shc7s-styles', $shc7s_style );
	}

	/**
	 * Contact section
	 * @since   1.0.0
	 * @return 	void
	 */
	public static function storefront_homepage_contact7_section() {
		$address		= get_theme_mod( 'shc7s_contact_address', '' );
		$phone_number	= get_theme_mod( 'shc7s_contact_phone_number', '' );
		$email			= get_theme_mod( 'shc7s_contact_email_address', '' );
		$display_form	= get_theme_mod( 'shc7s_contact_form', true );

		$map_url = '';
		if ( '' !== $address ) {
			$map_url = 'https://maps.googleapis.com/maps/api/staticmap?scale=2&size=530x300&center=' . urlencode( trim( preg_replace( '/\s+/', ' ', $address ) ) );
		}
?>
	<section class="storefront-product-section storefront-homepage-contact7-section">
		
		<div class="shc7s-wrapper"<?php if ( '' !== $map_url ) : ?> style="background-image: url(<?php echo esc_url( $map_url ); ?>);"<?php endif; ?>>
			<div class="shc7s-overlay">
			<h2 class="section-title">
			    <?php esc_attr_e( apply_filters( 'storefront_homepage_contact7_section_title', __( 'Contact Us', 'shc7s' ) ) ); ?>
			</h2>
				<?php if ( '' !== $address || '' !== $phone_number || '' !== $email || is_active_sidebar( 'shc7s-1' ) ) : ?>
				<div class="shc7s-contact-details">
					<ul>
						<?php if ( '' !== $address ) : ?>
						<li class="shc7s-address"><?php echo wpautop( esc_attr( $address ) ); ?></li>
						<?php endif; ?>

						<?php if ( '' !== $phone_number ) : ?>
						<li class="shc7s-phone-number"><?php echo wpautop( esc_attr( $phone_number ) ); ?></li>
						<?php endif; ?>

						<?php if ( '' !== $email ) : ?>
						<li class="shc7s-email"><?php echo wpautop( esc_attr( $email ) ); ?></li>
						<?php endif; ?>
					</ul>
					<?php if ( is_active_sidebar( 'shc7s-1' ) ) { ?>
	                    <div class="shc7s-widget-area">
		                    <?php dynamic_sidebar( 'shc7s-1' ); ?>
	                    </div><!-- .widget-area -->
                    <?php } ?>
				</div>
				<?php endif;

				    if ( class_exists( 'WPCF7' ) ) { 
			            if ( true == $display_form ) { 
						$cf7_id    = get_theme_mod( 'contact_form_7_id' ); 
						$cf7_title = get_theme_mod( 'contact_form_7_title', 'Contact form 1' ); ?>
				            <div class="shc7s-contact-form">
					            <?php echo do_shortcode( '[contact-form-7 id="' . $cf7_id . '" title="' . $cf7_title . '"]' ); ?>
				            </div>
			            <?php }
	                } ?>
			</div>
		</div>
	</section>
<?php
	}

	/**
	 * Sanitizes a hex color. Identical to core's sanitize_hex_color(), which is not available on the wp_head hook.
	 *
	 * Returns either '', a 3 or 6 digit hex color (with #), or null.
	 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
	 *
	 * @since  1.0.0
	 * @param  string $color
	 * @return string|void
	 */
	private function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
        }

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
        }

		return null;
	}
} // End Class
