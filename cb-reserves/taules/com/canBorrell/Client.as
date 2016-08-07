package com.canBorrell 
{
	/**
	 * ...
	 * @author alex
	 */
	public class Client
	{
		public var id:uint;
		public var nom:String;
		public var cognom:String;
		public var email:String;
		public var adresa:String;
		public var tel1:String;
		public var mov1:String;
		public var conflictes:String;
		
		
		public function Client(pnom:String,pcognom:String) 
		{
			nom = pnom;
			cognom = pcognom;
			email = "";
			adresa=""
			tel1 = ""
			mov1 = "";
			conflictes=""
		}
		
	}

}