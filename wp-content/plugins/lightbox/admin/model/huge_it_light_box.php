<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Model {
	public function getlightboxList()
	{
		global $wpdb;
		$query = "SELECT *  from " . $wpdb->prefix . "hugeit_lightbox";
		$rows = $wpdb->get_results($query);
		$hugeit_lightbox_values = array();
		foreach ($rows as $row) {
			$key = $row->name;
			$value = $row->value;
			$hugeit_lightbox_values[$key] = $value;
		}
		return $hugeit_lightbox_values;
	}
	public function getlightboxSave()
	{
		global $wpdb;
		if (isset($_POST['params'])) {
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."hugeit_lightbox SET value = '%s' WHERE name = 'light_box_style'", $_POST["light_box_style"]));
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."hugeit_lightbox SET value = '%s' WHERE name = 'light_box_transition'", $_POST["light_box_transition"]));
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."hugeit_lightbox SET value = '%s' WHERE name = 'light_box_speed'", $_POST["light_box_speed"]));
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."hugeit_lightbox SET value = '%s' WHERE name = 'light_box_fadeout'", $_POST["light_box_fadeout"]));
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."hugeit_lightbox SET value = '%s' WHERE name = 'light_box_title'", $_POST["light_box_title"]));
		?>
		<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
		<?php
		}
	}
}
?>