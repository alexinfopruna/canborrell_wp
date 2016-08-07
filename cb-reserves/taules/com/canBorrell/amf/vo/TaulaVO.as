package com.canBorrell.amf.vo 
{
	import com.canBorrell.Taula;
	/**
	 * ...
	 * @author alex
	 */
	public class TaulaVO
	{
		public var id;
		public var nom;
		public var persones;
		public var cotxets;
		public var reserva;
		public var reservaB;
		public var grup;
		public var x:int;
		public var y:int;
		public var dades_adults;
		public var dades_nens4_9;
		public var dades_nens10_14;
		public var dades_cotxets;
		public var dades_data;
		public var dades_hora;
		public var dades_torn;
		public var dades_client;
		public var plena;
		public var observacions;
	
		public function TaulaVO(taula:Taula)
		{
			 id = taula.id;
			 nom = taula.nom;
			 persones=taula.persones;
			 cotxets=taula.cotxets;
			 reserva=taula.reserva?taula.reserva.id:0;
			 reservaB = taula.reservaB;
			 dades_torn = taula.dades_torn;
			 grup=taula.grup;
			 x=taula.clip.x;
			 y = taula.clip.y;	
			 plena = taula.forsatPlena;	
		}
	
/**/	
	}
}