<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	global $wpdb;
	$hugeit_lightbox = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "hugeit_lightbox (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` text NOT NULL,
		`title` text NOT NULL,
		`value` text NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$wpdb->query($hugeit_lightbox);
	$sql_hugeit_lightbox = "INSERT INTO " . $wpdb->prefix . "hugeit_lightbox (`name`, `title`, `value`) VALUES	
	('light_box_size', 'Light box size', '17'),
	('light_box_width', 'Light Box width', '500'),
	('light_box_transition', 'Light Box Transition', 'elastic'),
	('light_box_speed', 'Light box speed', '800'),
	('light_box_href', 'Light box href', 'False'),
	('light_box_title', 'Light box Title', 'false'),
	('light_box_scalephotos', 'Light box scalePhotos', 'true'),
	('light_box_rel', 'Light Box rel', 'false'),
	('light_box_scrolling', 'Light box Scrollin', 'false'),
	('light_box_opacity', 'Light box Opacity', '20'),
	('light_box_open', 'Light box Open', 'false'),
	('light_box_overlayclose', 'Light box overlayClose', 'true'),
	('light_box_esckey', 'Light box escKey', 'false'),
	('light_box_arrowkey', 'Light box arrowKey', 'false'),
	('light_box_loop', 'Light box loop', 'true'),
	('light_box_data', 'Light box data', 'false'),
	('light_box_classname', 'Light box className', 'false'),
	('light_box_fadeout', 'Light box fadeOut', '300'),
	('light_box_closebutton', 'Light box closeButton', 'true'),
	('light_box_current', 'Light box current', 'image'),
	('light_box_previous', 'Light box previous', 'previous'),
	('light_box_next', 'Light box next', 'next'),
	('light_box_close', 'Light box close', 'close'),
	('light_box_iframe', 'Light box iframe', 'false'),
	('light_box_inline', 'Light box inline', 'false'),
	('light_box_html', 'Light box html', 'false'),
	('light_box_photo', 'Light box photo', 'false'),
	('light_box_height', 'Light box height', '500'),
	('light_box_innerwidth', 'Light box innerWidth', 'false'),
	('light_box_innerheight', 'Light box innerHeight', 'false'),
	('light_box_initialwidth', 'Light box initialWidth', '300'),
	('light_box_initialheight', 'Light box initialHeight', '100'),
	('light_box_maxwidth', 'Light box maxWidth', '768'),
	('light_box_maxheight', 'Light box maxHeight', '500'),
	('light_box_slideshow', 'Light box slideshow', 'false'),
	('light_box_slideshowspeed', 'Light box slideshowSpeed', '2500'),
	('light_box_slideshowauto', 'Light box slideshowAuto', 'true'),
	('light_box_slideshowstart', 'Light box slideshowStart', 'start slideshow'),
	('light_box_slideshowstop', 'Light box slideshowStop', 'stop slideshow'),
	('light_box_fixed', 'Light box fixed', 'true'),
	('light_box_top', 'Light box top', 'false'),
	('light_box_bottom', 'Light box bottom', 'false'),
	('light_box_left', 'Light box left', 'false'),
	('light_box_right', 'Light box right', 'false'),
	('light_box_reposition', 'Light box reposition', 'false'),
	('light_box_retinaimage', 'Light box retinaImage', 'true'),
	('light_box_retinaurl', 'Light box retinaUrl', 'false'),
	('light_box_retinasuffix', 'Light box retinaSuffix', '@2x.$1'),
	('light_box_returnfocus', 'Light box returnFocus', 'true'),
	('light_box_trapfocus', 'Light box trapFocus', 'true'),
	('light_box_fastiframe', 'Light box fastIframe', 'true'),
	('light_box_preloading', 'Light box preloading', 'true'),
	('slider_title_position', 'Slider title position', '5'),
	('light_box_style', 'Light Box style', '1')";
	if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "hugeit_lightbox")) {
		$wpdb->query($sql_hugeit_lightbox);
	}
		///////////////////////////update////////////////////////////////////
    $table_name = $wpdb->prefix . "hugeit_lightbox";
	$sql_update_p1 = <<<query1
	INSERT INTO `$table_name` (`name`, `title`, `value`) VALUES
	('light_box_size_fix', 'Light Box size fix', 'false')

query1;

	$query="SELECT name FROM ".$wpdb->prefix."hugeit_lightbox";
	$update_p1=$wpdb->get_results($query);
	if(end($update_p1)->name=='light_box_style'){
		$wpdb->query($sql_update_p1);
	}
        
$table_name = $wpdb->prefix . "hugeit_lightbox";
	$sql_update_p2 = <<<query2
	UPDATE `$table_name` set value='true' WHERE name='light_box_closebutton';
query2;

	$query2="SELECT * FROM ".$wpdb->prefix."hugeit_lightbox WHERE name='light_box_closebutton'";
	$update_p2=$wpdb->get_row($query2);
	if($update_p2->value=='false') {
		$wpdb->query($sql_update_p2);
	}
?>