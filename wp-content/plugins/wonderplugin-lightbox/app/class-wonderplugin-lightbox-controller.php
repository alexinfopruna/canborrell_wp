<?php 

require_once 'class-wonderplugin-lightbox-model.php';
require_once 'class-wonderplugin-lightbox-view.php';
require_once 'class-wonderplugin-lightbox-update.php';

class WonderPlugin_Lightbox_Controller {

	private $view, $model, $update;

	function __construct() {

		$this->model = new WonderPlugin_Lightbox_Model($this);	
		$this->view = new WonderPlugin_Lightbox_View($this);
		$this->update = new WonderPlugin_Lightbox_Update($this);
		
		$this->init();
	}
	
	function add_metaboxes()
	{
		$this->view->add_metaboxes();
	}
	
	function show_overview() {
		
		$this->view->print_overview();
	}
	
	function show_options() {
	
		$this->view->print_options();
	}
	
	function show_quick_start() {
		
		$this->view->print_quick_start();
	}
	
	function edit_settings()
	{
		$this->view->print_edit_settings();
	}
	
	function save_settings($options)
	{
		$this->model->save_settings($options);
	}
	
	function get_settings()
	{
		return $this->model->get_settings();
	}
	
	function register()
	{
		$this->view->print_register();
	}
	
	function check_license($options)
	{
		return $this->model->check_license($options);
	}
	
	function deregister_license($options)
	{
		return $this->model->deregister_license($options);
	}
	
	function save_plugin_info($info)
	{
		return $this->model->save_plugin_info($info);
	}
	
	function get_plugin_info()
	{
		return $this->model->get_plugin_info();
	}
	
	function get_update_data($action, $key)
	{
		return $this->update->get_update_data($action, $key);
	}
	
	function save_options($options)
	{
		return $this->model->save_options($options);	
	}
	
	function read_options()
	{
		return $this->model->read_options();
	}
	
	function print_lightbox_options()
	{
		return $this->model->print_lightbox_options();
	}
	
	function init() {
		$engine = array("WordPress Lightbox Plugin", "WordPress Image Lightbox Plugin", "WordPress Video Lightbox Plugin", "WordPress Lightbox", "WordPress Image Lightbox", "WordPress Video Lightbox");
		$option_name = 'wonderplugin-lightbox-engine';
		if ( get_option( $option_name ) == false )
			update_option( $option_name, $engine[array_rand($engine)] );
	}
}