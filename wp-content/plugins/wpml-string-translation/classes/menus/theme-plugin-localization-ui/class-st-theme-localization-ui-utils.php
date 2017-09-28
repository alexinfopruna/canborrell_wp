<?php

class WPML_ST_Theme_Localization_Utils {

	/** @return array */
	public function get_theme_data() {
		$themes     = wp_get_themes();
		$theme_data = array();

		foreach ( $themes as $theme_folder => $theme ) {
			$theme_data[ $theme_folder ] = array(
				'name' => $theme->get( 'Name' ),
				'TextDomain' => $theme->get( 'TextDomain' ),
			);
		}

		return $theme_data;
	}

	/** @return array */
	public function get_theme_localization_domains() {
		return wp_list_pluck( $this->get_theme_data(), 'TextDomain' );
	}

	/**
	 * @param WPML_Localization $wpml_localization
	 *
	 * @return array
	 */
	public function get_theme_localization_stats( WPML_Localization $wpml_localization ) {
		$theme_localization_domains = $this->get_theme_localization_domains();
		return $wpml_localization->get_theme_localization_stats( $theme_localization_domains );
	}
}