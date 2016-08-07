package com.canBorrell 
{
	import fl.controls.CheckBox;
	import fl.controls.NumericStepper;
	import flash.display.MovieClip;
	import flash.display.SimpleButton;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	import caurina.transitions.Tweener;
	/**
	 * ...
	 * @author alex
	 */
	public class InfoTaula extends Sprite
	{
		static public const SALVA_DADES:String = "salvaDades";
		static public const AMPLADA_POSICIONA:uint = 375;
		static public const ALSADA_POSICIONA:uint = 450;
		static public const GUARDA_DADES:String = "guardaDades";
		static public const SAVE:String = "save";
		
		var _taula:Taula;
		
		public function InfoTaula() 
		{
			this.visible = false;
			this.x = Taula.AMPLA_TAULA;
			this.y = Taula.ALSADA_TAULA;	
			
			this.getChildByName("form").visible = false;
		}
		
		
		private function posiciona(t:Taula,posicio:uint=0) //0-br / 100-tr / 1-bl / 101-tl
		{
			_taula = t;
			
			var mida:Sprite;
			var fletxa:Sprite;
			var extrax:uint;
			var extray:uint;
			
			if ((t.reserva || (t.taulaGrup && t.taulaGrup.reserva)) && (this.getChildByName("form").visible==false)) 
			{
				
				mida = this; 
			
			}
			else
			{
				mida = Sprite(this.getChildByName("fonsInfo"));
				extrax= 13;
				extray = 30;
			}
			
			Sprite(this.getChildByName("fletxaTL")).visible=false;
			Sprite(this.getChildByName("fletxaTR")).visible=false;
			Sprite(this.getChildByName("fletxaBL")).visible=false;
			Sprite(this.getChildByName("fletxaBR")).visible = false;
			Sprite(this.getChildByName("fletxaTRpk")).visible=false;
			Sprite(this.getChildByName("fletxaBLpk")).visible=false;
			Sprite(this.getChildByName("fletxaBRpk")).visible=false;
			
			
			
			switch(posicio)
			{
				case 0:
					this.x =  t.ampla;
					this.y =  t.alsada;
					
					Sprite(this.getChildByName("fletxaTL")).visible=true;
				break;
				case 1:
					this.x =  -mida.width-extrax;
					this.y =  t.alsada;
					
					if (mida==this) Sprite(this.getChildByName("fletxaTR")).visible=true;
					else Sprite(this.getChildByName("fletxaTRpk")).visible=true;
					
				break;
				case 100:
				//PROVISIONAL
					this.x =  t.ampla;
					this.y =  -mida.height-extray;
					if (mida==this) Sprite(this.getChildByName("fletxaBL")).visible=true;
					else Sprite(this.getChildByName("fletxaBLpk")).visible=true;
				break;
				case 101:
					this.x =  -mida.width-extrax;
					this.y =  -mida.height-extray;
					if (mida==this) Sprite(this.getChildByName("fletxaBR")).visible=true;
					else Sprite(this.getChildByName("fletxaBRpk")).visible=true;
				break;
			}
		}
		
		
		
		
		
		public function mostraInfo(t:Taula):void 
		{
			if (this.getChildByName("form").visible == true) return;
			
			if (t.taulaGrup && t.taulaGrup!=t)
			{
				t.taulaGrup.mostraInfo();
				return;
			}
			
			var infoText:String = "";
			var omenys:String="";
			if (t.forsatPlena) omenys = " (PLE)";
			
			if (t.id)
			{
				infoText += "<b><font color='#444444' size='14'>TAULA: </font>" + t.nom +"</b>\n";
				infoText +="<em> <font color='#444444' size='10'>(id:"+t.id+")</font></em>\n";
				infoText += "<font color='#444444' size='10'>Persones: </font><b>"+t.persones +omenys+"</b>\n";
				infoText += "<font color='#444444' size='10'>Cotxets: </font><b>" + t.cotxets +"</b>\n";
			}
			if (t.reserva) 
			{
				this.getChildByName("fonsInfoGran").visible = true	
				this.getChildByName("fonsInfo").visible = false	
				var reserva:String;
				var extra_cotxets:String="";
				
				if ((t.reserva.reserva_info & 12)==12) extra_cotxets = "Doble llarg";
				else if (t.reserva.reserva_info & 8) extra_cotxets=" Doble ample";				
				if (t.reserva.reserva_info & 128) extra_cotxets += " / Cadira de rodes";
				if (t.reserva.reserva_info & 256) extra_cotxets += " / Movilitat reduïda";
				
				reserva="\n<b><font color='#444444' size='14'>RESERVA: </font>"+t.reserva.id+"</b>\n"
				reserva += "<b>" + ObtenerFechaHora(t.reserva.data,0) +"  >  "+ObtenerFechaHora(t.reserva.data,4)+"</b>  (torn "+(t.reserva.torn)+")\n";
				reserva += "<font color='#444444' size='10'>Adults: </font><b>" + t.reserva.adults +"</b> \n";
				reserva += "<font color='#444444' size='10'>Nens (-10): </font><b>" + t.reserva.nens10 +"</b> \n";
				reserva += "<font color='#444444' size='10'>Nens (10-14): </font><b>" + t.reserva.nens14 +"</b> \n";
				reserva += "<font color='#444444' size='10'>Cotxets: </font> <b>" + t.reserva.cotxets +" "+extra_cotxets+"</b>\n";
				if (t.reserva.observacions && t.reserva.observacions != "null")
				{
					var online:String = t.reserva.online?" (Online)":"";
					reserva += "<font color='#444444' size='10'>Observacions: </font> <b>" + t.reserva.observacions + online + "</b>\n";
				}
				reserva += "\n<b><font color='#444444' size='14'>CLIENT: </font> \n" +t.reserva.client.nom +"</b>\n";
				reserva += t.reserva.client.adresa+"\n";	
				reserva += "<b>"+t.reserva.client.mov1+"\n";	
				reserva += t.reserva.client.tel1+"</b>\n";	
				reserva += t.reserva.client.adresa+"\n";	
				reserva += '<b><a href="mailto:' + t.reserva.client.email + '">' + t.reserva.client.email + "</a></b>";	
				
				if (t.reserva.client.conflictes) reserva += '\n<font color="#FF0000">'+t.reserva.client.conflictes+"</font>\n";	
				
				/*infoText += "<b>"+t.nom +"</b>\n";*/
				infoText += reserva;
				TextField(this.getChildByName("txt")).height = 325;
			}
			else
			{
				this.getChildByName("fonsInfoGran").visible = false	
				this.getChildByName("fonsInfo").visible = true	
				TextField(this.getChildByName("txt")).height = 100;
			}
			
			if (t.taulaGrup) infoText += "Grup: "+t.taulaGrup.nom +"\n";
			
			TextField(this.getChildByName("txt")).htmlText = infoText;
			
			if (!this.visible) t.clip.addChild(this);
			this.visible = true;
			
			//FX

			try{t.clip.parent.swapChildren(t.clip,t.clip.parent.getChildAt(t.clip.parent.numChildren-1))}catch(e:Error){trace("ERR")}
			TextField(this.getChildByName("txt")).visible = false;
			this.getChildByName("form").visible = false;
			if (this.parent) this.parent.setChildIndex(this, parent.numChildren - 1);
			this.alpha = 0;
			Tweener.addTween(this, { alpha:1,  delay:0.5, time:0.4, onComplete:function() { this.getChildByName("txt").visible = true } } );			
			
			var pos:uint=0;
			if (t.clip.y > AMPLADA_POSICIONA) pos += 100;
			if (t.clip.x > ALSADA_POSICIONA) pos += 1; 
			
			posiciona(t,pos);
			
		}
		
		public function editTaula(t:Taula):void 
		{
			if (this.getChildByName("form").visible == true) return;
						
			this.getChildByName("fonsInfoGran").visible = false;
			this.getChildByName("fonsInfo").visible = true;	
			
			//t.treuListeners();
			trace("infoTaula EDITTAULA ", t.nom)
			/*
			if (t.taulaGrup && t.taulaGrup!=t)
			{
				t.taulaGrup.editTaula();
				return;
			}
			*/
			
			posiciona(t);
			var infoText:String = "";
			
			infoText += "Taula: " +"\n";
			infoText += "Persones: \n\n\nCotxets:"
			TextField(this.getChildByName("txt")).text = infoText;
			
			//TextField(Sprite(this.getChildByName("form")).getChildByName("inputNom")).text = String(t.id);
			TextField(Sprite(this.getChildByName("form")).getChildByName("inputNom")).text = String(t.nom);
			
			if (!this.visible) t.clip.addChild(this);
			this.visible = true;
			TextField(this.getChildByName("txt")).visible = false;
			
			NumericStepper((Sprite(this.getChildByName("form")).getChildByName("persones"))).value=t.persones;
			NumericStepper((Sprite(this.getChildByName("form")).getChildByName("cotxets"))).value = t.cotxets;
			
			CheckBox(Sprite(this.getChildByName("form")).getChildByName("plena")).selected=t.forsatPlena;
			
			//FX
			t.clip.parent.swapChildren(t.clip, t.clip.parent.getChildAt(t.clip.parent.numChildren - 1))
			this.getChildByName("form").visible = true;
			this.getChildByName("txt").visible = true;
			
			SimpleButton(Sprite(this.getChildByName("form")).getChildByName("btSave")).addEventListener(MouseEvent.CLICK, guardaDades);
			
			var pos:uint=0;
			if (t.clip.y > AMPLADA_POSICIONA) pos += 100;
			if (t.clip.x > ALSADA_POSICIONA) pos += 1; 
			
			posiciona(t,pos);
		}
		
		
		public function amagaInfo(t:Taula):void 
		{
			//if (this.getChildByName("form").visible) return;
			
			if (t.taulaGrup && t.taulaGrup!=t)
			{
				t.taulaGrup.amagaInfo();
				return;
			}
			
			if (this.visible && t.clip)	
			{
				try {t.clip.removeChild(this)}catch(e:Error){trace("InfoTaula-removechild error")};
			}
			this.visible = false;
			this.getChildByName("form").visible = false;						
			//posiciona(t);
		}
		
		public function save()
		{
			dispatchEvent(new Event(InfoTaula.SALVA_DADES))				
		}
		
		
		private function guardaDades(e:MouseEvent):void 
		{
			_taula.editant = false;
			dispatchEvent(new Event(InfoTaula.GUARDA_DADES))
			_taula.posaListeners();
			SimpleButton(Sprite(this.getChildByName("form")).getChildByName("btSave")).removeEventListener(MouseEvent.CLICK, guardaDades);
			this.amagaInfo(_taula);
		}
		
		
		public static function ObtenerFechaHora(date:Date,format:uint=0) {  //0=dd/mm/yyyy  1=yyyy-mm-dd (mysql) 2=dd/mm(base 0)/yyyy 3=dddd dd de mmmmmm de yyyyy / 4=hh:mm
			//var date:Date=new Date();
			var fechaResultado:String = new String();
			
			if (!format) return (date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear());
			if (format==1) return ( date.getFullYear()+ "-" + (date.getMonth()+1) + "-" + date.getDate());
			if (format == 4) return ( date.getHours() + ":" + String(date.getMinutes()+100).substr(1,2));
			//if (format==2) return (date.getDate() + "/" + (date.getMonth()) + "/" + date.getFullYear());

			
			var dias:Array=new Array('Diumenge','Dilluns','Dimarts','Dimecres',
			'Dijous','Divendres','Dissabte');
			fechaResultado=dias[date.getDay()]+" ";
			fechaResultado+=String(date.getDate())+" de ";
			var meses:Array=new Array('Gener','Febrer','Març','Abril','Maig','Juny',
			'Juliol','Agost','Setembre','Octubre','Novembre',
			'Desembre');
			fechaResultado+=meses[date.getMonth()]+" de "+date.getFullYear();
			fechaResultado+=" a las "+date.getHours()+":";
			var minutos:String = String(date.getMinutes());
			if (minutos.length == 1) { 
			minutos="0"+minutos;
			}
			fechaResultado += minutos;
			
			
			return fechaResultado;
		}		
		
		
	}

}