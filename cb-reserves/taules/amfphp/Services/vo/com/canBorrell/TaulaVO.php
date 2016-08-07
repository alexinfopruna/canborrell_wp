<?php
class TaulaVO
{
	var $id;
	var $nom;
	var $persones;
	var $cotxets;
	var $reserva;
	var $grup;
	var $x;
	var $y;
	var $dades_adults;
	var $dades_nens4_9;
	var $dades_nens10_14;
	var $dades_cotxets;
	var $dades_data;
	var $dades_hora;
	var $dades_torn;
	var $dades_client;
	var $plena;
	var $observacions;
	var $online;
	var $reserva_info;
	
    var $_explicitType = "com.canBorrell.TaulaVO";
	
/**/	
	function TaulaVO($id,$nom,$persones,$cotxets,$grup,$x,$y,$reserva,$dades_adults,$dades_nens4_9,$dades_nens10_14,$dades_cotxets,$dades_data,$dades_hora,$dades_client,$plena,$dades_torn,$observacions,$online,$reserva_info)
	{
		$this->id=$id;
		$this->nom=(empty($nom)?$id:$nom);
		$this->persones=$persones;
		$this->cotxets=$cotxets;
		$this->grup=$grup;
		$this->x=$x;
		$this->y=$y;
		$this->reserva = $reserva;
		
		$this->dades_adults=$dades_adults;
		$this->dades_nens4_9=$dades_nens4_9;
		$this->dades_nens10_14=$dades_nens10_14;
		$this->dades_cotxets=$dades_cotxets;
		$this->dades_data=$dades_data;
		$this->dades_hora=$dades_hora;
		$this->dades_torn=$dades_torn;		
		$this->dades_client=$dades_client;
		$this->plena=$plena;
		$this->observacions=$observacions;		
		$this->online=$online;		
		$this->reserva_info=$reserva_info;		
	}

}
?>