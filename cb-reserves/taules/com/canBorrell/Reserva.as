package com.canBorrell 
{
	/**
	 * ...
	 * @author alex
	 */
	public class Reserva
	{
		
		public var id:uint;
		public var data:Date;
		public var torn:uint;
		public var client:Client;
		public var adults:uint;
		public var nens10:uint;
		public var nens14:uint;
		public var cotxets:uint;
		public var observacions:String;
		public var online:Boolean;
		public var reserva_info:uint;
		
		public function Reserva(pid:uint,pdata:Date,ptorn:uint,pclient:Client,padults:uint,pnens10:uint=0,pnens14:uint=0,pcotxets:uint=0,pobservacions:String="",ponline:Boolean=false,preserva_info:uint=0) 
		{
			id = pid;
			data=pdata;
			torn=ptorn;
			client=pclient;
			adults=padults;
			nens10=pnens10;
			nens14=pnens14;
			cotxets=pcotxets;		
			observacions = pobservacions;		
			online = ponline;
			reserva_info = preserva_info;
		}	
	}

}