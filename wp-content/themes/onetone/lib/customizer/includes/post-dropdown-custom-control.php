<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Class to create a custom post control
 */
class Post_Dropdown_Custom_Control extends WP_Customize_Control {
	private $posts = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$postargs 		= wp_parse_args( $options, array( 'numberposts' => '-1', 'post_type' => 'page' ) );
		$this->posts 	= get_posts( $postargs );

		parent::__construct( $manager, $id, $args );
	}

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		if ( ! empty( $this->posts ) ) {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
					<select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
					<?php
						foreach ( $this->posts as $post ) {
							printf('<option value="%s" %s>%s</option>', $post->ID, selected( $this->value(), $post->ID, false), $post->post_title );
						}
					?>
					</select>
				</label>
			<?php
		}
	}
}
