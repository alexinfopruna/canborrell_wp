<?php
class EstatTaulesVO
{
	var $data;
	var $torn;
	var $taules;
	var $extra;

    var $_explicitType = "com.canBorrell.EstatTaulesVO";
/*	*/
	
	function EstatTaulesVO($data,$torn,Array $taules,$extra=null)
	{
		$this->data=$data;
		$this->torn=$torn;
		$this->taules=$taules;
		$this->time=time();
		$this->extra=$extra;
	}

}
?>