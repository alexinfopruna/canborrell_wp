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
		  $params = $_POST['params'];
		  foreach ($params as $key => $value) {
			if($value == ''){$value = 0; }
			$wpdb->update($wpdb->prefix . 'hugeit_lightbox',
				array('value' => $value),
				array('name' => $key),
				array('%s')
			);
		}
		?>
		<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
		<?php
		}
	}
}
?>