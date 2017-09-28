<?php

class WPML_ST_Theme_Localization_UI implements IWPML_Theme_Plugin_Localization_UI_Strategy {

	/** @var WPML_ST_Theme_Localization_UI */
	private $utils;

	/** @var string */
	private $template_path;

	/** @var WPML_Localization */
	private $localization;

	/**
	 * WPML_ST_Theme_Localization_UI constructor.
	 *
	 * @param WPML_Localization $localization
	 * @param WPML_ST_Theme_Localization_Utils $utils
	 * @param string $template_path
	 */
	public function __construct(
		WPML_Localization $localization,
		WPML_ST_Theme_Localization_Utils $utils,
		$template_path ) {

		$this->localization = $localization;
		$this->utils = $utils;
		$this->template_path = $template_path;
	}

	/** @return array */
	public function get_model() {

		$model = array(
			'section_label'      => __( 'Strings in the themes', 'wpml-string-translation' ),
			'scan_button_label'  => __( 'Scan selected themes for strings', 'wpml-string-translation' ),
			'completed_title'    => __( 'Completely translated strings', 'wpml-string-translation' ),
			'needs_update_title' => __( 'Strings in need of translation', 'wpml-string-translation' ),
			'component'          => __( 'Theme', 'wpml-string-translation' ),
			'domain'             => __( 'Textdomain', 'wpml-string-translation' ),
			'all_text'           => __( 'All', 'wpml-string-translation' ),
			'active_text'        => __( 'Active', 'wpml-string-translation' ),
			'inactive_text'      => __( 'Inactive', 'wpml-string-translation' ),
			'type'               => 'theme',
			'components'         => $this->get_components(),
			'stats_id'           => 'wpml_theme_scan_stats',
			'scan_button_id'     => 'wpml_theme_localization_scan',
			'section_class'      => 'wpml_theme_localization',
			'nonces'             => array(
				'scan_folder' => array(
					'action' => WPML_ST_Theme_Plugin_Scan_Dir_Ajax_Factory::AJAX_ACTION,
					'nonce'  => wp_create_nonce( WPML_ST_Theme_Plugin_Scan_Dir_Ajax_Factory::AJAX_ACTION ),
				),
				'scan_files'  => array(
					'action' => WPML_ST_Theme_Plugin_Scan_Files_Ajax_Factory::AJAX_ACTION,
					'nonce'  => wp_create_nonce( WPML_ST_Theme_Plugin_Scan_Files_Ajax_Factory::AJAX_ACTION ),
				),
				'update_hash' => array(
					'action' => WPML_ST_Update_File_Hash_Ajax_Factory::AJAX_ACTION,
					'nonce'  => wp_create_nonce( WPML_ST_Update_File_Hash_Ajax_Factory::AJAX_ACTION ),
				),
			),
			'status_count'       => array(
				'active'   => 1,
				'inactive' => count( $this->utils->get_theme_data() ) - 1,
			),
		);

		return $model;
	}

	/** @return array */
	private function get_components() {
		$components = array();
		$theme_localization_status = $this->utils->get_theme_localization_stats( $this->localization );
		$base_st_url = admin_url( 'admin.php?page=' . WPML_ST_FOLDER . '/menu/string-translation.php' );

		foreach ( $this->utils->get_theme_data() as $theme_folder => $theme_data ) {
			$components[ $theme_folder ] = array(
				'domains' => array(
					$theme_data['TextDomain'] => array(
						'translated'   => array_key_exists( $theme_data['TextDomain'], $theme_localization_status ) ?
							$theme_localization_status[ $theme_data['TextDomain'] ]['complete'] :
							0,
						'needs_update' => array_key_exists( $theme_data['TextDomain'], $theme_localization_status ) ?
							$theme_localization_status[ $theme_data['TextDomain'] ]['incomplete'] :
							0,
						'needs_update_link' => add_query_arg( array( 'context' => $theme_data['TextDomain'], 'status' => ICL_STRING_TRANSLATION_NOT_TRANSLATED ), $base_st_url ),
						'translated_link' => add_query_arg( array( 'context' => $theme_data['TextDomain'], 'status' => ICL_STRING_TRANSLATION_COMPLETE ), $base_st_url ),
						'domain_link' => add_query_arg( array( 'context' => $theme_data['TextDomain'] ), $base_st_url ),
						'title_needs_translation' => sprintf( __( 'Translate strings in %s', 'wpml-string-translation' ), $theme_data['TextDomain'] ),
						'title_all_strings' => sprintf( __( 'All strings in %s', 'wpml-string-translation' ), $theme_data['TextDomain'] ),
					),
				),
				'file'            => 'style.css',
				'component_name'  => $theme_data['name'],
				'active' => wp_get_theme()->get( 'Name' ) === $theme_data['name'],
				'requires_rescan' => $this->localization->does_theme_require_rescan(),
			);
		}

		return $components;
	}

	/** @return string */
	public function get_template() {
		return 'theme-plugin-localization-ui.twig';
	}
}