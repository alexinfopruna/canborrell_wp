<?php 

class WonderPlugin_Lightbox_View {

	private $controller;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function add_metaboxes() {
		add_meta_box('overview_features', __('WonderPlugin Lightbox Features', 'wonderplugin_lightbox'), array($this, 'show_features'), 'wonderplugin_lightbox_overview', 'features', '');
		add_meta_box('overview_upgrade', __('Upgrade to Commercial Version', 'wonderplugin_lightbox'), array($this, 'show_upgrade_to_commercial'), 'wonderplugin_lightbox_overview', 'upgrade', '');
		add_meta_box('overview_news', __('WonderPlugin News', 'wonderplugin_lightbox'), array($this, 'show_news'), 'wonderplugin_lightbox_overview', 'news', '');
		add_meta_box('overview_contact', __('Contact Us', 'wonderplugin_lightbox'), array($this, 'show_contact'), 'wonderplugin_lightbox_overview', 'contact', '');
		add_meta_box('overview_license', __('Credits', 'wonderplugin_lightbox'), array($this, 'show_license'), 'wonderplugin_lightbox_overview', 'license', '');
	}
	
	function show_upgrade_to_commercial() {
		?>
		<ul class="wonderplugin-feature-list">
			<li>Use on commercial websites</li>
			<li>Remove the wonderplugin.com watermark</li>
			<li>Priority techincal support</li>
			<li><a href="http://www.wonderplugin.com/order/?product=lightbox" target="_blank">Upgrade to Commercial Version</a></li>
		</ul>
		<?php
	}
	
	function show_news() {
		
		include_once( ABSPATH . WPINC . '/feed.php' );
		
		$rss = fetch_feed( 'http://www.wonderplugin.com/feed/' );
		
		$maxitems = 0;
		if ( ! is_wp_error( $rss ) )
		{
			$maxitems = $rss->get_item_quantity( 5 );
			$rss_items = $rss->get_items( 0, $maxitems );
		}
		?>
		
		<ul class="wonderplugin-feature-list">
		    <?php if ( $maxitems > 0 ) {
		        foreach ( $rss_items as $item )
		        {
		        	?>
		        	<li>
		                <a href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank" 
		                    title="<?php printf( __( 'Posted %s', 'wonderplugin_lightbox' ), $item->get_date('j F Y | g:i a') ); ?>">
		                    <?php echo esc_html( $item->get_title() ); ?>
		                </a>
		                <p><?php echo esc_html( $item->get_description() ); ?></p>
		            </li>
		        	<?php 
		        }
		    } ?>
		</ul>
		<?php
	}
	
	function show_features() {
		?>
		<ul class="wonderplugin-feature-list">
			<li>Works on mobile, tablets and all major web browsers, including iPhone, iPad, Android, Firefox, Safari, Chrome, Opera and Internet Explorer 7/8/9/10/11</li>
			<li>Support images, Flash SWF files, webpage, YouTube, Vimeo, mp4, webm and flv videos</li>
			<li>Support Lightbox gallery with thumbnail navigation</li>
			<li>Fully responsive</li>
			<li>Easy to use</li>
		</ul>
		<?php
	}
	
	function show_contact() {
		?>
		<p>Technical support is available for Commercial Version users at support@wonderplugin.com. Please include your license information, WordPress version, link to your webpage, all related error messages in your email.</p> 
		<?php
	}

	function show_license() {
		?>
		<p><a target="_blank" href="http://www.bigbuckbunny.org">Big Buck Bunny</a>, Copyright Blender Foundation, <a target="_blank" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0</a></p> 
		<p><a target="_blank" href="http://www.publicdomainpictures.net/view-image.php?image=6480&#038;picture=tulip-background">Tulip Background</a> by Petr Kratochvil, <a target="_blank" href="http://creativecommons.org/publicdomain/zero/1.0/">Public Domain License</a></p>
		<p><a target="_blank" href="http://www.publicdomainpictures.net/view-image.php?image=7277&#038;picture=swan-on-lake">Swan On Lake</a> by Vera Kratochvil, <a target="_blank" href="http://creativecommons.org/publicdomain/zero/1.0/">Public Domain License</a></p>
		<p><a target="_blank" href="http://www.publicdomainpictures.net/view-image.php?image=7982&picture=colorful-tulips-and-blue-sky">Colorful Tulips And Blue Sky</a> by Vera Kratochvil, <a target="_blank" href="http://creativecommons.org/publicdomain/zero/1.0/">Public Domain License</a></p>
		<?php
	}
		
	function print_overview() {
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-lightbox" class="icon32"><br /></div>
		
		<?php $this->controller->print_lightbox_options(); ?>
		<h2><?php echo __( 'WonderPlugin Lightbox', 'wonderplugin_lightbox' ) . ( (WONDERPLUGIN_LIGHTBOX_VERSION_TYPE == "C") ? " Commercial Version" : " Free Version") . " " . WONDERPLUGIN_LIGHTBOX_VERSION; ?> </h2>
		 
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<h3>WordPress Image and Video Lightbox Plugin</h3>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h4>Get Started</h4>
						<a class="button button-primary button-hero" href="<?php echo admin_url('admin.php?page=wonderplugin_lightbox_show_quick_start'); ?>">Quick Start</a>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h4>More Actions</h4>
						<ul>
							<li><a href="<?php echo admin_url('admin.php?page=wonderplugin_lightbox_show_options'); ?>" class="welcome-icon welcome-widgets-menus">Lightbox Options</a></li>
							<?php  if (WONDERPLUGIN_LIGHTBOX_VERSION_TYPE !== "C") { ?>
							<li><a href="http://www.wonderplugin.com/order/?product=lightbox" target="_blank" class="welcome-icon welcome-view-site">Upgrade to Commercial Version</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-2">
	 
	                 <div class="postbox-container">
	                    <?php 
	                    do_meta_boxes( 'wonderplugin_lightbox_overview', 'features', '' ); 
	                    do_meta_boxes( 'wonderplugin_lightbox_overview', 'contact', '' ); 
	                    do_meta_boxes( 'wonderplugin_lightbox_overview', 'license', '' );
	                    ?>
	                </div>
	 
	                <div class="postbox-container">
	                    <?php 
	                    if (WONDERPLUGIN_LIGHTBOX_VERSION_TYPE != "C")
	                    	do_meta_boxes( 'wonderplugin_lightbox_overview', 'upgrade', ''); 
	                    do_meta_boxes( 'wonderplugin_lightbox_overview', 'news', ''); 
	                    ?>
	                </div>
	 
	        </div>
        </div>
            
		<?php
	}
	
	function print_options() {
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-lightbox" class="icon32"><br /></div>
			
		<?php $this->controller->print_lightbox_options(); ?>
		<h2><?php _e( 'Lightbox Options', 'wonderplugin_lightbox' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_lightbox_show_quick_start'); ?>" class="add-new-h2"> <?php _e( 'Quick Start', 'wonderplugin_lightbox' ); ?>  </a></h2>
		
		<?php
		if (isset($_POST['save-lightbox-options']) && check_admin_referer('wonderplugin-lightbox', 'wonderplugin-lightbox-options') ) 
		{
			unset($_POST['save-lightbox-options']);
			$this->controller->save_options($_POST);
			echo '<div class="updated"><p>Lightbox options saved.</p></div>';
		}
		
		$lightbox_options = $this->controller->read_options();
		
		?>
        <form method="post">
        
        <?php wp_nonce_field('wonderplugin-lightbox', 'wonderplugin-lightbox-options'); ?>
        
        <ul class="wonderplugin-tab-buttons-horizontal" data-panelsid="wonderplugin-lightbox-panels">
			<li class="wonderplugin-tab-button-horizontal wonderplugin-tab-button-horizontal-selected"><?php _e( 'General', 'wonderplugin_lightbox' ); ?></li>
			<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Video', 'wonderplugin_lightbox' ); ?></li>
			<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Thubmails', 'wonderplugin_lightbox' ); ?></li>
			<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Text', 'wonderplugin_lightbox' ); ?></li>
			<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Social Media', 'wonderplugin_lightbox' ); ?></li>
			<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Advanced Options', 'wonderplugin_lightbox' ); ?></li>
			<div style="clear:both;"></div>
		</ul>
        
        <ul class="wonderplugin-tabs-horizontal" id="wonderplugin-lightbox-panels">
        	<li class="wonderplugin-tab-horizontal wonderplugin-tab-horizontal-selected">
        	
        	<table class="wonderplugin-form-table">
        	
        	<tr valign="top">
				<th scope="row">Responsive</th>
				<td><label for="responsive"><input name="responsive" type="checkbox" id="responsive" value="1" <?php echo $lightbox_options['responsive'] ? "checked": ""; ?> /> Support responsive</label></td>
			</tr>
        	
			<tr valign="top">
				<th scope="row">Slideshow</th>
				<td><label for="autoslide"><input name="autoslide" type="checkbox" id="autoslide" value="1" <?php echo $lightbox_options['autoslide'] ? "checked": ""; ?> /> Auto play slideshow</label>
				<label>- slideshow interval (ms): <input name="slideinterval" type="number" min=0 id="slideinterval" value="<?php echo esc_html($lightbox_options['slideinterval']); ?>" class="small-text" /></label>
				<br><label for="alwaysshownavarrows"><input name="alwaysshownavarrows" type="checkbox" id="alwaysshownavarrows" value="1" <?php echo $lightbox_options['alwaysshownavarrows'] ? "checked": ""; ?> /> Always show left and right navigation arrows</label>
				<br><label for="showplaybutton"><input name="showplaybutton" type="checkbox" id="showplaybutton" value="1" <?php echo $lightbox_options['showplaybutton'] ? "checked": ""; ?> /> Show play slideshow button</label>
				<br><label for="showtimer"><input name="showtimer" type="checkbox" id="showtimer" value="1" <?php echo $lightbox_options['showtimer'] ? "checked": ""; ?> /> Show line timer for image slideshow</label>
				<br>Timer position: <select name="timerposition" id="timerposition">
					  <option value="bottom" <?php echo ($lightbox_options['timerposition'] == 'bottom') ? 'selected="selected"' : ''; ?>>Bottom</option>
					  <option value="top" <?php echo ($lightbox_options['timerposition'] == 'top') ? 'selected="selected"' : ''; ?>>Top</option>
					</select>
				Timer color: <input name="timercolor" type="text" id="timercolor" value="<?php echo esc_html($lightbox_options['timercolor']); ?>" class="medium-text" />
				Timer height: <input name="timerheight" type="number" min=0 id="timerheight" value="<?php echo esc_html($lightbox_options['timerheight']); ?>" class="small-text" />
				Timer opacity: <input name="timeropacity" type="number" min=0 max=1 step="0.1" id="timeropacity" value="<?php echo esc_html($lightbox_options['timeropacity']); ?>" class="small-text" />
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row">Fullscreen mode</th>
				<td><label for="fullscreenmode"><input name="fullscreenmode" type="checkbox" id="fullscreenmode" value="1" <?php echo $lightbox_options['fullscreenmode'] ? "checked": ""; ?> /> Display in fullscreen mode (the close button on top right of the web browser)</label></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Overlay</th>
				<td>Color: <input name="overlaybgcolor" type="text" id="overlaybgcolor" value="<?php echo esc_html($lightbox_options['overlaybgcolor']); ?>" class="medium-text" />
				Opacity: <input name="overlayopacity" type="number" min=0 max=1 step="0.1" id="overlayopacity" value="<?php echo esc_html($lightbox_options['overlayopacity']); ?>" class="small-text" />
				<label for="closeonoverlay"><input name="closeonoverlay" type="checkbox" id="closeonoverlay" value="1" <?php echo $lightbox_options['closeonoverlay'] ? "checked": ""; ?> /> Close the lightbox when clicking on the overlay background</label></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Background color</th>
				<td><input name="bgcolor" type="text" id="bgcolor" value="<?php echo esc_html($lightbox_options['bgcolor']); ?>" class="medium-text" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Border</th>
				<td>Border radius (px): <input name="borderradius" type="number" min=0 id="borderradius" value="<?php echo esc_html($lightbox_options['borderradius']); ?>" class="small-text" />
				Border size (px): <input name="bordersize" type="number" min=0 id="bordersize" value="<?php echo esc_html($lightbox_options['bordersize']); ?>" class="small-text" />
				<p>Minimum top/buttom margin: <input name="bordertopmargin" type="number" min=0 id="bordertopmargin" value="<?php echo esc_html($lightbox_options['bordertopmargin']); ?>" class="small-text" /></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Mobile device</th>
				<td><label for="enabletouchswipe"><input name="enabletouchswipe" type="checkbox" id="enabletouchswipe" value="1" <?php echo $lightbox_options['enabletouchswipe'] ? "checked": ""; ?> /> Enable touch swipe</label></td>
			</tr>	
			
        	</table>
        	
        	</li>
        	
        	<li class="wonderplugin-tab-horizontal">
        	<table class="wonderplugin-form-table">
        	
        	<tr valign="top">
				<th scope="row">Video</th>
				<td><label for="autoplay"><input name="autoplay" type="checkbox" id="autoplay" value="1" <?php echo $lightbox_options['autoplay'] ? "checked": ""; ?>  /> Automatically play video (Only works on desktop, does not work on mobile and tablets)</label>
				<br /><label for="html5player"><input name="html5player" type="checkbox" id="html5player" value="1" <?php echo $lightbox_options['html5player'] ? "checked": ""; ?>  /> Use HTML5 player by default</label>
				<p style="font-style:italic;">* Video autoplay is not supported on mobile and tables. The limitation comes from iOS and Android.</p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">HTML5 Video</th>
				<td><label>Default volume of MP4/WebM videos: <input name="defaultvideovolume" type="number" min=0 max=1 step="0.1" id="defaultvideovolume" value="<?php echo esc_html($lightbox_options['defaultvideovolume']); ?>" class="small-text" /> (0 - 1)</label>
				<p><label for="videohidecontrols"><input name="videohidecontrols" type="checkbox" id="videohidecontrols" value="1" <?php echo $lightbox_options['videohidecontrols'] ? "checked": ""; ?> /> Hide MP4/WebM video play control bar</label></p>
				<p>Video background color: <input name="videobgcolor" type="text" id="videobgcolor" value="<?php echo esc_html($lightbox_options['videobgcolor']); ?>" class="medium-text" /></p>
				<p>Video poster image (absolute URL): <input name="html5videoposter" type="text" id="html5videoposter" value="<?php echo esc_html($lightbox_options['html5videoposter']); ?>" class="regular-text" /></p>
				</td>
			</tr>
        	
        	</table>
        	</li>
        	
        	<li class="wonderplugin-tab-horizontal">
        	<table class="wonderplugin-form-table">
	        	<tr valign="top">
					<th scope="row">Thumbnail size (px)</th>
					<td><input name="thumbwidth" type="number" id="thumbwidth" value="<?php echo esc_html($lightbox_options['thumbwidth']); ?>" class="small-text" /> by <input name="thumbheight" type="number" id="thumbheight" value="<?php echo esc_html($lightbox_options['thumbheight']); ?>" class="small-text" /></td>
				</tr>
		
				<tr valign="top">
					<th scope="row">Thumbnail top margin (px)</th>
					<td><input name="thumbtopmargin" type="number" id="thumbtopmargin" value="<?php echo esc_html($lightbox_options['thumbtopmargin']); ?>" class="small-text" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Thumbnail bottom margin (px)</th>
					<td><input name="thumbbottommargin" type="number" id="thumbbottommargin" value="<?php echo esc_html($lightbox_options['thumbbottommargin']); ?>" class="small-text" /></td>
				</tr>
        	</table>
        	</li>
        	
        	<li class="wonderplugin-tab-horizontal">
        	<table class="wonderplugin-form-table">
 
			<tr valign="top">
				<th scope="row">Text position</th>
				<td>
					<select name="titlestyle" id="titlestyle">
					  <option value="bottom" <?php echo ($lightbox_options['titlestyle'] == 'bottom') ? 'selected="selected"' : ''; ?>>Bottom</option>
					  <option value="inside" <?php echo ($lightbox_options['titlestyle'] == 'inside') ? 'selected="selected"' : ''; ?>>Inside</option>
					  <option value="right" <?php echo ($lightbox_options['titlestyle'] == 'right') ? 'selected="selected"' : ''; ?>>Right</option>
					  <option value="left" <?php echo ($lightbox_options['titlestyle'] == 'left') ? 'selected="selected"' : ''; ?>>Left</option>
					</select>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Maximum text bar height when text position is bottom (px)</th>
				<td><input name="barheight" type="number" min=0 id="barheight" value="<?php echo esc_html($lightbox_options['barheight']); ?>" class="small-text" />
				<p>When the screen height is less than <input name="smallscreenheight" type="number" id="smallscreenheight" value="415" class="small-text" />px:
				<br><label><input name='responsivebarheight' type='checkbox' id='responsivebarheight'  />Change the bar height on small height screen</label> to  <input name="barheightonsmallheight" type="number" id="barheightonsmallheight" value="48" class="small-text" />px
				<br><label><input name='notkeepratioonsmallheight' type='checkbox' id='notkeepratioonsmallheight'  />Do not keep aspect ratio</label>
				</p>
				</td>
			</tr>
									
			<tr valign="top">
				<th scope="row">Image/video width percentage when text position is right or left</th>
				<td><input name="imagepercentage" type="number" id="imagepercentage" value="<?php echo esc_html($lightbox_options['imagepercentage']); ?>" class="small-text" />%</td>
			</tr>
		
			<tr valign="top">
				<th scope="row">Title</th>
				<td><label for="showtitle"><input name="showtitle" type="checkbox" id="showtitle" value="1" <?php echo $lightbox_options['showtitle'] ? "checked": ""; ?> /> Show title</label></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">In gallery mode, prefix for the title</th>
				<td><label for="showtitleprefix"><input name="showtitleprefix" type="checkbox" id="showtitleprefix" value="1" <?php echo $lightbox_options['showtitleprefix'] ? "checked": ""; ?> /> Add prefix:</label><input name="titleprefix" type="text" id="titleprefix" value="<?php echo esc_html($lightbox_options['titleprefix']); ?>" class="regular-text" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Title CSS</th>
				<td><textarea name="titlebottomcss" id="titlebottomcss" rows="2" class="large-text code"><?php echo esc_html($lightbox_options['titlebottomcss']); ?></textarea></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Title CSS when text position is inside</th>
				<td><textarea name="titleinsidecss" id="titleinsidecss" rows="2" class="large-text code"><?php echo esc_html($lightbox_options['titleinsidecss']); ?></textarea></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Description</th>
				<td><label for="showdescription"><input name="showdescription" type="checkbox" id="showdescription" value="1" <?php echo $lightbox_options['showdescription'] ? "checked": ""; ?> /> Show description</label></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Description CSS</th>
				<td><textarea name="descriptionbottomcss" id="descriptionbottomcss" rows="2" class="large-text code"><?php echo esc_html($lightbox_options['descriptionbottomcss']); ?></textarea></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Description CSS when text position is inside</th>
				<td><textarea name="descriptioninsidecss" id="descriptioninsidecss" rows="2" class="large-text code"><?php echo esc_html($lightbox_options['descriptioninsidecss']); ?></textarea></td>
			</tr>
			
        	</table>
        	</li>
        	
        	<li class="wonderplugin-tab-horizontal">
        	<table class="wonderplugin-form-table">
        	
        	<tr valign="top">
				<th scope="row">Social Media</th>
				<td><label for="showsocial"><input name="showsocial" type="checkbox" id="showsocial" value="1" <?php echo $lightbox_options['showsocial'] ? "checked": ""; ?> /> Enable social media</label>
				<p><label for="showfacebook"><input name="showfacebook" type="checkbox" id="showfacebook" value="1" <?php echo $lightbox_options['showfacebook'] ? "checked": ""; ?> /> Show Facebook button</label>
				<br><label for="showtwitter"><input name="showtwitter" type="checkbox" id="showtwitter" value="1" <?php echo $lightbox_options['showtwitter'] ? "checked": ""; ?> /> Show Twitter button</label>
				<br><label for="showpinterest"><input name="showpinterest" type="checkbox" id="showpinterest" value="1" <?php echo $lightbox_options['showpinterest'] ? "checked": ""; ?> /> Show Pinterest button</label></p>
				</td>
			</tr>
        	
        	<tr valign="top">
				<th scope="row">Position and Size</th>
				<td>
				Position CSS: <input name="socialposition" type="text" id="socialposition" value="<?php echo esc_html($lightbox_options['socialposition']); ?>" class="regular-text" />
				<p>Position CSS on small screen: <input name="socialpositionsmallscreen" type="text" id="socialpositionsmallscreen" value="<?php echo esc_html($lightbox_options['socialpositionsmallscreen']); ?>" class="regular-text" /></p>
				<p>Button size: <input name="socialbuttonsize" type="number" id="socialbuttonsize" value="<?php echo esc_html($lightbox_options['socialbuttonsize']); ?>" class="small-text" />
				Button font size: <input name="socialbuttonfontsize" type="number" id="socialbuttonfontsize" value="<?php echo esc_html($lightbox_options['socialbuttonfontsize']); ?>" class="small-text" />
				Buttons direction:
				<select name="socialdirection" id="socialdirection">
				  <option value="horizontal" <?php echo ($lightbox_options['socialdirection'] == 'horizontal') ? 'selected="selected"' : ''; ?>>horizontal</option>
				  <option value="vertical" <?php echo ($lightbox_options['socialdirection'] == 'vertical') ? 'selected="selected"' : ''; ?>>vertical</option>
				</select>
				</p>
				<p><label for="socialrotateeffect"><input name="socialrotateeffect" type="checkbox" id="socialrotateeffect" value="1" <?php echo $lightbox_options['socialrotateeffect'] ? "checked": ""; ?> /> Enable button rotating effect on mouse hover</label></p>	
				</td>
			</tr>
			
        	</table>
        	</li>
        	
        	<li class="wonderplugin-tab-horizontal">
        	<table class="wonderplugin-form-table">

			<tr valign="top">
				<th>Advanced Options</th>
				<td><textarea name='advancedoptions' id='advancedoptions' class='large-text' rows="5"><?php echo esc_html($lightbox_options['advancedoptions']); ?></textarea></td>
			</tr>
		
        	</table>
        	</li>
        </ul>
                
        <p class="submit"><input type="submit" name="save-lightbox-options" id="save-lightbox-options" class="button button-primary button-hero" value="Save Changes"  /></p>
        
        </form>
        
		</div>
		<?php
	}

	function print_quick_start() {

		?>
		<div class="wrap">
		<div id="icon-wonderplugin-lightbox" class="icon32"><br /></div>
		
		<?php $this->controller->print_lightbox_options(); ?>
		<h2><?php _e( 'Quick Start Guide', 'wonderplugin_lightbox' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_lightbox_show_options'); ?>" class="add-new-h2"> <?php _e( 'Lightbox Options', 'wonderplugin_lightbox' ); ?>  </a> </h2>
		
		<div style="margin:8px 0px 24px 24px;">
		<ul style="list-style-type: square;">
		<li><a href="#quickstart">Quick Start</a></li>
		<?php if (WONDERPLUGIN_LIGHTBOX_VERSION_TYPE !== "C") { ?>
		<li><a href="#removewatermark">Remove Free Version Watermark</a></li>
		<?php } ?>
		<li><a href="#imagelightbox">Image Lightbox</a></li>
		<li><a href="#youtubelightbox">YouTube Lightbox</a></li>
		<li><a href="#vimeolightbox">Vimeo Lightbox</a></li>
		<li><a href="#mp4lightbox">MP4/WebM video Lightbox</a></li>
		<li><a href="#lightboxgallery">Image & video Lightbox gallery with thumbnail navigation</a></li>
		<li><a href="#textlightbox">Show title and description in Lightbox</a></li>
		<li><a href="#datatags">Customise the lightbox with data tags - display text on the right side of the lightbox</a></li>
		<li><a href="#divlightbox">Open a div in Lightbox</a></li>
		</ul>
		</div>
		
		<h3 id="quickstart">Quick Start</h3>
		<p>Add a <code>class="wplightbox"</code> attribute to any link to activate the Lightbox effect. </p>
		<p>To show a caption, use attribute <code>title</code>. To define the size of the Lightbox popup, use attribute <code>data-width</code> and <code>data-height</code>.</p>
		
		<?php if (WONDERPLUGIN_LIGHTBOX_VERSION_TYPE !== "C") { ?>
		<h3 id="removewatermark">Remove Free Version Watermark</h3>
		<p>To remove the Free Version watermark, please <a href="https://www.wonderplugin.com/order/?product=lightbox" target="_blank">Upgrade to Commercial Version</a>.</p>
		<?php } ?>
		
		<h3 id="imagelightbox">Image Lightbox</h3>
		<p>Live demo: <a href="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image0.jpg" class="wplightbox" title="WonderPlugin Image Lightbox">Image Lightbox</a></p>
		<p>Demo code:</p>
		<div class="code">&lt;a href=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image0.jpg&quot; <span>class=&quot;wplightbox&quot;</span> title=&quot;WonderPlugin Image Lightbox&quot;&gt;Image Lightbox&lt;/a&gt;</div>
		
		<h3 id="youtubelightbox">YouTube Lightbox</h3>
		<p>Live demo: <a href="http://www.youtube.com/embed/c9-gOVGjHvQ" class="wplightbox" title="WordPress Carousel Plugin" data-width="640" data-height="360">YouTube Lightbox</a></p>
		<p>Demo code:</p>
		<div class="code">&lt;a href=&quot;http://www.youtube.com/embed/c9-gOVGjHvQ&quot; <span>class=&quot;wplightbox&quot;</span> title=&quot;WordPress Carousel Plugin&quot; <span>data-width=&quot;640&quot;</span> <span>data-height=&quot;360&quot;</span>&gt;YouTube Lightbox&lt;/a&gt;</div>
		
		<h3 id="vimeolightbox">Vimeo Lightbox</h3>
		<p>Live demo: <a href="http://player.vimeo.com/video/147149584" class="wplightbox" title="WordPress Slider Plugin">Vimeo Lightbox</a></p>
		<p>Demo code:</p>
		<div class="code">&lt;a href=&quot;http://player.vimeo.com/video/147149584&quot; <span>class=&quot;wplightbox&quot;</span> title=&quot;WordPress Slider Plugin&quot;&gt;Vimeo Lightbox&lt;/a&gt;</div>
		
		<h3 id="mp4lightbox">MP4/WebM video Lightbox</h3>
		<p>To play your video in Lightbox, you only need to provide one MP4 format.</p>
		<p>On iPhone, iPad, Android, Chrome, Safari, Internet Explorer 10 and above, the plugin will use HTML5 to play the MP4 video. On legacy web browsers Internet Explorer 7/8/9, the plugin will use Flash to play the MP4 video.</p>
		<p>You can also use <code>data-webm</code> to add a video for Firefox and Opera HTML5 player. Providing a WebM format is optional. If the WebM video is not provided, the plugin will use Flash to play MP4 on Firefox and Opera.</p>
		<p>The provided MP4 and WebM videos must be HTML5 compatible. Please visit the link for <a href="http://www.wonderplugin.com/wordpress-tutorials/how-to-convert-video-to-html5-compatible/" target="_blank">how to convert vidoe to HTML5 compabitle</a>.</p>
		<p>Live demo: <a href="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video0.mp4" data-webm="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video0.webm" class="wplightbox" title="Big Buck Bunny Copyright Blender Foundation">Video Lightbox</a></p>
		<p>Demo code:</p>
		<div class="code">&lt;a href=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video0.mp4&quot; data-webm=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video0.webm&quot; <span>class=&quot;wplightbox&quot;</span> title=&quot;Big Buck Bunny Copyright Blender Foundation&quot;&gt;Video Lightbox&lt;/a&gt;</div>
		
		<h3 id="lightboxgallery">Image & video Lightbox gallery with thumbnail navigation</h3>
		<p>To create a gallery of images and videos, you can add a attribute <code>data-group</code> to the related links. You can use any string as the group name, as long as all of the links in one gallery has same value.</p>
		<p>You can use <code>data-thumbnail</code> to add thumbnail navigation to the gallery.</p>
		<p>Live demo</p>
		<p>
		<a href="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image1.jpg" class="wplightbox" data-group="gallery0" data-thumbnail="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image1-tn.jpg" title="Image"><img src="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image1-tn.jpg" /></a>
		<a href="http://www.youtube.com/embed/c9-gOVGjHvQ?rel=0&vq=hd1080" class="wplightbox" data-group="gallery0" data-thumbnail="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-youtube-tn.jpg" title="YouTube"><img src="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-youtube-tn.jpg" /></a>
		<a href="http://player.vimeo.com/video/147149584?title=0&byline=0&portrait=0" class="wplightbox" data-group="gallery0" data-thumbnail="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-vimeo-tn.jpg" title="Vimeo"><img src="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-vimeo-tn.jpg" /></a>
		<a href="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video1.mp4" data-webm="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video1.webm" class="wplightbox" data-group="gallery0" data-thumbnail="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video-tn.jpg" title="Video"><img src="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video-tn.jpg" /></a>
		</p>
		<p>Demo code:</p>
		<div class="code">
		&lt;a href=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image1.jpg&quot; <span>class=&quot;wplightbox&quot;</span> <span>data-group=&quot;gallery0&quot;</span> <span>data-thumbnail=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image1-tn.jpg&quot;</span> title=&quot;Image&quot;&gt;Image&lt;/a&gt;
		<br /><br />&lt;a href=&quot;http://www.youtube.com/embed/c9-gOVGjHvQ?rel=0&amp;vq=hd1080&quot; <span>class=&quot;wplightbox&quot;</span> <span>data-group=&quot;gallery0&quot;</span> <span>data-thumbnail=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-youtube-tn.jpg&quot;</span> title=&quot;YouTube&quot;&gt;YouTube&lt;/a&gt;
		<br /><br />&lt;a href=&quot;http://player.vimeo.com/video/147149584?title=0&amp;byline=0&amp;portrait=0&quot; <span>class=&quot;wplightbox&quot;</span> <span>data-group=&quot;gallery0&quot;</span> <span>data-thumbnail=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-vimeo-tn.jpg&quot;</span> title=&quot;Vimeo&quot;&gt;Vimeo&lt;/a&gt;
		<br /><br />&lt;a href=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video1.mp4&quot; data-webm=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video1.webm&quot; <span>class=&quot;wplightbox&quot;</span> <span>data-group=&quot;gallery0&quot;</span> <span>data-thumbnail=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-video-tn.jpg&quot;</span> title=&quot;Video&quot;&gt;Video&lt;/a&gt;
		</div>
		
		<h3 id="textlightbox">Show title and description in Lightbox</h3>
		<p>To show a title, use attribute <code>title</code>.</p>
		<p>To show a description, you need to enable the option <code>Show description</code> in the Lightbox Options page, then add data tag <code>data-description</code> to your link.</p>
		<p>Live demo: <a href="<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image2.jpg" class="wplightbox" title="You can display a title." data-description="You can also display a description." >Lightbox with title and description</a></p>
		<p>Demo code:</p>
		<div class="code">&lt;a href=&quot;<?php echo WONDERPLUGIN_LIGHTBOX_URL; ?>images/demo-image2.jpg&quot; <span>class=&quot;wplightbox&quot;</span> title=&quot;You can display a title.&quot; data-description=&quot;You can also display a description.&quot; &gt;Image Lightbox&lt;/a&gt;</div>
		
		<h3 id="datatags">Customise the lightbox with data tags - display text on the right side of the lightbox</h3>
		<p>You can change the lightbox options in the plugin menu -> Lightbox Options. The change will apply to all lightboxes on the website.</p>
		<p>Instead of changing options for all lightboxes, you can also use data tags to change the specified lightbox link. The following demo will use data tag to display the text on the right side of the lightbox.</p>
		<p>Live demo: <a href="https://www.youtube.com/watch?v=c9-gOVGjHvQ" class="wplightbox" data-titlestyle="right" data-width="640" data-height="360" title="WonderPlugin Carousel" data-description="WonderPlugin Carousel is a WordPress plugin that enables you to create WordPress posts carousel for categories, WordPress recent posts carousel, image carousel slider, image scroller and video LightBox. The plugin supports WordPress posts, images, YouTube, Vimeo, mp4 and webm videos. It's fully responsive, works on iPhone, iPad, Android, Firefox, Chrome, Safari, Opera and Internet Explorer 7/8/9/10/11.">YouTube Lightbox</a></p>
		<p>The HTML code is as following:</p>
		<div class="code">&lt;a href=&quot;https://www.youtube.com/watch?v=c9-gOVGjHvQ&quot; class=&quot;wplightbox&quot; <span>data-titlestyle=&quot;right&quot;</span> data-width=&quot;640&quot; data-height=&quot;360&quot; title=&quot;WonderPlugin Carousel&quot; data-description=&quot;WonderPlugin Carousel is a WordPress plugin that enables you to create WordPress posts carousel for categories, WordPress recent posts carousel, image carousel slider, image scroller and video LightBox. The plugin supports WordPress posts, images, YouTube, Vimeo, mp4 and webm videos. It&apos;s fully responsive, works on iPhone, iPad, Android, Firefox, Chrome, Safari, Opera and Internet Explorer 7/8/9/10/11.&quot;&gt;YouTube Lightbox&lt;/a&gt;</div>
		<p>For all available data tag options, please view <a href="https://www.wonderplugin.com/wordpress-lightbox/wordpress-lightbox-options/" target="_blank">WonderPlugin Lightbox Options</a></p>
		<h3 id="divlightbox">Open a div in Lightbox</h3>
		<p>To open a div in the lightbox, firstly, define a div with an ID in your webpage. You can add CSS style <code>display:none;</code> to make it invisible on the page.</p>
		
		<p>Live demo: <a href="#mydiv" class="wplightbox" data-width=800 data-height=400 >Open a Div in Lightbox</a></p>
		
		<p>Demo code:</p>
		<div class="code">
<pre>
&lt;div id=&quot;mydiv&quot; style=&quot;display:none;&quot;&gt;
  &lt;div class=&quot;lightboxcontainer&quot;&gt;
	&lt;div class=&quot;lightboxleft&quot;&gt;
	  &lt;div class=&quot;divtext&quot;&gt;
		&lt;p class=&quot;divtitle&quot; style=&quot;font-size:16px;font-weight:bold;margin:12px 0px;&quot;&gt;WonderPlugin Gallery&lt;/p&gt;
		&lt;p class=&quot;divdescription&quot; style=&quot;font-size:14px;line-height:20px;&quot;&gt;WonderPlugin Gallery is a WordPress photo and video gallery plugin, and a great way to showcase your images and videos online. The plugin supports images, YouTube, Vimeo, Dailymotion, mp4 and webm videos. It's fully responsive, works on iPhone, iPad, Android, Firefox, Chrome, Safari, Opera and Internet Explorer 7/8/9/10/11.&lt;/p&gt;
	  &lt;/div&gt;
	&lt;/div&gt;
	&lt;div class=&quot;lightboxright&quot;&gt;
	  &lt;iframe width=&quot;100%&quot; height=&quot;100%&quot; src=&quot;https://www.youtube.com/embed/wswxQ3mhwqQ&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;
	&lt;/div&gt;
	&lt;div style=&quot;clear:both;&quot;&gt;&lt;/div&gt;
&lt;/div&gt;&lt;/div&gt;
</pre>
		</div>
		
		<p>To make the content itself responsive, add the following CSS code to your webpage:</p>
		<div class="code">
<pre>
&lt;style type=&quot;text/css&quot;&gt;
.lightboxcontainer {
  width:100%;
  text-align:left;
}
.lightboxleft {
  width: 40%;
  float:left;
}
.lightboxright {
  width: 60%;
  float:left;
}
.lightboxright iframe {
  min-height: 390px;
}
.divtext {
  margin: 36px;
}
@media (max-width: 800px) {
  .lightboxleft {
    width: 100%;
  }
  .lightboxright {
    width: 100%;
  }
  .divtext {
    margin: 12px;
  }
}
&lt;/style&gt;
</pre></div>
		
		<p>You can then use <code>#DIVID</code> as the href value of the lightbox link.</p>
		<p>Demo code:</p>
		<div class="code">
		&lt;a href=&quot;#mydiv&quot; class=&quot;wplightbox&quot; data-width=800 data-height=400 title=&quot;Inline Div&quot;&gt;Open a Div in Lightbox&lt;/a&gt;
		</div>
		
		<style type="text/css">
		.lightboxcontainer {
		  width:100%;
		  text-align:left;
		}
		.lightboxleft {
		  width: 40%;
		  float:left;
		}
		.lightboxright {
		  width: 60%;
		  float:left;
		}
		.lightboxright iframe {
		  min-height: 390px;
		}
		.divtext {
		  margin: 36px;
		}
		@media (max-width: 800px) {
		  .lightboxleft {
		    width: 100%;
		  }
		  .lightboxright {
		    width: 100%;
		  }
		  .divtext {
		    margin: 12px;
		  }
		}
		</style>
		
		<div id="mydiv" style="display:none;">
		  <div class="lightboxcontainer">
			<div class="lightboxleft">
			  <div class="divtext">
				<p class="divtitle" style="font-size:16px;font-weight:bold;margin:12px 0px;">WonderPlugin Gallery</p>
				<p class="divdescription" style="font-size:14px;line-height:20px;">WonderPlugin Gallery is a WordPress photo and video gallery plugin, and a great way to showcase your images and videos online. The plugin supports images, YouTube, Vimeo, Dailymotion, mp4 and webm videos. It's fully responsive, works on iPhone, iPad, Android, Firefox, Chrome, Safari, Opera and Internet Explorer 7/8/9/10/11.</p>
			  </div>
			</div>
			<div class="lightboxright">
			  <iframe width="100%" height="100%" src="https://www.youtube.com/embed/wswxQ3mhwqQ" frameborder="0" allowfullscreen></iframe>
			</div>
			<div style="clear:both;"></div>
		</div></div>

		<?php 
	}
	
	function print_edit_settings() {
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-lightbox" class="icon32"><br /></div>
			
		<h2><?php _e( 'Settings', 'wonderplugin_lightbox' ); ?> </h2>
		<?php

		if ( isset($_POST['save-lightbox-options']) && check_admin_referer('wonderplugin-lightbox', 'wonderplugin-lightbox-settings'))
		{		
			unset($_POST['save-lightbox-options']);
			
			$this->controller->save_settings($_POST);
			
			echo '<div class="updated"><p>Settings saved.</p></div>';
		}
								
		$settings = $this->controller->get_settings();
		$keepdata = $settings['keepdata'];
		$disableupdate = $settings['disableupdate'];
		$addjstofooter = $settings['addjstofooter'];
		
		?>
				
        <form method="post">
        
        <?php wp_nonce_field('wonderplugin-lightbox', 'wonderplugin-lightbox-settings'); ?>
        
        <table class="form-table">
		
		<tr>
			<th>Data option</th>
			<td><label><input name='keepdata' type='checkbox' id='keepdata' <?php echo ($keepdata == 1) ? 'checked' : ''; ?> /> Keep data when deleting the plugin</label>
			</td>
		</tr>
		
		<tr>
			<th>Update option</th>
			<td><label><input name='disableupdate' type='checkbox' id='disableupdate' <?php echo ($disableupdate == 1) ? 'checked' : ''; ?> /> Disable plugin version check and update</label>
			</td>
		</tr>
		
		<tr>
			<th>Scripts position</th>
			<td><label><input name='addjstofooter' type='checkbox' id='addjstofooter' <?php echo ($addjstofooter == 1) ? 'checked' : ''; ?> /> Add plugin js scripts to the footer (wp_footer hook must be implemented by the WordPress theme)</label>
			</td>
		</tr>
		
        </table>
        
        <p class="submit"><input type="submit" name="save-lightbox-options" id="save-lightbox-options" class="button button-primary" value="Save Changes"  /></p>
        
        </form>
        
		</div>
		<?php
	}
		
	function print_register() {
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-lightbox" class="icon32"><br /></div>
			
		<h2><?php _e( 'Register', 'wonderplugin_lightbox' ); ?></h2>
		<?php
				
		if (isset($_POST['save-lightbox-license']) && check_admin_referer('wonderplugin-lightbox', 'wonderplugin-lightbox-register'))
		{		
			unset($_POST['save-lightbox-license']);

			$ret = $this->controller->check_license($_POST);
			
			if ($ret['status'] == 'valid')
				echo '<div class="updated"><p>The key has been saved.</p></div>';
			else if ($ret['status'] == 'expired')
				echo '<div class="error"><p>Your free upgrade period has expired, please renew your license.</p></div>';
			else if ($ret['status'] == 'invalid')
				echo '<div class="error"><p>The key is invalid.</p></div>';
			else if ($ret['status'] == 'abnormal')
				echo '<div class="error"><p>You have reached the maximum website limit of your license key. Please log into the membership area and upgrade to a higher license.</p></div>';
			else if ($ret['status'] == 'misuse')
				echo '<div class="error"><p>There is a possible misuse of your license key, please contact support@wonderplugin.com for more information.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>Please enter your license key.</p></div>';
			else if (isset($ret['message']))
				echo '<div class="error"><p>' . $ret['message'] . '</p></div>';
		}
		else if (isset($_POST['deregister-lightbox-license']) && check_admin_referer('wonderplugin-lightbox', 'wonderplugin-lightbox-register'))
		{	
			$ret = $this->controller->deregister_license($_POST);
			
			if ($ret['status'] == 'success')
				echo '<div class="updated"><p>The key has been deregistered.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>The license key is empty.</p></div>';
		}
		
		$settings = $this->controller->get_settings();
		$disableupdate = $settings['disableupdate'];
		
		$key = '';
		$info = $this->controller->get_plugin_info();
		if (!empty($info->key) && ($info->key_status == 'valid' || $info->key_status == 'expired'))
			$key = $info->key;
		
		?>
		
		<?php 
		if ($disableupdate == 1)
		{
			echo "<h3 style='padding-left:10px;'>The plugin version check and update is currently disabled. You can enable it in the Settings menu.</h3>";
		}
		else
		{
		?> <div style="padding-left:10px;padding-top:12px;"> <?php
			if (empty($key)) { ?>
				<form method="post">
				<?php wp_nonce_field('wonderplugin-lightbox', 'wonderplugin-lightbox-register'); ?>
				<table class="form-table">
				<tr>
					<th>Enter Your License Key:</th>
					<td><input name="wonderplugin-lightbox-key" type="text" id="wonderplugin-lightbox-key" value="" class="regular-text" /> <input type="submit" name="save-lightbox-license" id="save-lightbox-license" class="button button-primary" value="Register License Key"  />
					</td>
				</tr>
				</table>
				</form>
			<?php } else { ?>
				<form method="post">
				<?php wp_nonce_field('wonderplugin-lightbox', 'wonderplugin-lightbox-register'); ?>
				<p>You have entered your license key and this domain has been successfully registered. &nbsp;&nbsp;<input name="wonderplugin-lightbox-key" type="hidden" id="wonderplugin-lightbox-key" value="<?php echo esc_html($key); ?>" class="regular-text" /><input type="submit" name="deregister-lightbox-license" id="deregister-lightbox-license" class="button button-primary" value="Deregister Your License Key"  /></p>
				</form>
				<?php if ($info->key_status == 'expired') { ?>
				<p><strong>Your free upgrade period has expired.</strong> To get upgrades, please <a href="https://www.wonderplugin.com/renew/" target="_blank">renew your license</a>.</p>
				<?php } ?>
			<?php } ?>
			</div>
		<?php } ?>
		
		<div style="padding-left:10px;padding-top:30px;">
		<a href="<?php echo admin_url('update-core.php?force-check=1'); ?>"><button class="button-primary">Force WordPress To Check For Plugin Updates</button></a>
		</div>
					
		<div style="padding-left:10px;padding-top:20px;">
        <ul style="list-style-type:square;font-size:16px;line-height:28px;margin-left:24px;">
		<li><a href="https://www.wonderplugin.com/how-to-upgrade-a-commercial-version-plugin-to-the-latest-version/" target="_blank">How to upgrade to the latest version</a></li>
	    <li><a href="https://www.wonderplugin.com/register-faq/" target="_blank">Where can I find my license key and other frequently asked questions</a></li>
	    </ul>
        </div>
        
		</div>
		
		<?php
	}
}