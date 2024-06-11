<?php
if (! defined('ABSPATH')) {
    exit;
}

/**
 * @package ARGPD
 * @subpackage Integration
 * @since 0.0.0
 *
 * @author César Maeso <info@superadmin.es>
 * @copyright (c) 2018, César Maeso (https://superadmin.es)
 */

/**
 * Integration class.
 *
 * @since  0.0.0
 */
class ARGPD_Integration
{

    /**
     * Parent plugin class.
     *
     * @var    string
     * @since  0.0.0
     */
    protected $plugin = null;


    /**
     * Constructor.
     *
     * @since  0.0.0
     *
     * @param string $plugin Main plugin object.
     */
    public function __construct($plugin)
    {
        // set parent plugin.
        $this->plugin = $plugin;

        $this->register();

        $this->hooks();
    }


    /**
     * Register scripts and Styles for cookies banner
     *
     * @since  0.0.0
     */
    public function register()
    {
        $settings = $this->plugin->argpd_settings->get_settings();

        wp_register_style(
            'argpd-cookies-eu-banner',
            sprintf('%sassets/css/cookies-banner-%s.css', $this->plugin->url, $settings['cookies-theme']),
            array(),
            $this->plugin->version
        );

        wp_register_style(
            'argpd-informbox',
            sprintf('%sassets/css/inform-box-%s.css', $this->plugin->url, $settings['informbox-theme']),
            array(),
            $this->plugin->version
        );

        wp_register_style(
            'argpd-admin',
            $this->plugin->url . 'assets/css/argpd-admin.css',
            array(),
            $this->plugin->version
        );

        wp_register_script(
            'argpd-cookies-eu-banner',
            $this->plugin->url . 'assets/js/cookies-eu-banner.js',
            array(
                'jquery',
            ),
            $this->plugin->version
        );
    }

    /**
     * Register scripts and Styles for admin panel
     */
    public function enqueue_admin_assets()
    {
        wp_enqueue_style('argpd-admin');
    }

    /**
     * Initiate our hooks.
     *
     * @since  0.0.0
     */
    public function hooks()
    {

        $settings = $this->plugin->argpd_settings->get_settings();

        // Hooks if option-footer.
        if ($settings['option-footer']) {
            // action for show footer.
            add_action('wp_footer', array( $this, 'show_footer_links' ));

            // register legal menu.
            add_action('init', array( $this, 'register_legal_menu' ));
            add_action('init', array( $this, 'create_legal_menu' ));

            // add items to legal menu.
            add_filter('wp_nav_menu_items', array( $this, 'add_menu_legal_items' ), 10, 2);
        }

        // Hooks if option-comments.
        if ($settings['option-comments']) {
            while (true) {
                // disable if jetpack-comments is active.
                if (class_exists('Jetpack') && Jetpack::is_module_active('comments')) {
                    break;
                }

                add_action('pre_comment_on_post', array( $this, 'check_consentimiento' ));
                add_filter('comment_form_submit_field', array( $this, 'add_field' ));
                break;
            }
        }

        // Hooks if have a duty to inform.
        if ($settings['option-comments'] || $settings['option-forms'] || $settings['option-wc-top-layer']) {
            wp_enqueue_style('argpd-informbox');
        }

        // Hooks if option-wc-top-layer.
        if ($settings['option-wc-top-layer']) {
            add_action('woocommerce_review_order_after_submit', array( $this, 'wcgdprsettings_add_checkout_top_layer' ), 20);
        }

        // Hooks if option-wc-top-layer.
        if ($settings['option-wc-promo']) {
            add_action('woocommerce_review_order_before_submit', array( $this, 'wcgdprsettings_add_checkout_checkbox' ), 9);
            add_action('woocommerce_checkout_update_order_meta', array( $this, 'wcgdprsettings_update_order_meta_promo_consent' ));
            add_action('woocommerce_admin_order_data_after_billing_address', array( $this, 'wcgdprsettings_display_admin_order_promo_consent' ), 10, 1);
            add_filter('woocommerce_email_after_order_table', array( $this, 'wcgdprsettings_display_mail_order_promo_consent' ), 10, 2);
        }

        // Hooks if option-cookies.
        if ($settings['option-cookies']) {
            // echo cookies banner.
            add_action('wp_footer', array( $this, 'cookiesbanner_footer' ));

            // assets.
            wp_enqueue_style('argpd-cookies-eu-banner');
            wp_enqueue_script('argpd-cookies-eu-banner');

            // filters assets.
            add_filter('script_loader_src', array( $this, 'filter_load_assets' ), 10, 2);

            // Eliminar los scripts sin consentimiento.
            if ($settings['cookies-filter-known-scripts'] || $settings['remove-iframes']) {
                // filtrar el contenido.
                // actions.
                $priority = 100;
                add_action('template_redirect', array( $this, 'buffer_start' ), $priority);
                add_action('shutdown', array( $this, 'buffer_end' ), $priority);

                // filter cookies.
                if ($settings['cookies-filter-known-scripts']) {
                    add_filter('argpd_unconsent_patterns', array( $this, 'unconsent_patterns' ));

                    if (isset($_COOKIE['hasConsents'])) {
                        $has_consents = sanitize_text_field(wp_unslash($_COOKIE['hasConsents']));
                        $has_consents = str_replace('+', ' ', $has_consents);
                        $consents = explode(' ', $has_consents);
                        // Ej. Array ( [0] => ANLTCS [1] => SCLS ).
                        if (! in_array('ANLTCS', $consents)) {
                            require_once dirname(__FILE__) . '/../lib/unconsent-analytics.php';
                        }
                        if (! in_array('SCLS', $consents)) {
                            require_once dirname(__FILE__) . '/../lib/unconsent-social.php';
                        }
                    } else {
                        // el consentimiento es anterior.
                        if (! isset($_COOKIE['hasConsent']) || 'true' != $_COOKIE['hasConsent']) {
                            require_once dirname(__FILE__) . '/../lib/unconsent-analytics.php';
                            require_once dirname(__FILE__) . '/../lib/unconsent-social.php';
                        }
                    }
                }
                // iframes filter.
                if ($settings['remove-iframes']) {
                    add_filter('argpd_unconsent_iframe_patterns', array( $this, 'iframe_patterns' ));
                    if (isset($_COOKIE['hasConsents'])) {
                        $has_consents = sanitize_text_field(wp_unslash($_COOKIE['hasConsents']));
                        $has_consents = str_replace('+', ' ', $has_consents);
                        $consents = explode(' ', $has_consents);
                        if (! in_array('ANLTCS', $consents)) {
                            require_once dirname(__FILE__) . '/../lib/unconsent-iframe.php';
                        }
                    } else {
                        require_once dirname(__FILE__) . '/../lib/unconsent-iframe.php';
                    }
                }
            }

            // actions.
            add_action('wp_footer', array( $this, 'argpd_banner_cookies' ), 100);

            if (is_user_logged_in()) {
                add_action('wp_ajax_cookie_consent', array( $this, 'ajax_cookie_consent' ));
            } else {
                add_action('wp_ajax_nopriv_cookie_consent', array( $this, 'ajax_cookie_consent' ));
            }
        }

        // Enqueue admin assets.
        if (current_user_can('manage_options')) {
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ));
        }

        // Evita la indexación en buscadores.
        add_action('wp_head', array( $this, 'noindex_meta' ));
        add_filter('wp_sitemaps_posts_query_args', array( $this, 'exclude_legal_pages_from_sitemap' ), 10, 2);
    }


    /**
     * Define un array con patrones de bloqueo en scripts
     * cuando no hay consentimiento.
     *
     * @since  1.3.0
     */
    public function unconsent_patterns($patterns)
    {
        $patterns = array();
        return $patterns;
    }

    /**
     * Define un array con patrones de bloqueo en scripts
     * cuando no hay consentimiento.
     *
     * @since  1.3.7
     */
    public function iframe_patterns($patterns)
    {
        $patterns = array();
        return $patterns;
    }


    /**
     * Ajax to enqueue scripts to consent.
     *
     * @since  1.3.0
     */
    public function ajax_cookie_consent() {
        check_ajax_referer('cookie_consent', 'security');
        
        $resp = array();        
        $settings = $this->plugin->argpd_settings;
        $option_store_consents = $settings->get_setting( 'option-store-consents' );
        $apikey = $settings->get_setting( 'apikey' );
        
        $consentUpdateRequired = isset( $_POST['update'] ) && $_POST['update'] == 1;
        if ( $option_store_consents && strlen( $apikey ) > 0  && $consentUpdateRequired ) {
            // get auth.
            $args = array(
                'method' => 'POST',
                'headers' => array(
                    'Content-Type' => 'application/json'
                ),
               'body' => json_encode( array( 'token' => $apikey ) ),
            );
            $auth_response = wp_remote_post( "https://superapis.es/legaltech360/api/v1/auth", $args );
            if ( is_wp_error( $auth_response ) ) {
                wp_die();
            } else {
                $jwt_token = $auth_response['body'];
            }

            // persist consent.
            $uuid = isset( $_COOKIE["argpd_consentUUID"] ) ? sanitize_text_field( $_COOKIE["argpd_consentUUID"] ) : "";
            $ip = trim( sanitize_text_field( $this->getUserIP() ) );
            $ua = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
            $uri = isset( $_POST['uri'] ) ? trim( sanitize_url( $_POST['uri'] ) ): "";
            $args = array(
                'method' => 'POST',
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $jwt_token,
                    'Origin' => esc_url ( get_site_url() ),
                ),
               'body' => json_encode( array(
                    'id' => $uuid,
                    'ip' => $ip,
                    'ua' => $ua,
                    'uri' => $uri,
                    'purpose-necessary' => isset( $_POST['purpose-necessary'] ) && $_POST['purpose-necessary'] == 1,
                    'purpose-non-necessary' => isset( $_POST['purpose-non-necessary']) && $_POST['purpose-non-necessary'] == 1,
                    'purpose-analytics' => isset( $_POST['purpose-analytics'] ) && $_POST['purpose-analytics'] == 1,
                    'purpose-marketing' => isset( $_POST['purpose-marketing'] ) && $_POST['purpose-marketing'] == 1,
                    'purpose-advertisement' => isset( $_POST['purpose-advertisement']) && $_POST['purpose-advertisement'] == 1,
                    'raw' => json_encode( $_REQUEST ),
                    ) 
                ), 
            );
            $consent_response = wp_remote_post( "https://superapis.es/legaltech360/api/v1/consents/consent", $args );
            if ( is_wp_error( $consent_response ) ) {
                wp_die();
            }
            $resp['uuid'] = $consent_response['body'];
        }
        
        // scripts to reject
        $collection = array();
        $scripts_reject = $settings->get_setting('scripts-reject');
        if (( is_array($scripts_reject) && is_object($scripts_reject) )) {
            $data = wp_scripts();
            foreach ($scripts_reject as $script) {
                foreach ($data->registered as $k => $el) {
                    if ($k != $script) {
                        continue;
                    }

                    if (! isset($el->src)) {
                        continue;
                    }

                    $url = $this->plugin->argpd_ui->prepare_url($el->src);
                    if (strpos($url, plugins_url()) !== 0) {
                        continue;
                    }
                    array_push($collection, $url);
                }
            }
        }
        $resp['scripts-reject'] = join(',', $collection);
        
        print_r( json_encode( $resp ) );
        wp_die();
    }

    /**
     * argpd_banner_cookies
     *
     * @since  1.3.0
     */
    public function argpd_banner_cookies()
    {
        $settings = $this->plugin->argpd_settings;
        ?>

<script type="text/javascript">
jQuery(function ($) {
    'use strict';

    window.Adapta_RGPD = window.Adapta_RGPD || {};

    Adapta_RGPD.getCookie= function(name) {
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    }

    Adapta_RGPD.setCookie= function (name, value) {
      var date = new Date();
      date.setTime(date.getTime() + this.cookieTimeout);
      
      document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
    };

    Adapta_RGPD.deleteCookie = function (name) {
        var hostname = document.location.hostname.replace(/^www\./, '');
        var nacked = hostname.replace(/^[^.]+\./g, "");
        var commonSuffix = '; expires=Thu, 01-Jan-1970 00:00:01 GMT; path=/';

        // remove cookies that match name
        document.cookie = name + '=; domain=.' + hostname + commonSuffix;
        document.cookie = name + '=; domain=.' + nacked + commonSuffix;
        document.cookie = name + '=' + commonSuffix;

        // search and remove all cookies starts with name
        document.cookie.split(';')
        .filter(function(el) {
            return el.trim().indexOf(name) === 0;
        })
        .forEach(function(el) {
            var [k,v] = el.split('=');
            document.cookie = k + '=; domain=.' + hostname + commonSuffix;
            document.cookie = k + '=; domain=.' + nacked + commonSuffix;            
            document.cookie = k + '=' + commonSuffix;
        })
    };

    Adapta_RGPD.onlyUnique= function(value, index, self) {
      return self.indexOf(value) === index;
    };

    Adapta_RGPD.removeItemOnce = function(arr, value) {
      var index = arr.indexOf(value);
      if (index > -1) {
        arr.splice(index, 1);
      }
      return arr;
    };

    // load events.
    Adapta_RGPD.loadEvents= function(){
        $("[id^='custom-cookies-accept']").click(function(){
            var consents= new Array();  
            var value= Adapta_RGPD.getCookie('hasConsents');
            if ( null != value && value.length) {
                consents = value.split("+")
            }
            
            var consent = this.dataset.consent;
            consents.push(consent)
            
            var unique= consents.filter(Adapta_RGPD.onlyUnique);
            Adapta_RGPD.setCookie('hasConsents', unique.join('+'));
            Adapta_RGPD.setCookie('hasConsent', true);
        });

        $("[id^='custom-cookies-reject'],#custom-cookies-eu-reject,#cookies-eu-reject").click(function(){
            const trackingCookiesNames = ['__utma', '__utmb', '__utmc', '__utmt', '__utmv', '__utmz', '_ga', '_gat', '_gid', '_fbp'];   
            var value= Adapta_RGPD.getCookie('hasConsents');
            if ( null == value ) {
                return
            }

            // consent is the consent to remove. Ej ANLT
            var consent = ('undefined' !== typeof this.dataset && this.dataset.hasOwnProperty('consent'))?this.dataset.consent:null;
            if (consent != null) {              
                var consents = value.split("+")         
                consents=Adapta_RGPD.removeItemOnce(consents, consent)
                Adapta_RGPD.setCookie('hasConsents', consents.join('+'));
            }
            
            if ( 'ANLTCS' == consent || null == consent ) {
                trackingCookiesNames.map(Adapta_RGPD.deleteCookie);
            }

            // update api consent
            var consentUUIDCookie = Adapta_RGPD.getCookie('argpd_consentUUID');
            if ( null == consentUUIDCookie || consentUUIDCookie.length == 0) {
                return;
            }
        
            var ajaxurl = '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';
            var data = {
                action: 'cookie_consent',
                security: '<?php echo esc_attr( wp_create_nonce( 'cookie_consent' ) ); ?>',
                uri: window.location.href,
                'update': 1,
                'statement': $("#cookies-eu-label").text(),
                'purpose-necessary': 1,
                'purpose-non-necessary': 0,
                'purpose-analytics': 0,
                'purpose-marketing': 0,
                'purpose-advertisement': 0,
            };              
            $.post( ajaxurl, data, function(response) {                 
                <?php if ($settings->get_setting('cookies-sticky-button') == 1) : ?>
                $('#cookies-eu-banner-closed').show();
                <?php endif; ?>

                if ( undefined !== response.success && false === response.success ) {                       
                    return;
                }       
            });
        });

        // reject all event
        $("#cookies-eu-banner-closed, .cookies-eu-banner-closed" ).click(function(){
            var date = new Date();
            date.setTime(date.getTime() + 33696000000);
            document.cookie = 'hasConsent' + '=' + 'configure' + ';expires=' + date.toUTCString() + ';path=/';
            window.location.reload();
        });

        <?php
        // show sticky button to show privacy bar.
        $settings = $this->plugin->argpd_settings;
        if ($settings->get_setting('cookies-sticky-button') == 1) : ?>          
        window.setTimeout(function(){
            if( $("#cookies-eu-banner").length == 0 || $("#cookies-eu-banner").is(":hidden") ){
                $('#cookies-eu-banner-closed').show();
            }       
        }, 100);
        <?php endif;
        ?> 

        // toggle first layer privacy
        <?php
            $settings = $this->plugin->argpd_settings;
        if ($settings->get_setting('informbox-theme') == 'hidden') : ?>
        $(document).on('click', '.argpd-mas', function (e) {        
            $(".argpd-informar > ul").toggle(); 
        });
        <?php endif;
        ?>
    }

    // init 
    Adapta_RGPD.init = function(){
        jQuery(document).ready(function($) {
            // Prevent for search engine execute ajax function.
            var bots = /bot|crawler|spider|crawling/i;
            var isBot = bots.test(navigator.userAgent);
            if ( isBot ) {
                return;
            }

            // event if cookies-reload option
            <?php
            if ($settings->get_setting('cookies-reload') == 1) : ?>
                $(".cookies-eu-accept").click(function(){
                    setTimeout( function(){ 
                        window.location.href = window.location.href; 
                    }, 500 );
                });
            <?php endif;

            // event if cookies-sticky-button option
            if ($settings->get_setting('cookies-sticky-button') == 1) : ?>
            $(".cookies-eu-reject").click(function(){
                $('#cookies-eu-banner-closed').show();
            });
            <?php endif; ?>

            // code to launch when user accepts cookies
            new CookiesEuBanner(function (update=false) {
                var ajaxurl = '<?php echo esc_attr(admin_url('admin-ajax.php')); ?>';
                var data = {
                    action: 'cookie_consent',
                    security: '<?php echo esc_attr(wp_create_nonce('cookie_consent')); ?>',
                    uri: window.location.href,
                    'update': (update == true)?1:0,
                    'statement': $("#cookies-eu-label").text(),
                    'purpose-necessary': 1,
                    'purpose-non-necessary': 0,
                    'purpose-analytics': '<?php echo esc_attr($settings->get_setting('purpose-analytics')); ?>',
                    'purpose-marketing': '<?php echo esc_attr($settings->get_setting('purpose-marketing')); ?>',
                    'purpose-advertisement': '<?php echo esc_attr($settings->get_setting('purpose-advertisement')); ?>',
                };              
                $.post( ajaxurl, data, function(response) {
                    <?php if ($settings->get_setting('cookies-sticky-button') == 1) : ?>
                    $('#cookies-eu-banner-closed').show();
                    <?php endif; ?>

                    if ( undefined !== response.success && false === response.success ) {                       
                        return;
                    }       

                    var data = jQuery.parseJSON(response);
                    if (data == null) {
                        return
                    }

                    // set cookie argpd_consentUUID
                    if (data.hasOwnProperty('uuid')) {
                        Adapta_RGPD.setCookie('argpd_consentUUID', data['uuid']);
                    }

                    // append scripts
                    if (data.hasOwnProperty('scripts-reject')) {
                        var scripts = data['scripts-reject'].split(",");
                        scripts.forEach(function(src){
                            var script = document.createElement( 'script' );
                            script.setAttribute( "src", src );
                            document.getElementsByTagName( "head" )[0].appendChild( script );
                        });             
                    }
                });             
            }, true);

            Adapta_RGPD.loadEvents();
        });
    }
    Adapta_RGPD.init();
});
</script>
        <?php
    }

    /**
     * Engueue scripts and styles
     *
     * @since  0.0.0
     */
    public function enqueue()
    {
        // Allows to disable enqueuing files on a particular page.
        $enqueue_agrpd = apply_filters('wp_agrpd_enqueue', true);
    }

    /**
     * Add view for comment form submit
     *
     * @since  0.0.0
     */
    public function add_field($submit_field = '')
    {
        $consentimiento_view = $this->plugin->pages->consentimiento_view();
        $first_layer_privacy_view = $this->plugin->pages->first_layer_privacy_view(__('Moderar los comentarios.', 'argpd'));
        return $consentimiento_view . $first_layer_privacy_view . $submit_field;
    }

    /**
     * Test if privacy is checked in comments
     *
     * @since  0.0.0
     */
    public function check_consentimiento()
    {
        if (! isset($_POST['agdpr-consentimiento'])) {
            wp_die(__('Para poder comentar debes aceptar la política de privacidad.', 'argpd'));
        }
    }

    /**
     * Echo cookies banner
     *
     * @since  0.0.0
     */
    public function cookiesbanner_footer()
    {
        echo $this->plugin->pages->cookiesbanner_view();
    }

    /**
     * Echo cookies banner
     *
     * @since  1.0.0
     */
    public function show_footer_links()
    {
        // echo pre footer text.
        echo $this->plugin->pages->footer_links_view();
        if (has_nav_menu('menu-argpd')) {
            wp_nav_menu(
                array(
                    'container'       => 'div',
                    'container_class' => 'argpd-footer',
                    'menu_class'      => '',
                    'theme_location'  => 'menu-argpd',
                    'fallback_cb'     => false,
                )
            );
        }
    }

    /**
     * Añade la etiqueta robots con valor noindex,follow para excluir
     * los textos legales
     *
     * @since  1.0.0
     */
    public function noindex_meta()
    {
        if (! is_singular()) {
            return;
        }

        $settings    = $this->plugin->argpd_settings;
        $legal_pages = array(
            (int) $settings->get_setting('cookiesID'),
            (int) $settings->get_setting('privacidadID'),
            (int) $settings->get_setting('avisolegalID'),
            (int) $settings->get_setting('custom-cookies-page-id'),
        );

        $noindex = ( (int) $settings->get_setting('robots-index') == 1 ) ? false : true;
        if ($noindex && in_array(get_the_ID(), $legal_pages)) {
            echo "\n\n" . '<meta name="robots" content="noindex,follow" />' . "\n\n";
        }
    }

    /**
     * Excluye los textos legales en el Sitemap.
     * https://make.wordpress.org/core/2020/07/22/new-xml-sitemaps-functionality-in-wordpress-5-5/
     *
     * @since  1.2.0
     */
    public function exclude_legal_pages_from_sitemap($args, $post_type)
    {

        $settings    = $this->plugin->argpd_settings;
        $legal_pages = array(
            (int) $settings->get_setting('cookiesID'),
            (int) $settings->get_setting('privacidadID'),
            (int) $settings->get_setting('avisolegalID'),
            (int) $settings->get_setting('custom-cookies-page-id'),
        );

        $noindex = ( (int) $settings->get_setting('robots-index') == 1 ) ? false : true;
        if ($noindex) {
            $args['post__not_in'] = isset($args['post__not_in']) ? $args['post__not_in'] : array();
            $args['post__not_in'] = $legal_pages;
        }

        return $args;
    }

    /**
     * Register legal menu.
     *
     * @since  1.1
     */
    public function register_legal_menu()
    {
        register_nav_menus(
            array(
                'menu-argpd' => esc_html__('Menú para los textos legales - RGPD', 'argpd'),
            )
        );
    }

    /**
     * Add menu items to legal menu.
     *
     * @param string $items items.
     * @param string $args args.
     * @since  1.1
     */
    public function add_menu_legal_items($items, $args)
    {

        if ('menu-argpd' == $args->theme_location) {
            $i = '';
            $settings = $this->plugin->argpd_settings;

            if ('0' != $settings->get_setting('avisolegalID')) {
                $aviso_legal_url = $settings->get_setting('avisolegalURL');
                $i .= sprintf('<li><a href="%s">%s</a></li>', esc_url($aviso_legal_url), esc_html__('Aviso Legal', 'argpd'));
            }

            if ('0' != $settings->get_setting('privacidadID')) {
                $privacidad_url = $settings->get_setting('privacidadURL');
                $i .= sprintf('<li><a href="%s">%s</a></li>', esc_url($privacidad_url), esc_html__('Política de Privacidad', 'argpd'));
            }

            if ('0' != $settings->get_setting('cookiesID')) {
                $cookies_url = $settings->get_setting('cookiesURL');
                $i .= sprintf('<li><a href="%s">%s</a></li>', esc_url($cookies_url), esc_html__('Política de Cookies', 'argpd'));
            }

            if ('0' == $settings->get_setting('cookies-disabled') && '0' == $settings->get_setting('cookies-sticky-button')) {
                $i .= sprintf('<li><a class="cookies-eu-banner-closed" href="javascript:void(0);">%s</a></li>', esc_html__('Configuración de Cookies', 'argpd'));
            }
            $items = $i . $items;
        }
        return $items;
    }

    /**
     * Create menu 'Textos legales' if not exists and asign
     * to menu-argpd location.
     *
     * @since  1.2
     */
    public function create_legal_menu()
    {

        $locations = get_nav_menu_locations();
        if (empty($locations) || ! array_key_exists('menu-argpd', $locations) || empty($locations['menu-argpd'])) {
            // create menu if not exists.
            $name = 'Textos legales - Adapta RGPD';
            if (! wp_get_nav_menu_object($name)) {
                wp_create_nav_menu($name);
            }

            // asign menu-argpd location to menu.
            $menu = wp_get_nav_menu_object($name);
            $locations['menu-argpd'] = $menu->term_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }

    /**
     * Conditional filtering script_loader_src filter.
     *
     * @since  1.3
     *
     * @param string $src src.
     * @param string $handle handle.
     */
    public function filter_load_assets($src, $handle)
    {

        $settings = $this->plugin->argpd_settings->get_settings();

        if (empty($settings['scripts-reject'])) {
            return $src;
        }

        // not filter if not option-cookies.
        if (! $settings['option-cookies']) {
            return $src;
        }

        // not filter if has consent.
        if (isset($_COOKIE['hasConsent']) && 'true' == $_COOKIE['hasConsent']) {
            return $src;
        }

        // not filter admins.
        if (current_user_can('manage_options')) {
            return $src;
        }

        foreach ($settings['scripts-reject'] as $script) {
            if ($script == $handle) {
                return false;
            }
        }
        return $src;
    }

    /**
     * filters buffer to remove scripts
     *
     * @since  1.3
     *
     */
    public function filter_buffer($buffer)
    {
        $unconsent = array();
        $unconsent = apply_filters('argpd_unconsent_patterns', $unconsent);

        $script_pattern = '/(<script.*?>)(\X*?)<\/script>/i';
        if (preg_match_all($script_pattern, $buffer, $matches)) {
            foreach ($matches[0] as $key => $script) {
                if ($this->strpos_arr($script, $unconsent) !== false) {
                    $buffer = str_replace($script, '', $buffer);
                }
            }
        }

        $unconsent_iframe_patterns = array();
        $unconsent_iframe_patterns = apply_filters('argpd_unconsent_iframe_patterns', $unconsent_iframe_patterns);
        $iframe_pattern = '/(<iframe.*?>)(\X*?)<\/iframe>/i';
        if (preg_match_all($iframe_pattern, $buffer, $matches)) {
            foreach ($matches[0] as $key => $iframe) {
                if ($this->strpos_arr($iframe, $unconsent_iframe_patterns) !== false) {
                    $buffer = str_replace($iframe, '', $buffer);
                }
            }
        }
        return $buffer;
    }

    /**
     * buffer_start
     * More info: https://core.trac.wordpress.org/ticket/43258
     * More info:https://wordpress.org/plugins/output-buffer-tester/
     *
     * @since  1.3
     *
     */
    public function buffer_start()
    {
        ob_start(array( $this, 'filter_buffer' ));
    }

    /**
     * Vuelca el búfer de salida.
     *
     * @since  1.3
     *
     */
    public function buffer_end()
    {
        if (ob_get_length()) {
            ob_end_flush();
        }
    }

    /**
     * Busca un string en un array
     *
     * @since  1.3
     *
     * @param string $haystack un texto donde buscar.
     * @param array $needle los textos a buscar.
     */
    private function strpos_arr($haystack, $needle)
    {

        if (! is_array($needle)) {
            $needle = array( $needle );
        }

        foreach ($needle as $what) {
            if (( $pos = strpos($haystack, $what) ) !== false) {
                return $pos;
            }
        }
        return false;
    }

    /**
     * Añade la primera capa informativa en el carrito de la compra
     *
     * @since  1.3.3
     */
    public function wcgdprsettings_add_checkout_top_layer()
    {
        $pages = $this->plugin->pages;
        echo $pages->first_layer_privacy_view(
            __('Cumplir con la prestación contratada.', 'argpd'),
            null,
            __('Ejecución del contrato con el interesado.', 'argpd')
        );
    }

    /**
     * WooCommerce Checkout: Añade un checkbox para solicitar el consentimiento promocional en el carrito de la compra
     * Credits:
     * Técnico RGPD. https://wordpress.org/plugins/gdpr-settings-for-wc/
     * GPLv2. https://www.gnu.org/licenses/gpl-2.0.html
     *
     * @since  1.3.4
     *
     */
    public function wcgdprsettings_add_checkout_checkbox()
    {

        // Get label value.
        $settings = $this->plugin->argpd_settings->get_settings();
        $wc_gdprpromo_label = $settings['wc-consent-promo'];

        // Create only if has any value
        if (!$settings['option-wc-promo'] === 1) {
            return;
        }
        
        // Create form field
        $wc_gdprpromo_checkbox = [
            'type'  => 'checkbox',
            'class' => ['form-row wc_gdprpromo_checkbox'],
            'label_class' => ['woocommerce-form__label woocommerce-form__label-for-checkbox checkbox wc_gdprpromo_checkbox_label'],
            'input_class' => ['woocommerce-form__input woocommerce-form__input-checkbox input-checkbox wc_gdprpromo_checkbox_input'],
            'label' => sanitize_textarea_field($wc_gdprpromo_label)
        ];

        // Add custom WooCommerce form field.
        woocommerce_form_field('wc_gdprpromo_checkbox', $wc_gdprpromo_checkbox, __('Sí', 'argpd'));
    }

    /**
     * WooCommerce Checkout: update order meta with GDPR promo consent
     * Credits:
     * Técnico RGPD. https://wordpress.org/plugins/gdpr-settings-for-wc/
     * GPLv2. https://www.gnu.org/licenses/gpl-2.0.html
     *
     * @since  1.3.4
     *
     */
    function wcgdprsettings_update_order_meta_promo_consent($order_id)
    {
        if ((int) isset($_POST['wc_gdprpromo_checkbox']) && $_POST['wc_gdprpromo_checkbox'] === "1") {
            update_post_meta($order_id, 'wc_gdprpromo_checkbox', sanitize_text_field($_POST['wc_gdprpromo_checkbox']));

            //Fires custom action to third party integrations.
            do_action('wc_gdprpromo_after_user_consent');
        }
    }

    /**
     * WooCommerce Admin: display GDPR promo consent in WooCommerce Admin
     * Credits:
     * Técnico RGPD. https://wordpress.org/plugins/gdpr-settings-for-wc/
     * GPLv2. https://www.gnu.org/licenses/gpl-2.0.html
     *
     * @since  1.3.4
     *
     */
    function wcgdprsettings_display_admin_order_promo_consent($order)
    {
        echo '<p><strong>';
        echo __('Aceptar promociones', 'argpd') . ':</strong> ';
        echo (get_post_meta($order->get_id(), 'wc_gdprpromo_checkbox', true) === "1") ? __('Sí', 'argpd') : __('No', 'argpd');
        echo '</p>';
    }

    /**
     * WooCommerce Mails: display GDPR promo consent in 'new order mail' for admin
     * Credits:
     * Técnico RGPD. https://wordpress.org/plugins/gdpr-settings-for-wc/
     * GPLv2. https://www.gnu.org/licenses/gpl-2.0.html
     *
     * @since  1.3.4
     *
     */
    function wcgdprsettings_display_mail_order_promo_consent($order, $is_admin_email)
    {

        if ($is_admin_email) {
            echo '<p><strong>';
            echo __('Aceptar promociones', 'argpd') . ':</strong> ';
            echo ( get_post_meta($order->get_id(), 'wc_gdprpromo_checkbox', true) === "1" ) ? __('Sí', 'argpd') : __('No', 'argpd');
            echo '</p>';
        }
    }

    /**
     *
     * @since  1.3.7
     *
     */
    public function getUserIP() {
        // Get real visitor IP behind CloudFlare network
        if ( isset( $_SERVER["HTTP_CF_CONNECTING_IP"] ) ) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
            $ip = $client;
        } elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }
    
}
