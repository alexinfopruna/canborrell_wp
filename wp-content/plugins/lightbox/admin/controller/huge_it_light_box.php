<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once(HUGEIT_PLUGIN_DIR."/admin/model/huge_it_light_box.php");
class Controller {
	public $model;
	public function __construct()  
    {  
        $this->model = new Model();
    } 
	public function invoke()
	{
			$lightboxlist = $this->model->getlightboxList();
			if(isset($_GET['hugeit_task'])){
				if($_GET['hugeit_task'] == 'save'){
					$lightboxlist = $this->model->getlightboxSave();
				}
			}
			include_once(HUGEIT_PLUGIN_DIR."/admin/view/huge_it_light_box.php");
	}
}
?>