<?php
namespace MageeShortcodes\Classes;
use MageeShortcodes\Classes\Config;

class Helper{
	private	$popup;
	private	$params;
	private	$shortcode;
	private $popup_title;
	private	$output;
	private	$errors;

	protected static $instance = null;
	public function __construct( $args = [] ) {

		add_action( 'plugins_loaded', array( $this, 'init' ) );

		add_action( 'media_buttons', array($this, 'add_shortcodes_button'));
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_button') );

		add_action( 'init',array($this, 'magee_register_post_types'),10) ;
		add_action( 'admin_menu',array($this, 'magee_admin_menu')) ;
		add_filter( "manage_edit-".MAGEE_PORTFOLIO."_columns",array($this, "magee_show_portfolio_columns"));
		add_action( "manage_posts_custom_column",array($this, "magee_portfolio_custom_columns"));

		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ));
		add_action( 'elementor/editor/before_enqueue_scripts', array($this, 'admin_scripts' ));
		add_action( 'wp_ajax_magee_shortcodes_popup', array($this, 'popup') );
		add_action( 'wp_ajax_nopriv_magee_shortcodes_popup', array($this, 'popup') );
		
		add_action( 'wp_ajax_magee_shortcode_form', array($this, 'shortcode_form') );
		add_action( 'wp_ajax_nopriv_magee_shortcode_form', array($this, 'shortcode_form') );
		
		add_action( 'wp_ajax_magee_create_shortcode', array($this, 'create_shortcode') );
		add_action( 'wp_ajax_nopriv_magee_create_shortcode', array($this, 'create_shortcode') );
			
		add_action( 'wp_ajax_live_preview', array($this, 'live_preview'));
		add_action( 'wp_ajax_nopriv_live_preview', array($this, 'live_preview'));
		
		add_action( 'wp_ajax_preview_js', array($this, 'preview_js'));
		add_action( 'wp_ajax_nopriv_preview_js', array($this, 'preview_js'));
		
		add_action( 'wp_ajax_magee_contact', array($this, 'magee_contact'));
		add_action('wp_ajax_nopriv_magee_contact', array($this, 'magee_contact'));
		
		add_action( 'wp_ajax_magee_contact_advanced', array($this, 'magee_contact_advanced'));
		add_action( 'wp_ajax_nopriv_magee_contact_advanced', array($this, 'magee_contact_advanced'));

		add_action( 'wp_enqueue_scripts', array($this, 'frontend_scripts' ));
	
		$this->init_shortcodes();

        require_once( MAGEE_SHORTCODES_DIR_PATH . 'gallery/featured-galleries.php' );

	}

	public static function init() {

	}

	public static function get_script_depends($args = []) {
		foreach ( $args as $h) {
			wp_enqueue_script($h);
		}
	}

	public static function get_style_depends($args = []) {
		foreach ( $args as $h) {
			wp_enqueue_style($h);
		}
	}

	function admin_scripts() {
		$min_suffix = Utils::is_script_debug() ? '' : '.min';
		global $pagenow;
		if (! empty($pagenow) && ('post-new.php' === $pagenow || 'post.php' === $pagenow )) {
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style('font-awesome', MAGEE_SHORTCODES_URL. 'assets/font-awesome/css/font-awesome.css', '', '4.4.0', false );
			wp_enqueue_style('magee-admin', MAGEE_SHORTCODES_URL.'assets/css/admin'.$min_suffix.'.css', '', MAGEE_SHORTCODES_VER, false );
			wp_enqueue_script( 'magee-admin', MAGEE_SHORTCODES_URL. 'assets/js/admin'.$min_suffix.'.js', array( 'jquery', 'wp-color-picker', 'wp-editor' ),MAGEE_SHORTCODES_VER, true );
			wp_enqueue_style('jquery-datetimepicker', MAGEE_SHORTCODES_URL. 'assets/datetimepicker/jquery.datetimepicker'.$min_suffix.'.css', '', '', false );
			wp_enqueue_script( 'jquery-datetimepicker', MAGEE_SHORTCODES_URL. 'assets/datetimepicker/jquery.datetimepicker.full'.$min_suffix.'.js', array( 'jquery'), '2.29.1', true );
			wp_localize_script(
				'magee-admin',
				'MSEditorL10n',
				array( 
					'insertShortcode' => __( 'Magee Shortcodes', 'magee-shortcodes' ),
					'doc' => __( 'Document', 'magee-shortcodes' ),
					'forums' => __( 'Forums', 'magee-shortcodes' ),
					'preview' => __( 'Live Preview', 'magee-shortcodes' ),
					'insert' => __( 'Insert shortcode', 'magee-shortcodes' ),
					'top' => __( 'Top', 'magee-shortcodes' ),
					'select_img' => __( 'Select Image', 'magee-shortcodes' ),
					'remove' => __( 'Remove', 'magee-shortcodes' ),
					'ver' => MAGEE_SHORTCODES_VER,
				)
			);
			wp_localize_script(
				'magee-admin',
				'MSGenerator',
				array( 
					'imgUrl' => MAGEE_SHORTCODES_URL.'assets/images/',
					'docUrl' => 'https://www.hoosoft.com/plugins/magee-shortcodes/',
					'forumUrl' => 'https://wordpress.org/support/plugin/magee-shortcodes/',
				)
			);
			wp_localize_script( 'magee-admin', 'magee_params', array(
				'ajaxurl'    => admin_url('admin-ajax.php'),
				'themeurl'   => MAGEE_SHORTCODES_URL. 'assets',
				'required'   => __(' is required', 'magee-shortcodes')
			));
		}
	}

	function frontend_scripts() {

		$scripts = Config::get_front_scripts();

		foreach ($scripts['styles'] as $k=>$v) {
			wp_register_style($k, $v[0], $v[1], $v[2], $v[3]);
		}

		foreach ($scripts['scripts'] as $k=>$v) {
			wp_register_script($k, $v[0], $v[1], $v[2], $v[3]);
		}

		wp_localize_script( 'magee-shortcodes', 'magee_params', array(
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'themeurl'   => MAGEE_SHORTCODES_URL. 'assets',
			'required'   => __(' is required', 'magee-shortcodes')
		));
	}
		
	//action to add a custom button to the content editor
	function add_shortcodes_button($args) {
		$target = is_string( $args ) ? $args : 'content';
		$title = __('Magee Shortcodes', 'magee-shortcodes');
		$context = "<a class='magee_shortcodes button' data-target='{$target}' title='{$title}'><span class='dashicons dashicons-shortcode' style='vertical-align: middle;padding-bottom: 2px;'></span> ".__("Magee Shortcodes", 'magee-shortcodes')."</a>";
		echo $context;
	}

	public static function block_editor_button() {
		$min_suffix = Utils::is_script_debug() ? '' : '.min';
		wp_enqueue_script(
			'magee-shortcodes-block-editor',
			MAGEE_SHORTCODES_URL.'assets/js/block-editor'.$min_suffix.'.js',
			array( 'wp-element', 'wp-editor', 'wp-components', 'wp-block-editor' ),
			MAGEE_SHORTCODES_VER,
			true
		);

		wp_localize_script(
			'magee-shortcodes-block-editor',
			'MSBlockEditorL10n',
			array( 
				'insertShortcode' => __( 'Magee Shortcodes', 'magee-shortcodes' ),
				'doc' => __( 'Document', 'magee-shortcodes' ),
				'forums' => __( 'Forums', 'magee-shortcodes' ),
				'ver' => MAGEE_SHORTCODES_VER,
			)
		);

		wp_localize_script(
			'magee-shortcodes-block-editor',
			'MSBlockSettings',
			array( 
				'supportedBlocks' => Config::supported_blocks(),
				'docUrl' => 'https://www.hoosoft.com/plugins/magee-shortcodes/',
				'forumUrl' => 'https://wordpress.org/support/plugin/magee-shortcodes/',
			)
		);

	}
	/**
	 * Popup function which will show shortcode options in thickbox.
	 */
	function popup() {
		$magee_shortcodes = Config::shortcodes();
		$target = isset($_GET['target']) ?  $_GET['target'] : 'content';
		?>
		<div class="white-popup magee_shortcodes_container" data-target="<?php echo esc_attr($target);?>" id="magee_shortcodes_container">
		<input type="text" class="magee-form-text magee-input" placeholder="<?php _e( 'Search', 'magee-shortcodes' );?>" name="magee_shortcode_search" id="magee_shortcode_search" value="">
			<form>
				<div class="magee_shortcodes_header_container">
					<ul class="magee_shortcodes_list row">
					<?php if (is_array($magee_shortcodes )):foreach ($magee_shortcodes as $key => $val) { 	
						if ( is_array( $val ) && isset($val['popup_title']) && $val['popup_title']!='' ):
							$popup_title = esc_attr($val['popup_title']);
					?>
					<li class="col-md-3">
					<a class='magee_shortcode_item <?php //echo $key;?>' title='<?php echo $popup_title;?>' data-shortcode="<?php echo esc_attr($key);?>" href="javascript:;"> <?php if ( isset($val['icon']) ) {?><i class="fa <?php echo esc_attr($val['icon']);?>"></i> <?php }?> <?php echo str_replace(' Shortcode', '', $popup_title);?></a> </li>
					<?php endif;?>
					<?php } ?>
					<?php endif;?>
					</ul>
					<div class="clear"></div>
				</div>
				
				<div id="magee-shortcodes-settings">
					<div id="magee-shortcodes-settings-inner"></div>
					<input name="magee-shortcode" type="hidden" id="magee-shortcode" value="" />
					<input name="magee-shortcode-textarea" type="hidden" id="magee-shortcode-textarea" value="" /> 
					<div id="preview" style="display:none">
						<div class="label preview-title">
							<span class="magee-form-label-title"><?php _e( 'Preview', 'magee-shortcodes' );?></span>
							<span class="magee-form-desc"><?php _e( 'Due to some external reasons, the preview is not shown exactly the same as reality.', 'magee-shortcodes' );?></span>
							<span class="magee-preview-delete tb-close-icon"></span>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</form>
			<div class="clear"></div>
			<div class="magee-shortcodes-settings-inner-clone hidden"></div>
		</div>
	<?php
		die();
	}

	/**
	* Return an instance of this class.
	*
	* @return object A single instance of this class.
	*/
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	// Taxonomies
	public static function shortcodes_categories ( $taxonomy, $empty_choice = false ) {
		if ( $empty_choice == true ) {
			$post_categories[''] = __( 'Default', 'magee-shortcodes' );
		}
		$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy); 

		if ( ! array_key_exists('errors', $get_categories) ) {
			if ( $get_categories && is_array($get_categories) ) {
				foreach ( $get_categories as $cat ) {
					if (isset($cat->slug) && isset($cat->name))
						$post_categories[$cat->slug] = $cat->name;
				}
			}

			if ( isset( $post_categories ) ) {
				return $post_categories;
			}
		}
	}
		
	public function shortcode_form() {
		$magee_shortcodes = Config::shortcodes();
		$this->popup = esc_attr($_POST['shortcode']);
		$shortcode = $this->popup;
		$currentEditor = esc_attr($_POST['currentEditor']);
		$remark = '';
		if ('dummy_image'==$this->popup)
			$remark = __( '( http only, https sites are not supported. )', 'magee-shortcodes' );

		if ( $shortcode && isset($magee_shortcodes[$shortcode]) ) {
			if ( isset($magee_shortcodes[$shortcode]['child_shortcode'])) {
				echo '<h2 class="shortcode-name">'.$magee_shortcodes[$shortcode]['popup_title'].'</h2>';

				if (isset($magee_shortcodes[$shortcode]['name'])) {
					echo '<div class="example-list">'.sprintf(__('Want to know more about this shortcode? Check <a class="example-link" target="_blank" href="%1$s"> Examples of use</a>. %2$s', 'magee-shortcodes' ), 'https://www.hoosoft.com/plugins/magee-shortcodes/'.$magee_shortcodes[$_POST['shortcode']]['name'], $remark).'</div>';
				} 
				
				echo $this->formate_shortcode();
				echo '<div class="column-shortcode-inner">'.$this->formate_children_shortcode().'</div>';
				echo '<div class="shortcode-add"><a href="#" class="child-shortcode-add">add</a></div>';
				
			} else {
				echo '<h2 class="shortcode-name">'.$magee_shortcodes[$shortcode]['popup_title'].'</h2>';
				if (isset($magee_shortcodes[$shortcode]['name'])) {
					echo '<div class="example-list">'.sprintf(__('Want to know more about this shortcode? Check <a class="example-link" target="_blank" href="%1$s"> Examples of use</a>. %2$s', 'magee-shortcodes' ), 'https://www.hoosoft.com/plugins/magee-shortcodes/'.$magee_shortcodes[$_POST['shortcode']]['name'], $remark).'</div>';
				} 
				
				echo $this->formate_shortcode();
			}
			echo '<input type="hidden" id="currentEditor" value="'.$currentEditor.'" />';
			echo '<input type="hidden" id="no_preview" value="'.$magee_shortcodes[$shortcode]['no_preview'].'" />';
		}
			
		exit(0);
	}

	function init_shortcodes() {
		foreach ( glob( MAGEE_SHORTCODES_DIR_PATH . 'shortcodes/*.php' ) as $filename ) {
			require_once $filename;
		}
	}
	
	/**
	 * Function to get the default shortcode param values applied.
	 */
	public static function set_shortcode_defaults( $defaults, $args ) {
			
		if ( ! $args ) {
			$$args = array();
		}
		$args = shortcode_atts( $defaults, $args );		
	
		foreach ( $args as $key => $value ) {
			if ( $value == '' || 
				$value == '|' 
			) {
				$args[$key] = $defaults[$key];
			}
		}
		return $args;
	}
	
	// fix shortcodes
	public static function fix_shortcodes($content) {
		$replace_tags_from_to = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']',
			']<br>' => ']',
			']\r\n' => ']',
			']\n' => ']',
			']\r' => ']',
			'\r\n[' => '[',
		);

		return strtr( $content, $replace_tags_from_to );
	}
		
	public static function unrecognize_shortcodes($content) {
		$pre  = "/<pre(.*?)>(.*?)<\/pre>/";  
		preg_match_all($pre, $content, $result);
		$count = count($result);
		foreach ( $result as $val) {
			foreach ( $val as $cval) {
				$ck = str_replace('[', "&#91;",strval($cval));
				$content = str_replace($val, $ck, $content);
			}
		}  
		return $content;
	}

	public static function colourBrightness($hex, $percent) {
		$hash = '';
		if (stristr($hex, '#')) {
			$hex = str_replace('#', '', $hex);
			$hash = '#';
		}
		$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
		for ($i=0; $i<3; $i++) {
			if ($percent > 0) {
				$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
			} else {
				$positivePercent = $percent - ($percent*2);
				$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
			}
			if ($rgb[$i] > 255) {
				$rgb[$i] = 255;
			}
		}
		$hex = '';
		for($i=0; $i < 3; $i++) {
			$hexDigit = dechex($rgb[$i]);
			if (strlen($hexDigit) == 1) {
			$hexDigit = "0" . $hexDigit;
			}
			$hex .= $hexDigit;
		}
		return $hash.$hex;
	}

	public static function rgb2hsl( $hex_color ) {

		$hex_color    = str_replace( '#', '', $hex_color );

		if ( strlen( $hex_color ) < 3 ) {
			str_pad( $hex_color, 3 - strlen( $hex_color ), '0' );
		}

		$add         = strlen( $hex_color ) == 6 ? 2 : 1;
		$aa          = 0;
		$add_on      = $add == 1 ? ( $aa = 16 - 1 ) + 1 : 1;

		$red         = round( ( hexdec( substr( $hex_color, 0, $add ) ) * $add_on + $aa ) / 255, 6 );
		$green       = round( ( hexdec( substr( $hex_color, $add, $add ) ) * $add_on + $aa ) / 255, 6 );
		$blue        = round( ( hexdec( substr( $hex_color, ( $add + $add ) , $add ) ) * $add_on + $aa ) / 255, 6 );

		$hsl_color    = array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

		$minimum     = min( $red, $green, $blue );
		$maximum     = max( $red, $green, $blue );

		$chroma      = $maximum - $minimum;

		$hsl_color['lum'] = ( $minimum + $maximum ) / 2;

		if ( $chroma == 0 ) {
			$hsl_color['lum'] = round( $hsl_color['lum'] * 100, 0 );

			return $hsl_color;
		}

		$range = $chroma * 6;

		$hsl_color['sat'] = $hsl_color['lum'] <= 0.5 ? $chroma / ( $hsl_color['lum'] * 2 ) : $chroma / ( 2 - ( $hsl_color['lum'] * 2 ) );

		if ( $red <= 0.004 || 
			$green <= 0.004 || 
			$blue <= 0.004 
		) {
			$hsl_color['sat'] = 1;
		}

		if ( $maximum == $red ) {
			$hsl_color['hue'] = round( ( $blue > $green ? 1 - ( abs( $green - $blue ) / $range ) : ( $green - $blue ) / $range ) * 255, 0 );
		} else if ( $maximum == $green ) {
			$hsl_color['hue'] = round( ( $red > $blue ? abs( 1 - ( 4 / 3 ) + ( abs ( $blue - $red ) / $range ) ) : ( 1 / 3 ) + ( $blue - $red ) / $range ) * 255, 0 );
		} else {
			$hsl_color['hue'] = round( ( $green < $red ? 1 - 2 / 3 + abs( $red - $green ) / $range : 2 / 3 + ( $red - $green ) / $range ) * 255, 0 );
		}

		$hsl_color['sat'] = round( $hsl_color['sat'] * 100, 0 );
		$hsl_color['lum']  = round( $hsl_color['lum'] * 100, 0 );

		return $hsl_color;
	}

	/**
	 * Function to apply attributes to HTML tags.
	*/
		 
	public static function attributes( $slug, $attributes = array() ) {

		$out = '';
		$attr = apply_filters( "magee_attr_{$slug}", $attributes );

		if ( empty( $attr ) ) {
			$attr['class'] = $slug;
		}

		foreach ( $attr as $name => $value ) {
			$out .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
		}

		return trim( $out );

	}
// get summary

	public static function get_summary( $excerpt_length = false, $excerpt_or_content=false ) {
	
		if ( $excerpt_or_content == 'full_content' ) {
			$output = get_the_content();
		} else {
			$output = get_the_excerpt();
			if ( is_numeric($excerpt_length) && $excerpt_length !=0  )
				$output = self::get_content_length($output, $excerpt_length );
		}
		return  $output;
	}
	 
	public static  function get_content_length($content, $limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ", $excerpt).'...';
		} else {
			$excerpt = implode(" ", $excerpt);
		} 
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
		return $excerpt;
    }
	
 
	/*----------------------------------------------------------------------------*
	* Register custom post types
	*----------------------------------------------------------------------------*/

	function magee_register_post_types() {
		
		$portfolio_slug = MAGEE_PORTFOLIO_SLUG;
		
		register_post_type(
			MAGEE_PORTFOLIO ,
			array(
				'labels' => array(
					'name' 			=> __('Portfolio', 'magee-shortcodes'),
					'singular_name' => __('Portfolio', 'magee-shortcodes'),
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => $portfolio_slug
				),
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'query_var' => true,
				'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
				'can_export' => true,
			)
		);

		register_taxonomy('portfolio-category', MAGEE_PORTFOLIO, array('hierarchical' => true, 'label' => __('Portfolio Categories', 'magee-shortcodes'), 'query_var' => true, 'show_ui' => true, 'rewrite' => true));
		//register_taxonomy('portfolio_skills', 'magee_portfolio', array('hierarchical' => true, 'label' => 'Skills', 'query_var' => true, 'rewrite' => true));
		register_taxonomy('portfolio-tag', MAGEE_PORTFOLIO, array('hierarchical' => false, 'label' =>  __('Tags', 'magee-shortcodes'), 'query_var' => true, 'rewrite' => true));	
			
	}

	function magee_show_portfolio_columns($columns) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => __("Title", 'magee-shortcodes'),
			"portfolio-tag" => __("Portfolio Tags", 'magee-shortcodes'),
			"portfolio-category" => __("Portfolio Categories", 'magee-shortcodes'),
			"date" => "date");
			
		return $columns;
		
	}

	function magee_portfolio_custom_columns($column) {
		global $post;
		
		switch ($column) {
			case "portfolio-tag":
			echo get_the_term_list($post->ID, 'portfolio-tag', '', ', ', '');
			break;
			case "portfolio-category":
			echo get_the_term_list($post->ID, 'portfolio-category', '', ', ', '');
			break;
		}
	}

	function magee_admin_menu() {
		global $submenu;
		unset( $submenu['edit.php?post_type=thememagee_elastic'][10] );
	}


	/**
	 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
	 */
	public static function get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
		global $wpcommentspopupfile, $wpcommentsjavascript;
	
		$id = get_the_ID();
	
		if ( false === $zero ) $zero = __( 'No Comments', 'magee-shortcodes');
		if ( false === $one ) $one = __( '1 Comment', 'magee-shortcodes');
		if ( false === $more ) $more = __( '% Comments', 'magee-shortcodes');
		if ( false === $none ) $none = __( 'Comments Off', 'magee-shortcodes');
	
		$number = get_comments_number( $id );
		$str = '';
	
		if ( 0 == $number && !comments_open() && !pings_open() ) {
			$str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
			return $str;
		}
	
		if ( post_password_required() ) {
		
			return '';
		}

		$str = '<a href="';
		if ( $wpcommentsjavascript ) {
			if ( empty( $wpcommentspopupfile ) )
				$home = home_url();
			else
				$home = get_option('siteurl');
			$str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
			$str .= '" onclick="wpopen(this.href); return false"';
		} else { // if comments_popup_script() is not in the template, display simple comment link
			if ( 0 == $number )
				$str .= get_permalink() . '#respond';
			else
				$str .= get_comments_link();
			$str .= '"';
		}
	
		if ( !empty( $css_class ) ) {
			$str .= ' class="'.$css_class.'" ';
		}
		$title = the_title_attribute( array('echo' => 0 ) );
	
		$str .= apply_filters( 'comments_popup_link_attributes', '' );
	
		$str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'magee-shortcodes'), $title ) ) . '">';
		$str .= self::get_comments_number_str( $zero, $one, $more );
		$str .= '</a>';
		
		return $str;
	}
 
	/**
	 * Convert Hex Code to RGB
	 * @param  string $hex Color Hex Code
	 * @return array       RGB values
	 */
	public static function hex2rgb( $hex ) {
		if ( strpos( $hex, 'rgb' ) !== FALSE ) {

			$rgb_part = strstr( $hex, '(' );
			$rgb_part = trim($rgb_part, '(' );
			$rgb_part = rtrim($rgb_part, ')' );
			$rgb_part = explode( ', ', $rgb_part );

			$rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

		} elseif ( $hex == 'transparent' ) {
			$rgb = array( '255', '255', '255', '0' );
		} else {

			$hex = str_replace( '#', '', $hex );

			if ( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );
		}

		return $rgb; // returns an array with the rgb values
	}
  
	/**
	 * Modifies WordPress's built-in comments_number() function to return string instead of echo
	 */
	public static function get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
		if ( !empty( $deprecated ) )
			_deprecated_argument( __FUNCTION__, '1.3' );
	
		$number = get_comments_number();
	
		if ( $number > 1 )
			$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'magee-shortcodes') : $more);
		elseif ( $number == 0 )
			$output = ( false === $zero ) ? __('No Comments', 'magee-shortcodes') : $zero;
		else
			$output = ( false === $one ) ? __('1 Comment', 'magee-shortcodes') : $one;
	
		return apply_filters('comments_number', $output, $number);
	}

	function create_shortcode() {
		$magee_shortcodes = Config::shortcodes();
	
		$shortcode = '';

		if ( isset( $magee_shortcodes ) && is_array( $magee_shortcodes ) && isset($_POST['shortcode']) ) {
			
			$popup     = $_POST['shortcode'];
			
			$params    = $magee_shortcodes[$popup]['params'];
			
			$shortcode = $magee_shortcodes[$popup]['shortcode'];

			$attrs     = array();
			if ( isset( $_POST['attr'] ) ):
			foreach ( $_POST['attr'] as $attr) {
				$attrs[str_replace('magee_', '', $attr['name'])] = $attr['value'];
				if (stristr($attr['name'], 'checkbox_')) {
				    $attr['name'] = str_replace('checkbox_', '', $attr['name']);
					$checkdata = explode('--', $attr['name']);
					if (isset($attrs[$checkdata[0]]) && $attrs[$checkdata[0]] !== '') {
					  $attrs[$checkdata[0]] .= ', '.$checkdata[1];
					  } else {
					  $attrs[$checkdata[0]] = $checkdata[1];
					  }
				    }
				}
				
			foreach ( $params as $pkey => $param )
			{
			
				if ( isset($attrs[$pkey] )) {	
					$shortcode = str_replace('{{'.$pkey.'}}', $attrs[$pkey], $shortcode);
				} else {
					$shortcode = str_replace('{{'.$pkey.'}}', '', $shortcode);
				}
			}
			endif;

			if ( isset($magee_shortcodes[$popup]['child_shortcode'])):
			
			      $common = array_slice($_POST['attr'], count($_POST['attr'])-2, 2) ;
                  array_splice($_POST['attr'], count($_POST['attr'])-2, 2);
				  $number = count($magee_shortcodes[$popup]['child_shortcode']['params']);
				  $expcet = count($magee_shortcodes[$popup]['params']);
				  array_splice($_POST['attr'], 0, $expcet);
                  $loop = array_chunk($_POST['attr'], $number);
			      $i = '';
				  $copyshortcode = '';

				  for( $i=0;$i<count($loop);$i++) {
	   
				   $cparams = $magee_shortcodes[$popup]['child_shortcode']['params'];
			
			       $cshortcode = $magee_shortcodes[$popup]['child_shortcode']['shortcode'];
			       $attrs = array();
				   $perattr = array_merge($loop[$i], $common); 
				   
				   foreach ( $perattr as $attr) { 
			   
				   $attrs[str_replace('magee_', '', $attr['name'])] = $attr['value'];
										  }
				   foreach ( $cparams as $cpkey => $cparam )
				   {
				
					if ( isset($attrs[$cpkey] )) {
						
						$cshortcode = str_replace('{{'.$cpkey.'}}', $attrs[$cpkey], $cshortcode);
						
						} else {
							$cshortcode = str_replace('{{'.$cpkey.'}}', '', $cshortcode);
						}
					}
				    $copyshortcode .= $cshortcode;
					
				  }  
				  $shortcode = str_replace('{{child_shortcode}}', $copyshortcode, $shortcode); 
				  
			   
			endif;
			
		}
		$shortcode = str_replace('\\\'', '\'', $shortcode);
		$shortcode = str_replace('\\"', '"', $shortcode);
		$shortcode = str_replace('\\\\', '\\', $shortcode);
	    echo $shortcode;
		exit();
	}
	
	private function formate_shortcode() {

		$magee_portfolios_cats = self::shortcodes_categories('portfolio-category',true);
		$magee_shortcodes = Config::shortcodes();
        $output = '';

		unset($magee_shortcodes['shortcode-generator']['params']['select_shortcode']);
		if ( isset( $magee_shortcodes ) && is_array( $magee_shortcodes ) && isset( $magee_shortcodes[$this->popup]['params'] ) )
		{

			$this->params = $magee_shortcodes[$this->popup]['params'];
			$this->shortcode = $magee_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $magee_shortcodes[$this->popup]['popup_title'];

			// adds stuff for js use
			$this->append_output( "\n" . '<div id="_magee_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_magee_popup" class="hidden">' . $this->popup . '</div>' );
            
			// filters and excutes params
			if ( $this->params  ):
			foreach ( $this->params as $pkey => $param )
			{
				
				$pkey = 'magee_' . $pkey;
				if (!isset($param['std'])) {
					$param['std'] = '';
				}

				if (!isset($param['desc'])) {
					$param['desc'] = '';
				}

				// popup form row start
				$row_start  = '<div class="param-item">' . "\n";
				$row_start .= '<div class="form-row row" class="' . $pkey . '">' . "\n";
				if ($param['type'] != 'info') {
					$row_start .= '<div class="label">';
					$row_start .= '<span class="magee-form-label-title">' . $param['label'] . '</span>' . "\n";
					$row_start .= '<span class="magee-form-desc">' . $param['desc'] . '</span>' . "\n";
					$row_start .= '</div>' . "\n";
				}
				$row_start .= '<div class="field">' . "\n";

				// popup form row end
				$row_end   = '</div>' . "\n";
				$row_end   .= '</div>' . "\n";
				$row_end   .= '</div>' . "\n";

				switch( $param['type'] )
				{
					case 'text' :
						$output .= $row_start;
						$output .= '<input type="text" class="magee-form-text magee-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'textarea' :
						$output .= $row_start;
						ob_start();
						wp_editor( $param['std'], $pkey, array( 'editor_class' => 'magee_tinymce', 'media_buttons' => true ) );
						$editor_contents = ob_get_clean();
						$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="magee-form-textarea magee-input">' . $param['std'] . '</textarea>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'select' :
						$output .= $row_start;
						$output .= '<div class="magee-form-select-field">';
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="magee-form-select magee-input">' . "\n";

						foreach ( $param['options'] as $value => $option )
						{
							$selected = (isset($param['std']) && $param['std'] == $value) ? 'selected="selected"' : '';
							$output .= '<option value="' . $value . '"' . $selected . '>' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= '</div>';
						$output .= $row_end;
						$this->append_output( $output );
						break;
					case 'more_select' :
						$output .= $row_start;
						$output .= '<div class="magee-form-select-field">';
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="magee-form-select magee-input" size="10">' . "\n";

						foreach ( $param['options'] as $value => $option )
						{
							$selected = (isset($param['std']) && $param['std'] == $value) ? 'selected="selected"' : '';
							$output .= '<option value="' . $value . '"' . $selected . '>' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= '</div>';
						$output .= $row_end;
						$this->append_output( $output );
						break;	

					case 'multiple_select' :
						$output .= $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" multiple="multiple" class="magee-form-multiple-select magee-input">' . "\n";

						if ( $param['options'] && is_array($param['options']) ) {
							foreach ( $param['options'] as $value => $option )
							{
								$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'checkbox' :
						$output .= $row_start;
						if ($param['options'] && is_array($param['options'])) {
						    foreach ( $param['options'] as $value => $option )
								{
								    $value   = 'checkbox_'.$param['sid'].'--'.$value;  
								    $output .= '<label for="' . $value . '" class="magee-form-checkbox">' . "\n";
								    $output .= '<input type="checkbox" class="magee-input" name="' . $value . '" id="' . $value . '" ' .$option['checked']. ' />' . "\n";
						            $output .= ' ' . $option['checkbox_text'] . '</label>' . "\n";
								}
						}
						
						$output .= $row_end;
						$this->append_output( $output );
						break;	
						
					case 'uploader' :
						$output .= $row_start;
						$output .= '<div class="magee-upload-container">';
						$output .= '<img src="" alt="Image" class="uploaded-image" />';
						$output .= '<input type="text" class="magee-form-text magee-form-upload magee-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= '<a href="' . $pkey . '" class="button magee-upload-button" data-upid="' . $pkey . '">'.__('Upload', 'magee-shortcodes').'</a>';
						$output .= '</div>';
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'gallery' :

						if (!isset($cpkey)) {
							$cpkey = '';
						}
						$output .= $row_start;;
						$output .= '<a href="' . $cpkey . '" class="magee-gallery-button magee-shortcodes-button">'.__('Attach Images to Gallery', 'magee-shortcodes').'</a>';
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'iconpicker' :
						$output .= $row_start;
						$output .= '<div class="icon-val"><input type="text" class="magee-form-text magee-input" style="display:block" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';	
						$output .= '<button type="button" id="custom_icon" class="button magee_custom_icon custom_icon">'.__('Icon Picker', 'magee-shortcodes').'</button>'. "\n";	
						$output .= '<button type="button" id="insert-media-button" class="button magee-upload-button" data-editor="content" data-upid="' . $pkey . '"><span class="wp-media-buttons-icon">'.__('Upload', 'magee-shortcodes').'</span></button>' . "\n";	
						$output .= "</div>\n";
						$output .= '<div class="iconpicker">';
				        
						foreach ( $param['options'] as $value => $option ) {
							$output .= '<i class="fa ' . $value . '" data-name="' . $value . '"></i>';
						}
						$output .= '</div>';

						if (!isset($param['std'])) {
							$param['std'] = '';
						}
						
						$output .= $row_end;
						$this->append_output( $output );
						break;
					case 'icon' :
						$output .= $row_start;
						$output .= '<div class="icon-val"><input type="text" class="magee-form-text magee-input" style="display:block" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';	
						$output .= '<button type="button" id="custom_icon" class="button magee_custom_icon custom_icon">'.__('Icon Picker', 'magee-shortcodes').'</button>'. "\n";	
						$output .= "</div>\n";
						$output .= '<div class="iconpicker">';
						
						foreach ( $param['options'] as $value => $option ) {
						
							$output .= '<i class="fa ' . $value . '" data-name="' . $value . '"></i>';
							
						}
						$output .= '</div>';

						if (!isset($param['std'])) {
							$param['std'] = '';
						}

						$output .= $row_end;
						$this->append_output( $output );
						break;
					 
					case 'colorpicker' :

						if (!isset($param['std'])) {
							$param['std'] = '';
						}

						$output .= $row_start;
						$output .= '<input type="text" class="magee-form-text magee-input wp-color-picker-field" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'info' :
						$output .= $row_start;
						$output .= '<p>' . $param['std'] . "</p>\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;

					case 'size' :
						$output .= $row_start;
						$output .= '<div class="magee-form-group">' . "\n";
						$output .= '<label>'.__('Width', 'magee-shortcodes').'</label>' . "\n";
						$output .= '<input type="text" class="magee-form-text magee-input" name="' . $pkey . '_width" id="' . $pkey . '_width" value="' . $param['std'] . '" />' . "\n";
						$output  .= '</div>' . "\n";
						$output .= '<div class="magee-form-group last">' . "\n";
						$output .= '<label>'.__('Height', 'magee-shortcodes').'</label>' . "\n";
						$output .= '<input type="text" class="magee-form-text magee-input" name="' . $pkey . '_height" id="' . $pkey . '_height" value="' . $param['std'] . '" />' . "\n";
						$output .= '</div>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
						break;
						
					case 'number':
						$output .= $row_start;
						$output .= '<div class="probar"><div class="probar-control"></div></div>'. "\n";;
						$output .= '<input type="number" class="magee-form-number" name="'.$pkey.'" id="'.$pkey.'" max="'.$param['max'].'" min="'.$param['min'].'" step="1" value="'.$param['std'].'"/>'. "\n";
						$output .= $row_end;

						$this->append_output( $output );
						break;
						
					case 'choose' :
						$output .= $row_start;
						$output .= '<div class="choose-show">' . "\n";
						if ( $param['options'] && is_array($param['options']) ) {
							foreach ( $param['options'] as $value => $option )
								{
								    $selected = (isset($param['std']) && $param['std'] == $value) ? 'style="display:block"' : ''; 
									$output .= '<span class="choose-show-param" name="'.$value.'" '.$selected.'>' .$option. '</span>' . "\n";
								}
							}
						$output .= '</div>' . "\n";
                        $output .= '<input type="hidden" class="magee-form-choose" value="' . $param['std'] . '" name="'.$pkey.'" id="'.$pkey.'"/>'. "\n"; 
						
						$output .= $row_end;
						$this->append_output( $output );
						
						break;
						
					case 'datepicker' :
					
						$output .= $row_start;
						$output .= '<input type="text" class="magee-form-datetime" name="'.$pkey.'" id="'.$pkey.'" value="'.$param['std'] .'">';						$output .= $row_end;

						$this->append_output( $output );
						
						break;
						
					case 'link' :
						// prepare
						$output .= $row_start;
						$output .= '<div class="icon-val"><input type="text" class="magee-form-text magee-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';	
						$output .= '<button type="button" id="insert-media-button" class="button magee-upload-button" data-editor="content" data-upid="' . $pkey . '"><span class="wp-media-buttons-icon">'.__('Upload', 'magee-shortcodes').'</span></button>' . "\n";	
						$output .= '</div>' . "\n";	
						$output .= $row_end;
					    // append
						$this->append_output( $output );
						
						break;
					case 'editor' :
				
						$output .= $row_start;
						$content   = $param['std'];
						$editor_id = $pkey;
						ob_start();
						wp_editor( $content, $editor_id );
						$temp = ob_get_clean();
						$temp .= \_WP_Editors::enqueue_scripts();
						$temp .= print_footer_scripts();
						$temp .= \_WP_Editors::editor_js();
						$output .= $temp;
						$this->append_output( $output );
						
						break;
				}     
			}
			endif;
		}

		return $output;
		
	}
	//children format shortcode
	private function formate_children_shortcode() {
		$magee_shortcodes = Config::shortcodes();

        $output = '';
		unset($magee_shortcodes['shortcode-generator']['params']['select_shortcode']);

		if ( isset( $magee_shortcodes ) && is_array( $magee_shortcodes ) )
		{
		    if ( isset( $magee_shortcodes[$this->popup]['child_shortcode']) ) {

				$this->cparams = $magee_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $magee_shortcodes[$this->popup]['child_shortcode']['shortcode'];
				
                $output_child  = "\n" . '<div id="_magee_cshortcode" class="hidden">' . $this->cshortcode . '</div>' ;
			    
				
			    $output .= $output_child;
				$this->append_output($output);

				foreach ( $this->cparams as $cpkey => $cparam )
				{

					$cpkey = 'magee_' . $cpkey;

					if (!isset($cparam['std'])) {
						$cparam['std'] = '';
					}

					if (!isset($cparam['desc'])) {
						$cparam['desc'] = '';
					}
                    
				    $row_start  = '<div class="param-item">' . "\n";
				    $row_start .= '<div class="form-row row" class="' . $cpkey . '">' . "\n";
				    if ($cparam['type'] != 'info') {
						$row_start .= '<div class="label">';
						$row_start .= '<span class="magee-form-label-title">' . $cparam['label'] . '</span>' . "\n";
						$row_start .= '<span class="magee-form-desc">' . $cparam['desc'] . '</span>' . "\n";
						$row_start .= '</div>' . "\n";
					}
					$row_start .= '<div class="field">' . "\n";
	
					// popup form row end
					$row_end   = '</div>' . "\n";
					$row_end   .= '</div>' . "\n";
					$row_end   .= '</div>' . "\n";

					switch( $cparam['type'] )
					{
						case 'text' :
							$output_child  = $row_start;
							$output_child .= '<input type="text" class="magee-form-text magee-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$output_child .= $row_end;
							$output .= $output_child;
				            $this->append_output($output);
							break;
						case 'textarea' :
							$output_child  = $row_start;
							$output_child .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="magee-form-textarea magee-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$output_child .= $row_end;
							$output .= $output_child;
				            $this->append_output($output);
							break;

						case 'select' :
							$output_child  = $row_start;
							$output_child .= '<div class="magee-form-select-field">';
						    $output_child .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="magee-form-select magee-input">' . "\n";
						
						    foreach ( $cparam['options'] as $value => $option )
						    {
							    $selected = (isset($cparam['std']) && $cparam['std'] == $value) ? 'selected="selected"' : '';
						  	    $output_child .= '<option value="' . $value . '"' . $selected . '>' . $option . '</option>' . "\n";
						    }

							$output_child .= '</select>' . "\n";
							$output_child .= '</div>';
							$output_child .= $row_end;
							$output .= $output_child;
				            $this->append_output($output);

							break;
							
                        case 'number':
						$output .= $row_start;; 
						$output .= '<div class="probar"><div class="probar-control"></div></div>'. "\n";;
						$output .= '<input type="number" class="magee-form-number" name="'.$cpkey.'" id="'.$cpkey.'" max="'.$cparam['max'].'" min="'.$cparam['min'].'" step="1" value="'.$cparam['std'].'"/>'. "\n";
						$output .= $row_end;	

						$this->append_output( $output );

						break;
						 
						case 'checkbox' :
							$output_child  = $row_start;
							$output_child .= '<label for="' . $cpkey . '" class="magee-form-checkbox">' . "\n";
							$output_child .= '<input type="checkbox" class="magee-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$output_child .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$output_child .= $row_end;

							$output .= $row_end;
				            $this->append_output($output);

							break;

						case 'uploader' :

							if (!isset($cparam['std'])) {
								$cparam['std'] = '';
							}

							$output_child  = $row_start;
							$output_child .= '<div class="magee-upload-container">';
							$output_child .= '<img src="" alt="Image" class="uploaded-image" />';
							$output_child .= '<input type="hidden" class="magee-form-text magee-form-upload magee-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$output_child .= '<a href="' . $cpkey . '" class="magee-upload-button" data-upid="1">Upload</a>';
							$output_child .= '</div>';
							$output_child .= $row_end;

							$output .= $output_child;
				            $this->append_output($output);

							break;

						case 'colorpicker' :
							$output_child  = $row_start;
							$output_child .= '<input type="text" class="magee-form-text magee-cinput wp-color-picker-field" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$output_child .= $row_end;

							$output .= $output_child;
				            $this->append_output($output);

							break;
							
						case 'choose' :

						$output_child = $row_start;
						$output_child .= '<div class="choose-show">' . "\n";
						if ( $cparam['options'] && is_array($cparam['options']) ) {
							foreach ( $cparam['options'] as $value => $option )
								{
								    $selected = (isset($cparam['std']) && $cparam['std'] == $value) ? 'style="display:block"' : ''; 
									$output_child .= '<span class="choose-show-param" name="'.$value.'" '.$selected.'>' .$option. '</span>' . "\n";
								}
							}
						$output_child .= '</div>' . "\n";
                        $output_child .= '<input type="hidden" class="magee-form-choose" value="' . $cparam['std'] . '" name="'.$cpkey.'" id="'.$cpkey.'"/>'. "\n"; 
						
						$output_child .= $row_end;
					    // append
						$output .= $output_child;
						$this->append_output( $output );
						
						break;
						
                        case 'iconpicker' :

						// prepare
						$output_child = $row_start;
						$output_child .= '<div class="icon-val"><input type="text" class="magee-form-text magee-input" style="display:block" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />';	
						$output_child .= '<button type="button" id="custom_icon" class="button magee_custom_icon custom_icon">'.__('Icon Picker', 'magee-shortcodes').'</button>'. "\n";	
						$output_child .= '<button type="button" id="insert-media-button" class="button magee-upload-button" data-editor="content" data-upid="' . $cpkey . '"><span class="wp-media-buttons-icon">'.__('Upload', 'magee-shortcodes').'</span></button>' . "\n";	
						$output_child .= "</div>\n";
						
						$output_child .= '<div class="iconpicker">';
							
				        
						foreach ( $cparam['options'] as $value => $option ) {
							$output_child .= '<i class="fa ' . $value . '" data-name="' . $value . '"></i>';
						}
						$output_child .= '</div>';

						if (!isset($cparam['std'])) {
							$cparam['std'] = '';
						}
						
						$output_child .= $row_end;

						$output .= $output_child;
						$this->append_output( $output );

						break;
						
						case 'icon' :
						$output_child = $row_start;
						$output_child .= '<div class="icon-val"><input type="text" class="magee-form-text magee-input" style="display:block" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />';	
						$output_child .= '<button type="button" id="custom_icon" class="button magee_custom_icon custom_icon">'.__('Icon Picker', 'magee-shortcodes').'</button>'. "\n";	
						$output_child .= "</div>\n";
						
						$output_child .= '<div class="iconpicker">';
				        
						foreach ( $cparam['options'] as $value => $option ) {
							$output_child .= '<i class="fa ' . $value . '" data-name="' . $value . '"></i>';
						}
						$output_child .= '</div>';

						if (!isset($cparam['std'])) {
							$cparam['std'] = '';
						}

						$output_child .= $row_end;

						$output .= $output_child;
						$this->append_output( $output );

						break;
						
						case 'size' :
							$output_child  = $row_start;
							$output_child .= '<div class="magee-form-group">' . "\n";
							$output_child .= '<label>Width</label>' . "\n";
							$output_child .= '<input type="text" class="magee-form-text magee-cinput" name="' . $cpkey . '_width" id="' . $cpkey . '_width" value="' . $cparam['std'] . '" />' . "\n";
							$output_child  .= '</div>' . "\n";
							$output_child .= '<div class="magee-form-group last">' . "\n";
							$output_child .= '<label>Height</label>' . "\n";
							$output_child .= '<input type="text" class="magee-form-text magee-cinput" name="' . $cpkey . '_height" id="' . $cpkey . '_height" value="' . $cparam['std'] . '" />' . "\n";
							$output_child .= '</div>' . "\n";
							$output_child .= $row_end;

							$output .= $output_child;
				            $this->append_output($output);

							break;
					}
				}
		
			}
		
		}
		return $output;
	}
	
	function append_output( $output ) {
		$this->output = $this->output . "\n" . $output;
	}

	function reset_output( $output ) {
		$this->output = '';
	}

	function append_error( $error )	{
		$this->errors = $this->errors . "\n" . $error;
	}
	
 	public static function sliders_meta() {
	 
		$magee_sliders[''] =  __( 'Select a slider', 'magee-shortcodes' );
		$args = array( 'post_type' => 'magee_slider', 'post_status'=>'publish', 'posts_per_page' => -1 );
		$sliders = get_posts( $args );
		foreach ( $sliders as $post ) : 
			$magee_sliders[$post->ID] = $post->post_title;
		endforeach;

		wp_reset_postdata();
		return $magee_sliders;
	}
 
	/*	
	*	live preview
	*	---------------------------------------------------------------------
	*/	
	function live_preview($all) {

		// echo do_shortcode(str_replace( '\"', '"', $_POST['preview'] ) );
		$magee_shortcodes = Config::shortcodes();
		$shortcode = '';
    
		if ( isset( $magee_shortcodes ) && is_array( $magee_shortcodes ) && isset($_POST['name']) ) {
			
			$popup     = $_POST['name'];
			$params    = $magee_shortcodes[$popup]['params'];
			$shortcode = $magee_shortcodes[$popup]['shortcode'];
			$shortcode = str_replace('[ms_'.$popup.' ', '[ms_'.$popup.' is_preview="1" ', $shortcode);

			$attrs     = array();

			if ( isset( $_POST['preview'] ) ):
				foreach ( $_POST['preview'] as $attr) {
					$attrs[str_replace('magee_', '', $attr['name'])] = $attr['value'];
				}
				
				foreach ( $params as $pkey => $param )
				{
				
					if ( isset($attrs[$pkey] )) {
						$shortcode = str_replace('{{'.$pkey.'}}', $attrs[$pkey], $shortcode);
					} else {
						$shortcode = str_replace('{{'.$pkey.'}}', '', $shortcode);
					}
				}
			endif;
			
			if ( isset($magee_shortcodes[$popup]['child_shortcode'])):
			
			      $common = array_slice($_POST['preview'],count($_POST['attr'])-2,2) ;
                  array_splice($_POST['preview'],count($_POST['preview'])-2,2);
				  $number = count($magee_shortcodes[$popup]['child_shortcode']['params']);
				  $expcet = count($magee_shortcodes[$popup]['params']);
				  array_splice($_POST['preview'],0, $expcet);
                  $loop = array_chunk($_POST['preview'], $number);
			      $i = '';
				  $copyshortcode = '';
				  for( $i=0;$i<count($loop);$i++) {
	   
				   $cparams = $magee_shortcodes[$popup]['child_shortcode']['params'];
			
			       $cshortcode = $magee_shortcodes[$popup]['child_shortcode']['shortcode'];
			       $attrs = array();
				   $perattr = array_merge($loop[$i], $common); 
				   
				   foreach ( $perattr as $attr) { 
			   
				   $attrs[str_replace('magee_', '', $attr['name'])] = $attr['value'];
										  }
				   foreach ( $cparams as $cpkey => $cparam )
				   {
				
					if ( isset($attrs[$cpkey] )) {
						
						$cshortcode = str_replace('{{'.$cpkey.'}}', $attrs[$cpkey], $cshortcode);
						
						} else {
							$cshortcode = str_replace('{{'.$cpkey.'}}', '', $cshortcode);
						}
					}
				    $copyshortcode .= $cshortcode;
					
				  }  
				  $shortcode = str_replace('{{child_shortcode}}', $copyshortcode, $shortcode); 	  	   
			endif;
	
		}
		$shortcode = str_replace('\\\'', '\'', $shortcode);
		$shortcode = str_replace('\\"', '"', $shortcode);
		$shortcode = str_replace('\\\\', '\\', $shortcode);
		$shortcode = str_replace('\"', '"', $shortcode);
	    echo do_shortcode($shortcode);
        die();	
	}

	function preview_js() {
		global $wp_version;
		$scripts = Config::get_front_scripts();
		$script = '';
		$depend_bootstrap = ['popover', 'tooltip', 'tabs', 'contact'];
		$depend_bootstrap = apply_filters('magee_shortcode_depend_bootstrap', $depend_bootstrap);

		foreach ($scripts['styles'] as $k=>$v) {

			if ($k =='bootstrap' && !in_array($_POST['shortcode'], $depend_bootstrap) ) continue;
			$script .= "<link rel='stylesheet' id='".$k."-css' href='".$v[0]."?ver=".$v[2]."' type='text/css' media='all' />";
		}

		$script .= "<script id='jquery-js' type='text/javascript' src='".includes_url("js/jquery/jquery.min.js?ver=".$wp_version)."'></script>";
		foreach ($scripts['scripts'] as $k=>$v) {
			if ($k =='bootstrap' && !in_array($_POST['shortcode'], $depend_bootstrap)) continue;
			$script .= "<script id='".$k."-js' type='text/javascript' src='".$v[0]."?ver=".$v[2]."'></script>";
		}

		echo $script;
		die();
	}

	/*	
	*	send email
	*	---------------------------------------------------------------------
	*/
	function magee_contact() {
	
		if ( isset($_POST['terms']) && $_POST['terms']=='yes' && isset($_POST['checkboxWarning']) && $_POST['checkboxWarning'] == false) {

			$Error = __('Tick the checkbox to agree to our terms and conditions.', 'magee-shortcodes');
			$hasError = true;
		} 
		
		if (trim($_POST['message']) === '' && stristr(trim($_POST['required_fields']), 'message')) {
			$Error =  __('Please enter a message.', 'magee-shortcodes');
			$hasError = true;
		} else {
			if (function_exists('stripslashes')) {
				$message = stripslashes(trim($_POST['message']));
			} else {
				$message = trim($_POST['message']);
			}
		}
		
		
	if (trim($_POST['subject']) === ''  && stristr(trim($_POST['required_fields']), 'subject')) {
			$Error = __('Please enter your subject.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$subject = trim($_POST['subject']);
		}
		
		if (trim($_POST['email']) === '' && stristr(trim($_POST['required_fields']), 'email'))  {
			$Error = __('Please enter your email address.', 'magee-shortcodes');
			$hasError = true;
		} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
			$Error = __('You entered an invalid email address.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
		
		
		if (trim($_POST['name']) === '' && stristr(trim($_POST['required_fields']), 'name')) {
			$Error = __('Please enter your name.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$name = trim($_POST['name']);
		}
		
		if (trim($_POST['country']) === '' && stristr(trim($_POST['required_fields']), 'country')) {
			$Error = __('Please enter your country.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$country = trim($_POST['country']);
		}
		
		if (trim($_POST['city']) === '' && stristr(trim($_POST['required_fields']), 'city')) {
			$Error = __('Please enter your city.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$city = trim($_POST['city']);
		}
		
		if (trim($_POST['telephone']) === '' && stristr(trim($_POST['required_fields']), 'telephone')) {
			$Error = __('Please enter your telephone number.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$telephone = trim($_POST['telephone']);
		}
		
		if (trim($_POST['company']) === '' && stristr(trim($_POST['required_fields']), 'company')) {
			$Error = __('Please enter your company.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$company = trim($_POST['company']);
		}

		if (trim($_POST['website']) === '' && stristr(trim($_POST['required_fields']), 'website')) {
			$Error = __('Please enter your website.', 'magee-shortcodes');
			$hasError = true;
		} else if (trim($_POST['website']) !=='0' && !preg_match('/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.) {3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/',trim($_POST['website']))) {
			$Error = __('You entered an invalid website.', 'magee-shortcodes');
			$hasError = true;
		} else {
			$website = trim($_POST['website']);
		} 
		
		if (!isset($hasError)) {
			
		if (isset($_POST['receiver']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim(esc_attr($_POST['receiver'])))) {
			$emailTo = esc_attr($_POST['receiver']);
		} else{
			$emailTo = get_option('admin_email');
		}
		if ($emailTo !="") {
			if (trim($_POST['subject']) === '')
				$subject = 'From '.$name;
			else
				$subject = trim($_POST['subject']);
			
			$body  = __('Name', 'magee-shortcodes').': ';
			$body .= $name;
			$body .= "\n\n";
			$body .= __('Email', 'magee-shortcodes').': ';
			$body .= $email;
			$body .= "\n\n";
			$body .= __('Message', 'magee-shortcodes').': ';
			$body .= $message;
			$body .= "\n\n";
			if ($country !== '0'):
				$body .= __('Country', 'magee-shortcodes').': ';
				$body .= $country;
				$body .= "\n\n";
			endif;
			if ($city !== '0'):
				$body .= __('City', 'magee-shortcodes').': ';
				$body .= $city;
				$body .= "\n\n";
			endif;
			if ($telephone !== '0'):
				$body .= __('Telephone', 'magee-shortcodes').': ';
				$body .= $telephone;
				$body .= "\n\n";
			endif;
			if ($company !== '0'):
				$body .= __('Company', 'magee-shortcodes').': ';
				$body .= $company;
				$body .= "\n\n";
			endif;
			if ($website !== '0'):
				$body .= __('Website', 'magee-shortcodes').': ';
				$body .= $website;
				$body .= "\n\n";
			endif;
			$headers  = sprintf(__('From: %s <%s>', 'magee-shortcodes'), $name, $emailTo);
			$headers .= "\r\n" ;
			$headers .=  sprintf(__('Reply-To: %s' , 'magee-shortcodes'), $email);;
			
			//$body = sprintf(__("Name: %s \n\nEmail: %s \n\nMessage: %s", 'magee-shortcodes'), $name, $email, $message);
			//$headers = sprintf(__('From: %s <%s>' . "\r\n" . 'Reply-To: %s', 'magee-shortcodes'), $name, $emailTo, $email);

			wp_mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
			}
			echo json_encode(array("msg"=>__("Your message has been successfully sent!", 'magee-shortcodes'), "error"=>0));
			
		} else {
			echo json_encode(array("msg"=>$Error, "error"=>1));
		}
		die() ;
	}

	function magee_contact_advanced() {

    	$body  = '';
		$email = '';
	
		if (isset($_POST['sendto']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim(esc_attr($_POST['sendto'])))) {
			$emailTo = esc_attr($_POST['sendto']);
		} else {
			$emailTo = get_option('admin_email');
		}

		if ($emailTo !="") {
			$subject = 'From '.get_bloginfo('name');
		
			parse_str($_POST['values'], $values);
			if ( is_array($values) ) {
				foreach ( $values as $k => $v ) {
					//$body .= str_replace('_', ' ', $k).': '.$v.' <br/><br/>';
					$body .= str_replace('_', ' ', $k).': '.utf8_encode(htmlentities($v)).' <br/><br/>';
					if ( strpos(strtolower($k), 'email') && $v != "" ) {
						$email = $v;
					}
				}
			}
		
			$headers = 'From: '.get_bloginfo('name').' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email . "\r\n";	
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
			wp_mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}
		echo json_encode(array("msg"=>__("Your message has been successfully sent!", 'magee-shortcodes'), "error"=>0));
		
		die() ;
	}
	
	
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	public static function paging_nav($echo='echo', $wp_query='') {
		if (!$wp_query) {global $wp_query;}
		global $wp_rewrite;      
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

		$pagination = array(
		'base' => @add_query_arg('paged', '%#%'),
		'format'             => '?page=%#%',
		'total'              => $wp_query->max_num_pages,
		'current'            => $current,
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 2,
		'prev_next'          => true,
		'prev_text'          => __(' Prev', 'magee-shortcodes'),
		'next_text'          => __('Next ', 'magee-shortcodes'),
		'type'               => 'list',
		'add_args'           => false,
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => ''
		);
	
		if ( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
	
		if ( !empty($wp_query->query_vars['s']) )
			$pagination['add_args'] = array('s'=>get_query_var('s'));
			
		if ( $wp_query->max_num_pages > 1 ) {
			if ($echo == "echo") {
				echo '<nav class="post-list-pagination" role="navigation">
											<div class="post-pagination-decoration text-center">
											'.paginate_links($pagination).'</div></nav>'; 
			} else {
			
				return '<nav class="post-list-pagination" role="navigation">
											<div class="post-pagination-decoration text-center">'.paginate_links($pagination).'</div></nav>';
			}
		
		}
	}

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	public static function posted_on( $echo = false, $args=[] ) {

		$defaults =  self::set_shortcode_defaults(
			array(
				'display_author' =>'yes',
				'display_date' =>'yes',
				'display_categories' =>'no',
				'display_comments' =>'yes',
				'display_readmore' =>'yes',
				'display_tags' =>'yes',
				'display_meta' =>'yes',
			), $args
		);
		
		extract( $defaults );
		$return = '';
		
		if ( $display_meta == 'yes' ) {
		
			$return .=  '<ul class="entry-meta">';
			if ( $display_date == 'yes' )
				$return .=  '<li class="entry-date"><i class="fa fa-calendar"></i>'. get_the_date().'</li>';
			if ( $display_author == 'yes' )
				$return .=  '<li class="entry-author"><i class="fa fa-user"></i>'.get_the_author_link().'</li>';
			if ( $display_categories == 'yes' )		
				$return .=  '<li class="entry-catagory"><i class="fa fa-file-o"></i>'.get_the_category_list(', ').'</li>';
			if ( $display_comments == 'yes' )	
				$return .=  '<li class="entry-comments pull-right">'.self::get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'magee-shortcodes'), __( '<i class="fa fa-comment"></i> % ', 'magee-shortcodes'), 'read-comments', '').'</li>';
			
			$return .=  '</ul>';
		}

		if ( $echo == true )
			echo $return;
		else
			return $return;

	}

	/**
	 * Returns a select list of Google fonts
	 * Feel free to edit this, update the fallbacks, etc.
	 */
	
	public static function countdowns_get_google_fonts() {
		// Google Font Defaults
		require_once MAGEE_SHORTCODES_INCLUDE_DIR.'/google-fonts.php';
		$google_fonts_json = magee_get_google_fonts_json();
		$googleFontArray = array();

		$fontArray = json_decode($google_fonts_json, true);
		
		foreach ($fontArray['items'] as $index => $value) {
			
			$_family = strtolower( str_replace(' ', '_', $value['family']) );
			$googleFontArray[$_family]['family'] = $value['family'];
			$googleFontArray[$_family]['variants'] = $value['variants'];
			$googleFontArray[$_family]['subsets'] = $value['subsets'];
			
			$category = '';
			if ( isset($value['category']) ) $category = ', '.$value['category'];
			$googleFontArray['magee_of_family'][$value['family'].$category] = $value['family'];
			
		}
		return $googleFontArray;
	}

	public static function google_fonts() {
		$googleFontArray =  self::countdowns_get_google_fonts();
		$google_fonts    = array_merge(array('' => __( '-- None --', 'magee-shortcodes' ) ), $googleFontArray['magee_of_family']);
		return $google_fonts;
	}

	public static function shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
		if ( $all ) {
			$number_of_posts['-1'] = __('All', 'magee-shortcodes');
		}

		if ( $default ) {
			$number_of_posts[''] = __('Default', 'magee-shortcodes');
		}

		foreach ( range( $range_start, $range ) as $number ) {
			$number_of_posts[$number] = $number;
		}

		return $number_of_posts;
	}

	public static function shortcode_menus($name) {
		$menus[''] = __('Default', 'magee-shortcodes');
		if ( $name !== '') {
		
		$menu = wp_get_nav_menus();
			
			foreach ( $menu as $val) {
			if (isset($val->name)) {
				$menus[$val->name] = $val->name;
				}
			}	
			if (isset( $menus)) {	
				return $menus;	
			}
		}

	}

	//widget list
	public static function get_sidebars() {
		global $wp_registered_sidebars;
		
		$sidebars = array();
		$sidebars[''] = __('Default', 'magee-shortcodes'); 
		foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
			$sidebars[$sidebar_id] = $sidebar['name'];
		}
	
		return $sidebars;
	}

}