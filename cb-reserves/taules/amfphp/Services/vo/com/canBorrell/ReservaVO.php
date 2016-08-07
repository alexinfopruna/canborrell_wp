<?php
class ReservaVO
{
	var $id;
	var $adults;
	var $nens4_9;
	var $nens10_14;
	var $cotxets;
	var $data;
	var $hora;
	var $observacions;
	var $online;
	
    var $_explicitType = "com.canBorrell.ReservaVO";
	
/**/	
	function ReservaVO($id,$adults,$nens4_9,$nens10_14,$cotxets,$data,$hora,$torn,$observacions,$online)
	{
		$this->id=$id;
		$this->adults=$adults;
		$this->nens4_9=$nens4_9;
		$this->nens10_14=$nens10_14;
		$this->cotxets=$cotxets;
		$this->data=$data;
		$this->hora=$hora;
		$this->torn=$torn;
		$this->observacions = $observacions;
		$this->online = $online & 1?true:false;
;
	}	
}
?>