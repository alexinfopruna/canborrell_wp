<?php 

require_once 'wonderplugin-lightbox-functions.php';

class WonderPlugin_Lightbox_Model {

	private $controller;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function get_upload_path() {
		
		$uploads = wp_upload_dir();
		return $uploads['basedir'] . '/wonderplugin-lightbox/';
	}
	
	function get_upload_url() {
	
		$uploads = wp_upload_dir();
		return $uploads['baseurl'] . '/wonderplugin-lightbox/';
	}
		
	function save_options($options) {
		
		foreach ($options as $key => &$value)
			$value = wp_kses_post($value);
		
		$options['autoslide'] = isset($options['autoslide']) ? true : false;
		$options['showtimer'] = isset($options['showtimer']) ? true : false;
		$options['showplaybutton'] = isset($options['showplaybutton']) ? true : false;
		$options['alwaysshownavarrows'] = isset($options['alwaysshownavarrows']) ? true : false;
		$options['showtitleprefix'] = isset($options['showtitleprefix']) ? true : false;
		$options['slideinterval'] = intval(trim($options['slideinterval']));
		$options['timerheight'] = intval(trim($options['timerheight']));
		$options['bordersize'] = intval(trim($options['bordersize']));
		$options['timeropacity'] = floatval(trim($options['timeropacity']));
		$options['timerposition'] = trim($options['timerposition']);
		$options['timercolor'] = trim($options['timercolor']);
		
		$options['bordertopmargin'] = intval(trim($options['bordertopmargin']));
		
		$options['responsive'] = isset($options['responsive']) ? true : false;
		$options['autoplay'] = isset($options['autoplay']) ? true : false;
		$options['html5player'] = isset($options['html5player']) ? true : false;
		$options['showtitle'] = isset($options['showtitle']) ? true : false;
		$options['defaultvideovolume'] = floatval(trim($options['defaultvideovolume']));
		$options['enabletouchswipe'] = isset($options['enabletouchswipe']) ? true : false;
		
		$options['fullscreenmode'] = isset($options['fullscreenmode']) ? true : false;
		$options['titlestyle'] = trim($options['titlestyle']);
		$options['imagepercentage'] = intval(trim($options['imagepercentage']));
		$options['closeonoverlay'] = isset($options['closeonoverlay']) ? true : false;
		$options['videohidecontrols'] = isset($options['videohidecontrols']) ? true : false;
		
		$options['overlaybgcolor'] = trim($options['overlaybgcolor']);
		$options['overlayopacity'] = floatval(trim($options['overlayopacity']));
		$options['bgcolor'] = trim($options['bgcolor']);
		$options['borderradius'] = intval(trim($options['borderradius']));
		
		$options['thumbwidth'] = intval(trim($options['thumbwidth']));
		$options['thumbheight'] = intval(trim($options['thumbheight']));
		$options['thumbtopmargin'] = intval(trim($options['thumbtopmargin']));
		$options['thumbbottommargin'] = intval(trim($options['thumbbottommargin']));
		
		$options['barheight'] = intval(trim($options['barheight']));
		$options['titlebottomcss'] = trim($options['titlebottomcss']);
		
		$options['showdescription'] = isset($options['showdescription']) ? true : false;
		$options['descriptionbottomcss'] = trim($options['descriptionbottomcss']);
		
		$options['titleprefix'] = trim($options['titleprefix']);
		$options['titleinsidecss'] = trim($options['titleinsidecss']);
		$options['descriptioninsidecss'] = trim($options['descriptioninsidecss']);
		
		$options['advancedoptions'] = trim($options['advancedoptions']);
		
		$options['videobgcolor'] = trim($options['videobgcolor']);
		$options['html5videoposter'] = trim($options['html5videoposter']);
		$options['responsivebarheight'] = isset($options['responsivebarheight']) ? true : false;
		$options['smallscreenheight'] = intval(trim($options['smallscreenheight']));
		$options['barheightonsmallheight'] = intval(trim($options['barheightonsmallheight']));
		$options['notkeepratioonsmallheight'] = isset($options['notkeepratioonsmallheight']) ? true : false;
		
		$options['showsocial'] = isset($options['showsocial']) ? true : false;
		$options['socialposition'] = trim($options['socialposition']);
		$options['socialpositionsmallscreen'] = trim($options['socialpositionsmallscreen']);
		$options['socialdirection'] = trim($options['socialdirection']);
		$options['socialbuttonsize'] = intval(trim($options['socialbuttonsize']));
		$options['socialbuttonfontsize'] = intval(trim($options['socialbuttonfontsize']));
		$options['socialrotateeffect'] = isset($options['socialrotateeffect']) ? true : false;
		$options['showfacebook'] = isset($options['showfacebook']) ? true : false;
		$options['showtwitter'] = isset($options['showtwitter']) ? true : false;
		$options['showpinterest'] = isset($options['showpinterest']) ? true : false;
		
		update_option( "wonderplugin-lightbox-options", json_encode($options) );
	}
	
	function read_options() {

		$default = array(
				'autoslide' => 	false,
				'slideinterval' => 5000,
				'showtimer' => true,
				'timerposition' => "bottom",
				'timerheight' => 2,
				'timercolor' => "#dc572e",
				'timeropacity' => 1,
				'showplaybutton' =>	true,
				'alwaysshownavarrows' => false,
				'bordersize' => 8,
				'showtitleprefix' => true,
				'responsive' => true,
				'fullscreenmode' => false,
				'closeonoverlay'	=> true,
				'videohidecontrols'	=> false,
				'titlestyle'	=> 'bottom',
				'imagepercentage' => 75,
				'enabletouchswipe'	=> true,
				'autoplay' => true,
				'html5player' => true,
				'overlaybgcolor' => '#000',
				'overlayopacity' => 0.8,
				'defaultvideovolume' => 1,
				'bgcolor' => '#FFF',
				'borderradius' => 0,
				'thumbwidth' => 96,
				'thumbheight' => 72,
				'thumbtopmargin' => 12,
				'thumbbottommargin' => 12,
				'barheight' => 64,
				'showtitle' => true,
				'titleprefix' => '%NUM / %TOTAL',
				'titlebottomcss' => 'color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;',
				'showdescription' => true,
				'descriptionbottomcss' => 'color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;',
				'titleinsidecss' => "color:#fff; font-size:16px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left;",
				'descriptioninsidecss' => "color:#fff; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;",
				'advancedoptions' => '',
				'videobgcolor' => '#000',
				'html5videoposter' => '',
				'responsivebarheight' => false,
				'smallscreenheight' => 415,
				'barheightonsmallheight' => 64,
				'notkeepratioonsmallheight' => false,
				'showsocial' =>	false,
				'socialposition' =>	'position:absolute;top:100%;right:0;',
				'socialpositionsmallscreen' => 'position:absolute;top:100%;right:0;left:0;',
				'socialdirection' => 'horizontal',
				'socialbuttonsize' => 32,
				'socialbuttonfontsize' => 18,
				'socialrotateeffect' =>	true,
				'showfacebook' => true,
				'showtwitter' => true,
				'showpinterest' => true,
				'bordertopmargin' => 48
			);
		
		$options = json_decode(trim(get_option("wonderplugin-lightbox-options")), true);
		
		if (isset($options['advancedoptions']) && strlen($options['advancedoptions']) > 0)
		{
			$options['advancedoptions'] = stripslashes($options['advancedoptions']);
		}
		
		if( is_array($options) )
			return array_merge($default, $options);
		else
			return $default;
		
	}
	
	function print_lightbox_options() {
		
		$options = $this->read_options();
		
		$optionsdiv = '<div id="wonderpluginlightbox_options" data-skinsfoldername="skins/default/"  data-jsfolder="' . WONDERPLUGIN_LIGHTBOX_URL . 'engine/"';
		
		if (isset($options['advancedoptions']) && strlen($options['advancedoptions']) > 0)
		{
			$advancedoptions = str_replace("\r", " ", $options['advancedoptions']);
			$advancedoptions = str_replace("\n", " ", $advancedoptions);
			$optionsdiv .= ' ' . $advancedoptions;
		}
		
		foreach ($options as $key => $value)
		{
			if ($key != 'advancedoptions')
			{
				if (is_bool($value))
					$value = $value ? 'true' : 'false';
				$optionsdiv .= ' data-' . $key . '="' . $value . '"';
			}
		}
		
		$optionsdiv .= ' style="display:none;"></div>';
		if ('F' == 'F')
			$optionsdiv .= '<div class="wonderplugin-engine"><a href="http://www.wonderplugin.com/wordpress-lightbox/" title="'. get_option('wonderplugin-lightbox-engine')  .'">' . get_option('wonderplugin-lightbox-engine') . '</a></div>';
		
		echo $optionsdiv;
	}
	
	function get_settings() {
		
		$keepdata = get_option( 'wonderplugin_lightbox_keepdata', 1 );
		
		$disableupdate = get_option( 'wonderplugin_lightbox_disableupdate', 0 );
		
		$addjstofooter = get_option( 'wonderplugin_lightbox_addjstofooter', 0 );
		
		$settings = array(
				"keepdata" => $keepdata,
				"disableupdate" => $disableupdate,
				"addjstofooter" => $addjstofooter
		);
	
		return $settings;
	}
	
	function save_settings($options) {
	
		if (!isset($options) || !isset($options['keepdata']))
			$keepdata = 0;
		else
			$keepdata = 1;
		update_option( 'wonderplugin_lightbox_keepdata', $keepdata );
		
		if (!isset($options) || !isset($options['disableupdate']))
			$disableupdate = 0;
		else
			$disableupdate = 1;
		update_option( 'wonderplugin_lightbox_disableupdate', $disableupdate );
		
		if (!isset($options) || !isset($options['addjstofooter']))
			$addjstofooter = 0;
		else
			$addjstofooter = 1;
		update_option( 'wonderplugin_lightbox_addjstofooter', $addjstofooter );
	}
	
	function get_plugin_info() {
	
		$info = get_option('wonderplugin_lightbox_information');
		if ($info === false)
			return false;
	
		return unserialize($info);
	}
	
	function save_plugin_info($info) {
	
		update_option( 'wonderplugin_lightbox_information', serialize($info) );
	}
	
	function check_license($options) {
	
		$ret = array(
				"status" => "empty"
		);
	
		if ( !isset($options) || empty($options['wonderplugin-lightbox-key']) )
		{
			return $ret;
		}
	
		$key = sanitize_text_field( $options['wonderplugin-lightbox-key'] );
		if ( empty($key) )
			return $ret;
	
		$update_data = $this->controller->get_update_data('register', $key);
		if( $update_data === false )
		{
			$ret['status'] = 'timeout';
			return $ret;
		}
	
		if ( isset($update_data->key_status) )
			$ret['status'] = $update_data->key_status;
	
		return $ret;
	}
	
	function deregister_license($options) {
	
		$ret = array(
				"status" => "empty"
		);
	
		if ( !isset($options) || empty($options['wonderplugin-lightbox-key']) )
			return $ret;
	
		$key = sanitize_text_field( $options['wonderplugin-lightbox-key'] );
		if ( empty($key) )
			return $ret;
	
		$info = $this->get_plugin_info();
		$info->key = '';
		$info->key_status = 'empty';
		$info->key_expire = 0;
		$this->save_plugin_info($info);
	
		$update_data = $this->controller->get_update_data('deregister', $key);
		if ($update_data === false)
		{
			$ret['status'] = 'timeout';
			return $ret;
		}
	
		$ret['status'] = 'success';
	
		return $ret;
	}
}
