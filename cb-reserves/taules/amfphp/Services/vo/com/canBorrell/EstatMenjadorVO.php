<?php
class EstatMenjadorVO
{
	var $data;
	var $torn;
	var $menjador;
	var $actiu;

    var $_explicitType = "com.canBorrell.EstatMenjadorVO";
/*	*/
	
	function EstatMenjadorVO($data,$torn,$menjador,$actiu)
	{
		$this->data=$data;
		$this->torn=$torn;
		$this->menjador = $menjador;
		$this->actiu = $actiu;
	}

}

?>