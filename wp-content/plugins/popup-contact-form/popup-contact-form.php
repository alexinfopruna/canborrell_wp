<?php
/*
Plugin Name: Popup contact form
Description: Plugin allows user to create and add the popup contact forms easily on the website. That popup contact form let user to send the emails to site admin.
Author: Gopi Ramasamy
Version: 7.1
Plugin URI: http://www.gopiplus.com/work/2012/05/18/popup-contact-form-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2012/05/18/popup-contact-form-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2012/05/18/popup-contact-form-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: popup-contact-form
Domain Path: /languages
*/

function PopupContact()
{
	$display = "dontshow";
	if(is_home() && get_option('PopupContact_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('PopupContact_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('PopupContact_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('PopupContact_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('PopupContact_On_Search') == 'YES') {	$display = "show";	}
	
	if($display == "show")
	{
		?>
<a href='javascript:PopupContact_OpenForm("PopupContact_BoxContainer","PopupContact_BoxContainerBody","PopupContact_BoxContainerFooter");'><?php echo get_option('PopupContact_Caption'); ?></a>
<div style="display: none;" id="PopupContact_BoxContainer">
  <div id="PopupContact_BoxContainerHeader">
    <div id="PopupContact_BoxTitle"><?php echo get_option('PopupContact_title'); ?></div>
    <div id="PopupContact_BoxClose"><a href="javascript:PopupContact_HideForm('PopupContact_BoxContainer','PopupContact_BoxContainerFooter');"><?php _e('Close', 'popup-contact-form'); ?></a></div>
  </div>
  <div id="PopupContact_BoxContainerBody">
    <form action="#" name="PopupContact_Form" id="PopupContact_Form">
      <div id="PopupContact_BoxAlert"> <span id="PopupContact_alertmessage"></span> </div>
      <div id="PopupContact_BoxLabel"> <?php _e('Your Name', 'popup-contact-form'); ?> </div>
      <div id="PopupContact_BoxLabel">
        <input name="PopupContact_name" class="PopupContact_TextBox" type="text" id="PopupContact_name" maxlength="120">
      </div>
      <div id="PopupContact_BoxLabel"> <?php _e('Your Email', 'popup-contact-form'); ?> </div>
      <div id="PopupContact_BoxLabel">
        <input name="PopupContact_email" class="PopupContact_TextBox" type="text" id="PopupContact_email" maxlength="120">
      </div>
      <div id="PopupContact_BoxLabel"> <?php _e('Enter Your Message', 'popup-contact-form'); ?> </div>
      <div id="PopupContact_BoxLabel">
        <textarea name="PopupContact_message" class="PopupContact_TextArea" rows="3" id="PopupContact_message"></textarea>
      </div>
      <div id="PopupContact_BoxLabel">
        <input type="button" name="button" class="PopupContact_Button" value="Submit" onClick="javascript:PopupContact_Submit(this.parentNode,'<?php echo home_url(); ?>');">
      </div>
    </form>
  </div>
</div>
<div style="display: none;" id="PopupContact_BoxContainerFooter"></div>
<?php
	}
}

function PopupContact_install() 
{
	global $wpdb, $wp_version;
	add_option('PopupContact_title', "Contact Us");
	add_option('PopupContact_fromemail', "admin@contactform.com");
	add_option('PopupContact_On_Homepage', "YES");
	add_option('PopupContact_On_Posts', "YES");
	add_option('PopupContact_On_Pages', "YES");
	add_option('PopupContact_On_Archives', "NO");
	add_option('PopupContact_On_Search', "NO");
	add_option('PopupContact_On_SendEmail', "YES");
	add_option('PopupContact_On_MyEmail', "YOUR-EMAIL-ADDRESS-TO-RECEIVE-MAILS");
	add_option('PopupContact_On_Subject', "EMAIL-SUBJECT");
	add_option('PopupContact_On_Captcha', "YES");
	add_option('PopupContact_Caption', "<img src='".get_option('siteurl')."/wp-content/plugins/popup-contact-form/popup-contact-form.jpg' />");
	$url = home_url();
	add_option('PopupContact_homeurl', $url);
}

function PopupContact_widget($args) 
{
	$display = "dontshow";
	if(is_home() && get_option('PopupContact_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('PopupContact_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('PopupContact_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('PopupContact_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('PopupContact_On_Search') == 'YES') {	$display = "show";	}
	
	$title = get_option('PopupContact_title');
	if($display == "show")
	{
		//extract($args);
	    //echo $before_widget;
		//PopupContact();
		//echo $after_widget;
		
		//[popup-contact-form id="1" title="Contact Us"]
		$arr = array();
		$arr["id"] 	= 2;
		$arr["title"] = $title;
		echo PopupContact_shortcode($arr);
	}
}
	
function PopupContact_control() 
{
	echo '<p>';
	_e('Check official website for more information', 'popup-contact-form');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2012/05/18/popup-contact-form-wordpress-plugin/"><?php _e('click here', 'popup-contact-form'); ?></a></p><?php
}

function PopupContact_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget( 'popup-contact-form', __('Popup contact form', 'popup-contact-form'), 'PopupContact_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control( 'popup-contact-form', array(__('Popup contact form', 'popup-contact-form'), 'widgets'), 'PopupContact_control');
	} 
}

function PopupContact_deactivation() 
{
	// No action required.
}

function PopupContact_admin()
{
	global $wpdb;
	include('content-setting.php');
}

function PopupContact_add_to_menu() 
{
	add_options_page( __('Popup contact form', 'popup-contact-form'), __('Popup contact form', 'popup-contact-form'), 'manage_options', __FILE__, 'PopupContact_admin' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'PopupContact_add_to_menu');
}

function PopupContact_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_style( 'popup-contact-form', get_option('siteurl').'/wp-content/plugins/popup-contact-form/popup-contact-form.css');
		wp_enqueue_script( 'popup-contact-form', get_option('siteurl').'/wp-content/plugins/popup-contact-form/popup-contact-form.js');
		wp_enqueue_script( 'popup-contact-popup', get_option('siteurl').'/wp-content/plugins/popup-contact-form/popup-contact-popup.js');
	}
}   

function PopupContact_shortcode( $atts ) 
{
	//[popup-contact-form id="1" title="Contact Us"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	
	$id = $atts['id'];
	$title = $atts['title'];
	
	$PopupContact_Caption = get_option('PopupContact_Caption');
	$PopupContact_title = $title;
	$siteurl = "'". home_url() . "'";
	$close = "javascript:PopupContact_HideForm('PopupContact_BoxContainer','PopupContact_BoxContainerFooter');";
	$open = 'javascript:PopupContact_OpenForm("PopupContact_BoxContainer","PopupContact_BoxContainerBody","PopupContact_BoxContainerFooter");';
	
	$html = "<a href='".$open."'>".$PopupContact_Caption."</a>";
	$html .= '<div style="display: none;" id="PopupContact_BoxContainer">';
	  $html .= '<div id="PopupContact_BoxContainerHeader">';
		$html .= '<div id="PopupContact_BoxTitle">'.$PopupContact_title.'</div>';
		$html .= '<div id="PopupContact_BoxClose"><a href="'.$close.'">'.__('Close', 'popup-contact-form').'</a></div>';
	  $html .= '</div>';
	  $html .= '<div id="PopupContact_BoxContainerBody">';
		$html .= '<form action="#" name="PopupContact_Form" id="PopupContact_Form">';
		  $html .= '<div id="PopupContact_BoxAlert"> <span id="PopupContact_alertmessage"></span> </div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page"> '.__('Your Name', 'popup-contact-form').' </div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page">';
			$html .= '<input name="PopupContact_name" class="PopupContact_TextBox" type="text" id="PopupContact_name" maxlength="120">';
		  $html .= '</div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page"> '.__('Your Email', 'popup-contact-form').' </div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page">';
			$html .= '<input name="PopupContact_email" class="PopupContact_TextBox" type="text" id="PopupContact_email" maxlength="120">';
		  $html .= '</div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page"> '.__('Enter Your Message', 'popup-contact-form').' </div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page">';
			$html .= '<textarea name="PopupContact_message" class="PopupContact_TextArea" rows="3" id="PopupContact_message"></textarea>';
		  $html .= '</div>';
		  $html .= '<div id="PopupContact_BoxLabel_Page">';
			$html .= '<input type="button" name="button" class="PopupContact_Button" value="Submit" onClick="javascript:PopupContact_Submit(this.parentNode,'.$siteurl.');">';
		  $html .= '</div>';
		$html .= '</form>';
	  $html .= '</div>';
	$html .= '</div>';
	$html .= '<div style="display: none;" id="PopupContact_BoxContainerFooter"></div>';
	
	return $html;
}

function PopupContact_textdomain() 
{
	  load_plugin_textdomain( 'popup-contact-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function PopupContact_plugin_query_vars($vars) 
{
	$vars[] = 'popupcontact';
	return $vars;
}

function PopupContact_plugin_parse_request($qstring)
{
	if (array_key_exists('popupcontact', $qstring->query_vars)) 
	{
		$page = $qstring->query_vars['popupcontact'];
		switch($page)
		{
			case 'send-mail':				
				$PopupContact_name = isset($_POST['PopupContact_name']) ? sanitize_text_field($_POST['PopupContact_name']) : '';
				$PopupContact_email = isset($_POST['PopupContact_email']) ? sanitize_text_field($_POST['PopupContact_email']) : '';
				$PopupContact_email = sanitize_email($PopupContact_email);
				if($PopupContact_email <> "")
				{
					if (!filter_var($PopupContact_email, FILTER_VALIDATE_EMAIL))
					{
						echo "invalid-email";
					}
					else
					{
						$homeurl = get_option('PopupContact_homeurl');
						if($homeurl == "")
						{
							$homeurl = home_url();
						}
						
						$samedomain = strpos($_SERVER['HTTP_REFERER'], $homeurl);
						if (($samedomain !== false) && $samedomain < 5) 
						{
							$PopupContact_message = stripslashes(sanitize_text_field($_POST['PopupContact_message']));
							$PopupContact_On_MyEmail = stripslashes(get_option('PopupContact_On_MyEmail'));
							$PopupContact_On_Subject = stripslashes(get_option('PopupContact_On_Subject'));
	
							$sender_email = esc_sql(trim($PopupContact_email));
							$sender_name = esc_sql(trim($PopupContact_name));
							$subject = $PopupContact_On_Subject;
							$message = $PopupContact_message;
							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
							$headers .= "From: \"$sender_name\" <$sender_email>\n";
							$headers .= "Return-Path: <" . esc_sql(trim($PopupContact_email)) . ">\n";
							$headers .= "Reply-To: \"" . esc_sql(trim($PopupContact_name)) . "\" <" . esc_sql(trim($PopupContact_email)) . ">\n";
							$mailtext = str_replace("\r\n", "<br />", $message);
							@wp_mail($PopupContact_On_MyEmail, $subject, $mailtext, $headers);
		
							echo "mail-sent-successfully";
						}
						else
						{
							echo "there-was-problem";
						}
					}
				}
				else
				{
					echo "empty-email";
				}
				die();
				break;		
		}
	}
}

add_action('parse_request', 'PopupContact_plugin_parse_request');
add_filter('query_vars', 'PopupContact_plugin_query_vars');
add_action('plugins_loaded', 'PopupContact_textdomain');
add_shortcode( 'popup-contact-form', 'PopupContact_shortcode' );
add_action('wp_enqueue_scripts', 'PopupContact_add_javascript_files');
add_action("plugins_loaded", "PopupContact_widget_init");
register_activation_hook(__FILE__, 'PopupContact_install');
register_deactivation_hook(__FILE__, 'PopupContact_deactivation');
//add_action('init', 'PopupContact_widget_init');
?>