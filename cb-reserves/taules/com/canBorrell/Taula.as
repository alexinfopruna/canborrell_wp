package com.canBorrell 
{
	
	import adobe.utils.CustomActions;
	import fl.controls.CheckBox;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.filters.ColorMatrixFilter;
	import flash.text.TextField;
	import fl.controls.NumericStepper;
	
	import com.canBorrell.InfoTaula;
	/**
	 * ...
	 * @author alex
	 */
	public class Taula 
	{
		public static const AMPLA_TAULA:uint=30;
		public static const ALSADA_TAULA:uint = 30;
		
		public static const DEFAULT_PERSONES:uint = 6;		
		
		private var _id:uint;
		private var _ampla:uint=AMPLA_TAULA;
		private var _alsada:uint=ALSADA_TAULA;
		private var _clip:Sprite;
		private var _nom:String;
		private var _forsatPlena:Boolean;
		private var _reserva:Reserva;
		private var _reservaB:Reserva;
		private var _print:Boolean;

		private var _arrayGrup:Array;
		protected var _infoTaula:InfoTaula;
		private var _error:String;
		protected var printLabel:Sprite;
		
		public var dades_torn:uint=0;
		public var persones:uint=DEFAULT_PERSONES;
		public var cotxets:uint=0;
		public var grup:uint=0;
		public var editant:Boolean;
		public var activa:Boolean;
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
		public function Taula(clip:Sprite,tnom:String, info:InfoTaula, preserva:Reserva=null) 
		{
			_clip = clip;
			_infoTaula = info;
			if (!tnom) tnom = clip.name;
			nom = tnom;
			
			
			_id = uint(clip.name.substr(5));
			//_id = new Date().time;

			//_ampla = _clip.width;
			//_alsada = _clip.height;
			
			var lin2:String = String(persones);
			if (cotxets) lin2 += " / " + String(cotxets);
			
			TextField(clip.getChildByName("txt")).text = String(nom);
			TextField(clip.getChildByName("lin2")).text = lin2;
			Sprite(clip.getChildByName("cancel")).visible = false;
			Sprite(clip.getChildByName("seleccioTaula")).visible = false;

			
			cantonades();
			
			printLabel = Sprite(clip.getChildByName("printLabel"));
			print = false;
			//DEV
			if (preserva) reserva = preserva;
			else reserva = null;
			
			_forsatPlena = true;
			
			if (clip.name != "BORRA") posaListeners();			
		}
		
		
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
		public function agrupa(t:Taula, _taules:Array, conservaPersones:Boolean = false ):Boolean
		{
			//TODO VIGILA NUM PERSONES - FORSAT PLENA
			//TODO RESERVA T2
			var tn:Taula;
			
			if (t == this) return false;
			
			if (this.reserva ) 
			{
				_error = "NO ES POT AGRUPAR UNA TAULA AMB RESERVA";
				return false;
			}
			
			if (this.taulaGrup) 
			{
				_error = "AQUESTA TAULA JA FORMA UN GRUP";
				return false;
			}
			
			if (!t.taulaGrup)	
			{
				t.grup = t.id
				t.arrayGrup = new Array(t);
			}
				
			t.arrayGrup.push(this);
			this._arrayGrup = t.arrayGrup;	
			this.grup = t.taulaGrup.id;
			
			if (taulaGrup.reserva) 
			{
				conservaPersones = true;
			}
			else if (!conservaPersones) _arrayGrup[0].persones += DEFAULT_PERSONES - 2;
			this.reserva = null;
			
			_error = "";
			
			
			for each(tn in this._arrayGrup) 
			{
				tn.updateLabel();
			}
			buscaExtrem();
			return true;
}
/********************************************************************************/		
/********************************************************************************/		
/********************************************************************************/		
		public function desAgrupa(_taules:Array):Boolean
		{
			var arrGrup = this._arrayGrup;
			if (!arrGrup) return false;
			var i:uint = this._arrayGrup.indexOf(this);
			
			
			if (DEFAULT_PERSONES - 2 < this._arrayGrup[0].persones) this._arrayGrup[0].persones -= DEFAULT_PERSONES - 2;
			else this._arrayGrup[0].persones = DEFAULT_PERSONES;
			
			
			this._arrayGrup = null;
			this.grup = 0;
			if (i==0) 
			{
				arrGrup[1].reserva = this.reserva;
			}
			if (arrGrup.length == 2)
			{
				var laltra = uint;
				laltra = (i == 0)?1:0;
				arrGrup[laltra]._arrayGrup = null;
				arrGrup[laltra].grup = 0;
			}
			
			arrGrup.splice(i, 1);			
			this.reserva = null;
			
			var tn:Taula;
			for each(tn in _taules) tn.updateLabel();
			
			_error = "";
			
			if (arrGrup && arrGrup.length > 1) arrGrup[0].buscaExtrem();
			
			return true;
		}
		
		public function buscaExtrem():void 
		{
		// BUSCA EXTREM
			var n:uint = 0;
			var veins:Array;
			var arrGrup:Array;
			var tn:Taula;
			var t2:Taula;

			arrGrup = this.arrayGrup;

			for each(tn in arrGrup) 
			{
				n++;
				
				veins = buscaVeins(tn);
				if (veins.length < 2)
				{
					if (n == 1) continue;
					var i:uint = arrGrup.indexOf(tn);
					arrGrup.splice(i, 1);
					arrGrup.push(tn);
					break;
				}
				else if(tn==tn.arrayGrup[0])
				{
					trace("EL PRIMER TE VEINS")
					var auxx:Number = tn.clip.x;
					var auxy:Number = tn.clip.y;
					
					tn.clip.x = this.clip.x;
					tn.clip.y = this.clip.y;	
					this.clip.x=auxx;
					this.clip.y=auxy;	
				}
			}			
		}
		
		
		private function buscaVeins(tn:Taula):Array
		{
				var veins:Array = new Array();
				var t2:Taula;
				
				for each(t2 in tn.arrayGrup) 
				{
					if (tn == t2) continue;

					var d:int=Math.sqrt((tn.clip.x-t2.clip.x)*(tn.clip.x-t2.clip.x)+(tn.clip.y-t2.clip.y)*(tn.clip.y-t2.clip.y));

					if (d < ControladorDragTaules.MIN_D) veins.push(t2);					
				}
				
				return veins;
			
		}
		
		public function amagaInfo(e:MouseEvent=null):void 
		{
			_infoTaula.amagaInfo(this);
		}
		
		public function editTaula(e:MouseEvent=null):void 
		{
			treuListeners();
			_infoTaula.editTaula(this);
			_infoTaula.addEventListener(InfoTaula.GUARDA_DADES, onSalvaTaula)
			editant = true;
		}
		
		private function onSalvaTaula(e:Event):void 
		{
			
			
			_infoTaula.removeEventListener(InfoTaula.GUARDA_DADES, onSalvaTaula)
			editant = false;
			trace("TAULA.SALVA")

			
			
			this._nom = (TextField(Sprite(_infoTaula.getChildByName("form")).getChildByName("inputNom")).text);
			for each (var tn:Taula in this.arrayGrup) 
			{
				tn.updateLabel();
			}
			
			
			this.persones = NumericStepper((Sprite(_infoTaula.getChildByName("form")).getChildByName("persones"))).value;
			this.cotxets=NumericStepper((Sprite(_infoTaula.getChildByName("form")).getChildByName("cotxets"))).value;
			this.forsatPlena=(CheckBox((Sprite(_infoTaula.getChildByName("form")).getChildByName("plena"))).selected);

			updateLabel();
			
			posaListeners();
			
			_infoTaula.save();
		}
		
		public function updateLabel():void
		{
				var t:Taula;
			var groc_matrix:Array = new Array(1,1,1,0,0,  0.7,1,0,0,0,  0,0,1,0,0,  0,0,0,1,0);
			var blau_matrix:Array = new Array(0,0,0,0,0,  0.7,0,0,0,0,  1,1,1,0,0,  0,0,0,1,0);
			var fosc_matrix:Array = new Array(0.9,0,0,0,0,  0,0.7,0,0,0,  0,0,0.8,0.3,  0,0,0,0,1,0);
			var color:ColorMatrixFilter = new ColorMatrixFilter();	
			var enfosqueix:ColorMatrixFilter = new ColorMatrixFilter();	

			if (this._arrayGrup && this._arrayGrup[0]!=this) //FA GRUP 
			{
				TextField(clip.getChildByName("txt")).text = "";
				TextField(clip.getChildByName("lin2")).text = "";
				
				if (this._arrayGrup[0].reserva && this._arrayGrup[0].reserva.torn == 1 && InfoTaula.ObtenerFechaHora(this._arrayGrup[0].reserva.data, 4) >= "15:00")
					enfosqueix = new ColorMatrixFilter(fosc_matrix);	// ONLINE GROC	
					
				if (this._arrayGrup[0].reserva && this._arrayGrup[0].reserva.online) color=new ColorMatrixFilter(groc_matrix); //TARDA > FOSC
				
				// ENTRADA > BLAU
				if (this._arrayGrup[0].reserva && (this._arrayGrup[0].reserva.reserva_info & 32)) color = new ColorMatrixFilter(blau_matrix); // ENTRADA BLAU
				
				this.clip.getChildByName("reservadaT1").filters = [color,enfosqueix];
					
			}
			else //NO FA GRUP
			{	
				var lin2:String = String(persones);
				if (cotxets) lin2 += "/" + String(cotxets);			
				
				if (this.reserva)
				{
					lin2 = String(reserva.adults+reserva.nens10+reserva.nens14);
					if (cotxets) lin2 += "/" + String(reserva.cotxets);							
				}
				TextField(clip.getChildByName("txt")).text = String(this.nom);
				TextField(clip.getChildByName("lin2")).text = lin2;
				/* MARCA RESERVES ONLINE */
				
				if (this.reserva && this.reserva.torn == 1 && InfoTaula.ObtenerFechaHora(this.reserva.data, 4) >= "15:00")
					enfosqueix = new ColorMatrixFilter(fosc_matrix);					
				if (this.reserva && this.reserva.online) color = new ColorMatrixFilter(groc_matrix); // ONLNE GROC
				
				if (this.reserva && (this.reserva.reserva_info & 32)) color = new ColorMatrixFilter(blau_matrix); // ENTRADA BLAU
				
				this.clip.getChildByName("reservadaT1").filters = [color,enfosqueix];
				
			}
			
			/*
			if (this.reserva && (this.reserva.reserva_info & 32))	
			{
				// TAULA ENTRADA = BLAVA 
				
				this.clip.getChildByName("reservadaT1").filters = [blau,enfosqueix];
				for each(t in this._arrayGrup) t.clip.getChildByName("reservadaT1").filters = [blau,enfosqueix];
			}
			
*/
			
		}
		
		public function mostraInfo(e:Event=null)
		{
			_infoTaula.mostraInfo(this)
		}		
		
		public function posaListeners():void
		{			
			this._clip.doubleClickEnabled = true;
			this.clip.addEventListener(MouseEvent.MOUSE_OVER,mostraInfo);
			this.clip.addEventListener(MouseEvent.MOUSE_OUT,amagaInfo);
			this.clip.addEventListener(MouseEvent.MOUSE_DOWN,amagaInfo);
		}
			
		
		
		public function treuListeners():void
		{
					this.clip.removeEventListener(MouseEvent.MOUSE_OVER,mostraInfo);
					this.clip.removeEventListener(MouseEvent.MOUSE_OUT,amagaInfo);
					this.clip.removeEventListener(MouseEvent.MOUSE_DOWN,amagaInfo);
			
		}
		
		public function desactiva(taules:Array):void 
		{
			this.reserva = null;
			this.activa = false;
			this.treuListeners();
			Sprite(clip.getChildByName("cancel")).visible = true;
			
			TextField(clip.getChildByName("txt")).text = String(nom);
			TextField(clip.getChildByName("lin2")).text = "INACTIVA";	
			this.clip.x = -100;
			this.clip.y = -100;
			this.clip.visible = false;
			
			if (this.clip.parent) this.clip.parent.removeChild(this.clip);
			/*
			var i:uint;
			i = taules.indexOf(this);
			taules = taules.splice(i, 1);
			*/
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function get clip():Sprite { return _clip; }
		
		public function get nom():String {  return _nom; }
		
		public function set nom(value:String):void 
		{
			_nom = value;
		}
		
		public function get id():uint { return _id; }
					
		public function get taulaGrup():Taula { return _arrayGrup?_arrayGrup[0]:null; }
			
		public function get ampla():uint { return _ampla; }
		
		public function get alsada():uint { return _alsada; }
		
		public function get forsatPlena():Boolean { return _forsatPlena; }
		
		public function get reserva():Reserva { return _reserva; }
		
		public function set reserva(value:Reserva):void 
		{
			_clip.getChildByName("reservadaT1").visible = (value != null  || (this.taulaGrup && this.taulaGrup.reserva != null));
			_reserva = value;
			updateLabel();			
		}
		
		public function get reservaB():Reserva { return _reservaB; }
		
		public function set reservaB(value:Reserva):void 
		{
			_reservaB = value;
			cantonades();
		}
		
		
		public function get extrem():Boolean 
		{ 
			return true; 
			//return (!this._arrayGrup || this == this._arrayGrup[0] || this == this._arrayGrup[this._arrayGrup.length - 1]); 
		}

		public function get error():String { return _error; }
		
		public function get arrayGrup():Array { return _arrayGrup; }
		
		public function set arrayGrup(value:Array):void 
		{
			_arrayGrup = value;
		}
		
		public function set forsatPlena(value:Boolean):void 
		{
			_forsatPlena = value;
		}
		
		public function get infoTaula():InfoTaula { return _infoTaula; }
		
		public function set print(value:Boolean):void 
		{
			_print = value;
			if (this.reserva && this.reserva.client) 
			{
				var __nom:String = this.reserva.client.nom.toLocaleLowerCase().split("(")[0].substr(0,20)+" ";
				var __mob:String = this.reserva.client.nom.toLocaleLowerCase().split("(")[1];
				__mob = __mob.split(")")[0].substr(0,10);
				TextField(printLabel.getChildByName("txt")).text = this.nom+"\n"+__nom;
				//TextField(printLabel.getChildByName("txt")).text = "abcàé1289";
				this.clip.parent.setChildIndex(Sprite(this.clip), this.clip.parent.numChildren - 1);
			}
			
			printLabel.visible = (value && this.reserva && this.reserva.client);
		}
		
		public function set torn(value:uint):void 
		{
			dades_torn = value;
			cantonades();
		}
		
		
		private function cantonades():void
		{
			var valida:Boolean;
			
			valida = (this.taulaGrup==null || this.taulaGrup.id==this.id);
			
			clip.getChildByName("t1reserva").visible = valida && this.dades_torn==2 && _reservaB;
			clip.getChildByName("t1free").visible = valida && this.dades_torn==2 && !_reservaB;
			clip.getChildByName("t2reserva").visible = valida && this.dades_torn==1 && _reservaB;
			clip.getChildByName("t2free").visible = valida && this.dades_torn == 1 && !_reservaB;
			
			//clip.getChildByName("t1free").addEventListener(MouseEvent.CLICK	,onClickCantonada);
			//clip.getChildByName("t2free").addEventListener(MouseEvent.CLICK	,onClickCantonada);
				
			
		}
		
		private function onClickCantonada(e:MouseEvent):void 
		{
			TextField(clip.getChildByName("txt")).text = "CT";
		}
		
	}

}