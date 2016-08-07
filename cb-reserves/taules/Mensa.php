<?php 
/**
 * Envolcall de missatge entre client-servidor
 * @author Àlex
 *
 */
defined('ROOT') or define('ROOT', './');



class CBMensa
{
	public $codi_error = null;
	public $html = null;	
	public $dades = null;

	
	public function __construct($phtml_o_err,$pdades=null){
		if (is_numeric($phtml_o_err)) $this->error($phtml_o_err);
		else{
			$this->html=$phtml_o_err;
			$this->dades=$pdades;
		}
	} 	
}
?>