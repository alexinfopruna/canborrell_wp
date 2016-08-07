package com.canBorrell
{
	import com.canBorrell.amf.AMFCanBorrell;
	import com.canBorrell.amf.vo.EstatMenjadorVO;
	import com.canBorrell.amf.vo.EstatTaulesVO;
	import com.canBorrell.amf.vo.UsuariVO;
	import com.canBorrell.amf.vo.TaulaVO;
	import com.canBorrell.InfoTaula;
	import com.canBorrell.ControladorDragTaules;
	import com.canBorrell.ControladorDragPermuta;
	import com.canBorrell.Safata;
	import net.infopruna.carregador.XMLLoader;
	//import com.anychart.flashPrintFix.FlashPrintFix;
	
	
	import flash.display.LoaderInfo;
	import flash.display.Stage;
	import flash.display.StageScaleMode;
	
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	import flash.events.MouseEvent;
	import flash.events.TimerEvent;
	import flash.external.ExternalInterface;
	import flash.text.TextField;
	import flash.utils.Timer;
	import flash.ui.Keyboard
	import flash.geom.Rectangle;
	import flash.events.MouseEvent;
	import flash.display.SimpleButton;
	import flash.filters.ColorMatrixFilter;	
		
	import net.infopruna.print.DisplayUtils;
	
	public class MenjadorEditor  extends MovieClip
	{
		/********************************/
		/********************************/
		private var DEBUG:Boolean = false;
		
		private var URL_BASE = ""; // MODO DEBUG
		//private static const URL_BASE = "http://localhost/www.can-borrell.com/taules/"; // MODO DEBUG
		//private static const URL_BASE = "http://www.can-borrell.com/taules/"; // MODO PRODUCCIO
		//private static const URL_BASE = "/www.can-borrell.com/taules/"; // MODO DEBUG
		/********************************/
		/********************************/
		
		//private var AMF_GATEWAY = "amfphp/gateway.php";
		private var AMF_GATEWAY = "amfphp/";
		static public const MODO_EXIT:uint = 0;
		static public const MODO_RESERVES:uint = 16;
		static public const MODO_EDICIO:uint = 64;
		
		

		
		static public const ESTAT_INICIAL:Date = new Date(2011,0,1);
		static public const ESTAT_INICIAL_MY:String = ESTAT_INICIAL.fullYear+"-"+(ESTAT_INICIAL.month+1)+"-"+ESTAT_INICIAL.date;
		static public const ESTAT_INICIAL_ES:String = ESTAT_INICIAL.date+"-"+(ESTAT_INICIAL.month+1)+"-"+ESTAT_INICIAL.fullYear;
		static public const MAX_MENJADORS:uint = 10;
		//public var XML_CONFIG:String = "config.xml?"+Math.random();
		static public const KEEP_ALIVE:uint=3600 * 5;
		
		private var _data:Date = new Date(1900,0,1);
		
		private var _modo:uint=MODO_EXIT;
		
		private var _taules:Array;
		private var _parets:Array;
		private var _controladorDragTaules:ControladorDragTaules;
		private var _controladorDragPermuta:ControladorDragPermuta;
		private var _panelInfo:InfoTaula;
		
		
		private var _widthIni:uint;
		private var _heightIni:uint;
		private var _veladura:Sprite;
		private var _error:Sprite;
		private var _loading:Sprite;
		private var _AMFCanBorrell:AMFCanBorrell;
		private var _nova:Taula;
		private var _maxTaula;
		
		private var _torn:uint;
		private var _usuari:UsuariVO;
		private var _ready:Boolean=false;
		private var _config:XML;
		private var _safata:Safata
		private var lastResponse:uint;
		private var _peticions:uint=0;
		
		
/****************************************************************************************************************/			
		public function MenjadorEditor()
		{			
			stage.scaleMode = StageScaleMode.NO_SCALE;
			
			var paramObj:Object = LoaderInfo(this.root.loaderInfo).parameters;
			DEBUG = Boolean(paramObj["DEBUG"]=='true');
			URL_BASE = String(paramObj["URL"]);
			
			/*
			*/
			if (URL_BASE == 'undefined' || URL_BASE == null) {
				URL_BASE = "http://cbdev.localhost/taules/"; // MODO DEBUG
				DEBUG = true;
			}

			AMF_GATEWAY = URL_BASE+AMF_GATEWAY;

			TextField(this.getChildByName("txtData")).text = "URL:" + URL_BASE;	
			trace("AMF_GATEWAY : "+AMF_GATEWAY+" / DEBUG : "+DEBUG);
			_AMFCanBorrell = new AMFCanBorrell(AMF_GATEWAY);
			carregaUsuari(); 								
		}
		
		public function iniMenjadorEditor(pmodo:uint)
		{
			// CARREGA TAULES I PARETS
			_torn = 1;
			if (DEBUG) _torn = 1;
			if (DEBUG) _data = new Date(2013,11,21);
			_parets = new Array();
			for (var i = 0; i < this.numChildren; i++ )
			{
				if (this.getChildAt(i).name.substring(0, 5) == "paret") 
				{
					_parets.push(this.getChildAt(i));
					
				}
			}
			_taules = new Array();
			_panelInfo = new InfoTaula();
			_panelInfo.addEventListener(InfoTaula.SALVA_DADES,salvaDades)
			
			
			
			var newTaula:Taula;
			
			/**/	
			for (i = 0; i < this.numChildren; i++ )
			{			
				var label:String = this.getChildAt(i).name.substring(0, 5) ;
				var nom:String = this.getChildAt(i).name.substring(5) ;
				if ( label=="BORRA") 
				{
					nom = "BORRA";
					newTaula = new Taula(MovieClip(this.getChildAt(i)),nom,_panelInfo);
					_taules.push(newTaula);
				}	
			}
				
			// SAFATA
			_safata = new Safata(new MCSafata(), "SAFATA" , _panelInfo);
			_safata.clip.x = 722;
			_safata.clip.y = -16;
			_safata.clip.name = "SAFATA";			
			addChild(_safata.clip);
			
			
			
			_controladorDragTaules = new ControladorDragTaules(_taules, _parets);
			_controladorDragPermuta = new ControladorDragPermuta(_taules, _parets, _safata);

			_controladorDragPermuta.addEventListener(ControladorDragPermuta.CLICK, novaReserva);
			_controladorDragPermuta.addEventListener(ControladorDragPermuta.PERMUTA, permuta);
			_controladorDragPermuta.addEventListener(ControladorDragPermuta.SAFATA, safata);
			
			this.getChildByName("txtCercador").visible = false;
			TextField(this.getChildByName("txtDebug")).visible = false;
			
						
			_veladura = Sprite(this.getChildByName("veladura"));
			_error = Sprite(this.getChildByName("error"));
			_loading = Sprite(this.getChildByName("loading"));
			
			_veladura.visible = false; veladura.alpha = 0.7;
			
			_widthIni = this.width;
			_heightIni = this.height;
			this.stage.addEventListener(Event.RESIZE, resize);
			resize();
			
			modo = pmodo;

			_error.visible = false;
			load();
			
			ExternalInterface.addCallback("canviData", onCanviData);
			//ExternalInterface.addCallback("canviTorn", onCanviTorn);
			ExternalInterface.addCallback("edbase", jsEdBase);
			ExternalInterface.addCallback("print", jsPrint);
			ExternalInterface.addCallback("seleccionaTaula", seleccionaTaula);
			ExternalInterface.addCallback("buidaSafata", buidaSafata);
			
			this.getChildByName("ADD").addEventListener(MouseEvent.CLICK, evAfegirTaula);			
			
			/*****************************************************************************************************/
			//CARREGA ESTAT			
			if (DEBUG)
			{
				trace("DEBUG: "+_data+" / "+_torn);
				//DEBUG = false;
				carregaEstat(_data, _torn);
				carregaEstatMenjador(_data, _torn);		
			}
			
			if (!_ready) ExternalInterface.call("fromAS3_flash_ready");		
			_ready = true;
			
			//SESSION KEEP ALIVE????
			var tim:Timer = new Timer(KEEP_ALIVE);
			tim.addEventListener(TimerEvent.TIMER, keepAlive);
			tim.start();
		}
		
		private function safata(e:Event):void 
		{
			trace("SAFATA " + _controladorDragPermuta.currentTaula.id + " >> " + _controladorDragPermuta.segonaTaula.id + " R: " + _controladorDragPermuta.currentTaula.reserva.id);	
			
			//_safata.id = _controladorDragPermuta.currentTaula.id;
			_safata.reserva = _controladorDragPermuta.currentTaula.reserva;
			_safata.updateLabel();
		}
		
		private function seleccionaTaula(id:uint):void
		{
			for each(var tn:Taula in _taules) 
			{
				if (tn.id == id || (tn.taulaGrup && tn.taulaGrup.id==id) || id < 1)
				{
					tn.clip.alpha = 1;
					tn.clip.getChildByName("seleccioTaula").visible=(id>0);
				}
				else
				{
					tn.clip.alpha = 0.3;
					tn.clip.getChildByName("seleccioTaula").visible=false;
				}
			}
		}
		
		private function permuta(e:Event):void 
		{			
			trace("fromAS3_permuta "+ 	_controladorDragPermuta.currentTaula.id+" >> "+_controladorDragPermuta.segonaTaula.id+" R: "+_controladorDragPermuta.currentTaula.reserva.id);	
			ExternalInterface.call("fromAS3_permuta", _controladorDragPermuta.currentTaula.id, _controladorDragPermuta.segonaTaula.id, _controladorDragPermuta.currentTaula.reserva.id);	
		}
		
		private function buidaSafata(e:Event=null):void 
		{
			if (_controladorDragPermuta.currentTaula == _safata) _safata.reserva = null;			
		}
		
		
		private function jsPrint(e:Event=null):void
		{
			trace("JS_PRINT: PETICIO REBUDA");
			trace("JS_PRINT: MOSTRA CARTELLS");
			
			for each(var tn:Taula in _taules) tn.print=true;

			trace("JS_PRINT: SALVADISPLAY...");
			DisplayUtils.salvaDisplay(this, 760, 740, URL_BASE + "guardar.php", printReady);			
			trace("JS_PRINT: AMAGA CARTELLS");
			
			for each(tn in _taules) tn.print=false;
		}
		
		private function printReady():void 
		{
			ExternalInterface.call("fromAS3_print");
		}
		
		private function jsEdBase(e:Event=null):void
		{
			modo = MODO_EDICIO;
			onEditBase(e);
			this.getChildByName("modo_normal").visible = false;
			this.getChildByName("modo_normal").x+=5000; 
		}
		
		private function onEditBase(e:Event=null):void 
		{
			onCanviData("01/01/2011");
		}
		
		
		
		private function salvaDades(e:Event):void 
		{
			var t:Taula=InfoTaula(e.currentTarget)._taula;
			salvaEstat(t);
		}
		
		private function test(e:MouseEvent):void 
		{
			onCanviData( TextField(this.getChildByName("txtCercador")).text);
		}
		
		private function onCanviData(data:String):String
		{
			resetMenjador();
			_data = new Date(data.substr(6, 4),uint(data.substr(3, 2))-1,data.substr(0, 2));
			
			carregaEstat(_data, _torn);
			carregaEstatMenjador(_data, _torn);			
			return "OK CANVI DATA"; 
		}
/****************************************************************************************************************/			
			
		private function creaGrups():void
		{
				var t2:Taula;
				var grup:uint;
				
				for each(var tn:Taula in _taules) 
				{
					if (tn.grup)
					{
						if (tn.grup != grup) 
						{
							for each(t2 in _taules) if (t2.id == tn.grup) break;
						}
						tn.agrupa(t2, _taules,true);			
						grup = tn.grup;
					}
					else if (tn.clip.x == -100)// ELIMINA
					{
						_controladorDragTaules.desactivaTaula(tn);
						tn.desactiva(_taules);	
						continue;
					}
					
					tn.torn=_torn;
				}
				
				if (t2) t2.buscaExtrem();
				
		}
		
		
		
		private function taulaAgrupada(e:Event):void 
		{
			if (Taula(e.target.segonaTaula).nom == "BORRA")
			{
				trace("ELIMINEM "+e.target.currentTaula.nom)
				var i:uint;
				i = _taules.indexOf(e.target.currentTaula);
				this.removeChild(Taula(e.target.currentTaula).clip)
				_taules.splice(i, 1);
				Taula(e.target.currentTaula).desactiva(_taules);
				salvaEstat(e.target.currentTaula);
				return;
			}
		
			if (!e.target.currentTaula.agrupa(e.target.segonaTaula,_taules))
			{
				_controladorDragTaules.cancelaAccio();
				TextField(_error.getChildByName("txtError")).htmlText = e.target.currentTaula.error;
				mostraError(e.target.currentTaula.error);
				
				return;
			}
			
			salvaEstat(e.target.currentTaula);
		}
		
		private function movimentTaula(e:Event):void 
		{
			var taulaGrup:Taula = e.target.currentTaula.taulaGrup;
			var t:Taula = e.target.currentTaula;
			
			if (taulaGrup) 
				if (!t.desAgrupa(_taules))
				{
					_controladorDragTaules.cancelaAccio();
					trace("ACCIO ILEGAL (DESAGRUPA): " + e.target.currentTaula.error)
					mostraError(e.target.currentTaula.error);
				}
				else
				{
					if(!taulaGrup.grup) salvaEstat(taulaGrup);				
				}
				salvaEstat(e.target.currentTaula);				
		}
		
		private function movimentGrup(e:Event):void 
		{		
			if (!e.target.currentTaula.arrayGrup) movimentTaula(e);
			var arr:Array = e.target.currentTaula.arrayGrup;
			
			for each (var tn in arr) salvaEstat(tn);					
		}
		
		public function get taules():Array { return _taules; }
		
		public function get parets():Array { return _parets; }
		
		public function get modo():uint { return _modo; }
		
		public function set modo(value:uint):void 
		{
			_modo = value;
			var tn:Taula;
		
			if (_modo == MODO_EXIT)
			{
				trace("MODO_EXIT")
				for each(tn in _taules)  
				{
					//tn.clip.removeEventListener(MouseEvent.CLICK, novaReserva);
					tn.treuListeners();
				}

				
				this.getChildByName("modo_normal").removeEventListener(MouseEvent.CLICK,modoReserves)
				this.getChildByName("modo_edicio").removeEventListener(MouseEvent.CLICK,modoEdicio)
				this.getChildByName("editBase").removeEventListener(MouseEvent.CLICK,onEditBase)
				
				
				_controladorDragPermuta.desActiva();
				_controladorDragTaules.desActiva();
				_controladorDragTaules.removeEventListener(ControladorDragTaules.MOVIMENT_TAULA, movimentTaula);
				_controladorDragTaules.removeEventListener(ControladorDragTaules.TAULA_AGRUPADA, taulaAgrupada);
				this.getChildByName("modo_edicio").visible = false;
				this.getChildByName("modo_normal").visible = false;				
				this.getChildByName("editBase").visible = false;				
				this.getChildByName("ADD").visible = false;
				this.getChildByName("BORRA").visible = false;
				
				for (i = 1; i <= MAX_MENJADORS; i++ )
				{
					Sprite(this.getChildByName("bloq" + i)).visible = true;
					this.getChildByName("candau" + i).visible = false;
				}	
				
				mostraError("USUARI SENSE PERMISOS");
				
			}			
			else if (_modo == MODO_EDICIO)
			{
				
				trace("MODO_EDICIO")
				//for each(tn in _taules)  tn.clip.removeEventListener(MouseEvent.CLICK, novaReserva);


				this.getChildByName("modo_normal").addEventListener(MouseEvent.CLICK,modoReserves)
				this.getChildByName("modo_edicio").removeEventListener(MouseEvent.CLICK,modoEdicio)
				this.getChildByName("editBase").addEventListener(MouseEvent.CLICK,onEditBase)
				
				_controladorDragPermuta.desActiva();
				_controladorDragTaules.desActiva();
				_controladorDragTaules.activa();
				_controladorDragTaules.addEventListener(ControladorDragTaules.MOVIMENT_TAULA, movimentTaula);
				_controladorDragTaules.addEventListener(ControladorDragTaules.MOVIMENT_GRUP, movimentGrup);
				_controladorDragTaules.addEventListener(ControladorDragTaules.TAULA_AGRUPADA, taulaAgrupada);
				
				this.getChildByName("modo_edicio").visible = false;
				this.getChildByName("modo_normal").visible = (_data!=ESTAT_INICIAL);
				this.getChildByName("BORRA").visible = true;
				this.getChildByName("ADD").visible = true;
				
				for (var i:uint = 1; i <= MAX_MENJADORS; i++ )
				{
					SimpleButton(this.getChildByName("candau" + i)).visible = true;
					SimpleButton(this.getChildByName("candau" + i)).addEventListener(MouseEvent.CLICK,onCandau)
				}	
			}
			else if (_modo == MODO_RESERVES)
			{
				trace("MODO_RESERVES")
				this.getChildByName("modo_normal").removeEventListener(MouseEvent.CLICK,modoReserves)
				this.getChildByName("modo_edicio").removeEventListener(MouseEvent.CLICK,modoEdicio)
				this.getChildByName("editBase").removeEventListener(MouseEvent.CLICK,onEditBase)
				
				_controladorDragPermuta.desActiva();
				_controladorDragPermuta.activa(_usuari.perm > MODO_EDICIO);
				_controladorDragTaules.desActiva();
				_controladorDragTaules.removeEventListener(ControladorDragTaules.MOVIMENT_TAULA, movimentTaula);
				_controladorDragTaules.removeEventListener(ControladorDragTaules.TAULA_AGRUPADA, taulaAgrupada);
				
				/*
				for each(tn in _taules) 
				{
					tn.clip.addEventListener(MouseEvent.CLICK, novaReserva);
				}
				*/
				
				if (_usuari.perm > MODO_EDICIO)
				{
					this.getChildByName("modo_edicio").removeEventListener(MouseEvent.CLICK,modoEdicio)
					this.getChildByName("modo_edicio").addEventListener(MouseEvent.CLICK,modoEdicio)
					this.getChildByName("modo_edicio").visible = true;	
				}
				else
				{
					this.getChildByName("modo_edicio").removeEventListener(MouseEvent.CLICK,modoEdicio)
					this.getChildByName("modo_edicio").visible = false;		
				}
				this.getChildByName("modo_normal").visible = false;				
				this.getChildByName("ADD").visible = false;
				this.getChildByName("BORRA").visible = false;
				this.getChildByName("editBase").visible = false;
				
				for (i = 1; i <= MAX_MENJADORS; i++ )
				{
					this.getChildByName("candau" + i).visible = false;
				}	
				
			}
			this.getChildByName("capsalera_edicio").visible = (_modo == MODO_EDICIO);
		}
		
		private function evAfegirTaula(e:MouseEvent):void 
		{
			afegirTaula();
		}
		private function afegirTaula(n:uint=0):Taula 
		{
			var nom:String;
			var m:uint;
			var MC:MovieClip = new Taula6p();
			this.addChild(MC);
			MC.x = 405;
			MC.y = 618;
			
			m = n;
			if (n==0)
			{
				var n:uint=1;
				var nothing:uint=0;
				while (!numeroLliure(++n)) nothing++;				
				m = new Date().time / 1000;
			}
			
			if (_data.time == ESTAT_INICIAL.time) 
			{
				nom = "B" + n;
			}
			else
			{ 
				nom = "N" + n;
			}

			MC.name = "taula" + m;
			

			var newTaula:Taula;
			newTaula = new Taula(MovieClip(MC), String(nom) ,_panelInfo);
			
			_taules.push(newTaula);
			
			if (_modo == MODO_EDICIO)
			{
				_controladorDragPermuta.desActiva();
				_controladorDragTaules.desActiva();
				_controladorDragTaules.activa();
			}
			else
			{
				newTaula.posaListeners();
			}
			
			return newTaula;
		}
		
		
		private function numeroLliure(n:int):Boolean
		{
			var m:uint;
			for each(var tn:Taula in _taules) 
			{
				m=uint(tn.nom.substr(1));
				//m=uint(tn.nom);
				if (m == n) return false;			
			}
			
			return true;
		}
		
		private function modoReserves(e:Event):void 
		{
			modo = MODO_RESERVES;
		}
		
		private function modoEdicio(e:Event):void 
		{
			modo = MODO_EDICIO
		}
		
		private function onCandau(e:MouseEvent):void 
		{
			var n:String = SimpleButton(e.target).name.substr(6, 5);
			Sprite(this.getChildByName("bloq" + n)).visible = !Sprite(this.getChildByName("bloq" + n)).visible;
			this.setChildIndex(Sprite(this.getChildByName('bloq' + n)), this.numChildren - 1);

			guardaEstatMenjador(uint(n), getChildByName("bloq" + n).visible);
			
			ordenaCapes(n);
		}
		
		
		private function novaReserva(e:MouseEvent=null):void 
		{
			if (e) for each(var tn:Taula in _taules) if (tn.clip == e.currentTarget) break;
			else tn = _controladorDragPermuta.currentTaula;
			
			
			if (tn.arrayGrup) tn = tn.arrayGrup[0];
			
			if (tn.reserva)
			{
				trace("EDIT RESERVA"+tn.reserva.id);
				ExternalInterface.call("fromAS3_editReserva",tn.reserva.id,tn.nom,tn.persones,tn.cotxets,tn.forsatPlena);	
			}
			else if (tn.taulaGrup && tn.taulaGrup.reserva && tn.taulaGrup.reserva.id)  
			{
				
				trace("EDIT GRUP "+tn.taulaGrup.reserva.id);
				ExternalInterface.call("fromAS3_editReserva",tn.taulaGrup.reserva.id,tn.taulaGrup.taulaGrup.nom,tn.taulaGrup.persones,tn.taulaGrup.cotxets,tn.taulaGrup.forsatPlena);	
				
			}
			else 
			{
				
				trace("NOVA "+tn.id+" / "+tn.persones);
				ExternalInterface.call("fromAS3_novaReserva",tn.id,tn.nom,tn.persones,tn.cotxets,tn.forsatPlena);	
			}//mostraError("NOVA RESERVAAAAA");
		}
		

		private function mostraError(txt:String)
		{			
					load(false);
					TextField(_error.getChildByName("txtError")).htmlText = txt;
					_error.visible = true;
					_veladura.visible = true;
					this.setChildIndex(_veladura, this.numChildren - 1);
					this.setChildIndex(_error, this.numChildren - 1);
					
					_error.getChildByName("btTanca").addEventListener(MouseEvent.CLICK, tancaError);
			}
			
			private function tancaError(e:MouseEvent):void 
			{
				_error.getChildByName("btTanca").removeEventListener(MouseEvent.CLICK, tancaError);
				_error.visible = false;
				_veladura.visible = false;
			}
		private function resize(e:Event=null):void 
		{
			var rw = this.stage.stageWidth - _widthIni;
			var rh = this.stage.stageHeight - _heightIni;
			
			_veladura.width = this.stage.stageWidth;
			_veladura.height = this.stage.stageHeight;
			_veladura.x = 0;
			_veladura.y = 0;
			
			
		}
		
		public static function ObtenerFecha(date) {
			var fechaResultado:String=new String();
			var dias:Array=new Array('Diumenge','Dilluns','Dimarts','Dimecres',
			'Dijous','Divendres','Dissabte');
			fechaResultado=dias[date.getDay()]+" ";
			fechaResultado+=String(date.getDate())+" de ";
			var meses:Array=new Array('Gener','Febrer','Març','Abril','Maig','Juny',
			'Juliol','Agost','Setembre','Octubre','Novembre',
			'Desembre');
			fechaResultado+=meses[date.getMonth()]+" de "+date.getFullYear();
			return fechaResultado;
		}
		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
		private function carregaUsuari():void
		{
				_AMFCanBorrell.respostaListeners(respostaRecuperaUsuari);
				_AMFCanBorrell.recuperaUsuari();							
		}
		
		private function respostaRecuperaUsuari(usuari:UsuariVO)
		{
			_usuari = usuari;
			
			if (DEBUG) _usuari.perm = 255;
			trace("RESPOSTA CARREGA USR: " + _usuari.nom + " / " + _usuari.perm)
			
			if (_usuari.perm < MODO_RESERVES)
			{
				_modo=MODO_EXIT;
			}			
			else if (_usuari.perm > MODO_EDICIO) 
			{
				_modo = MODO_RESERVES;
			}
			else
			{
				
				_modo = MODO_RESERVES;
			}
			
			iniMenjadorEditor(_modo);
		}
			/**
			 * Load button callback
			 * @param evt Mouse Event 
			 */
			function carregaEstat(dia:Date, torn:uint = 0) {
				_AMFCanBorrell.respostaListeners(respostaRecuperaEstat);
				_AMFCanBorrell.recuperaEstat(dia, torn);				
				_peticions++;
				textSup=_peticions+" peticions en cua..."
				load();
			}
			
			private function set textSup(txt:String):void
			{
				TextField(this.getChildByName("txtData")).text = txt;
			}
			
			private function respostaRecuperaEstat(estat:EstatTaulesVO):void
			{
				var tn:Taula;
				var t:Object;
				var data:Date;
				var client:Client;
				var torn:uint;
				
				textSup=_peticions+" peticions en cua....."

				_peticions--;
				if (_peticions) 
				{
					lastResponse = estat.time;
					return;
				}
				
				//if (_peticions) _peticions--;

				if (estat.time < lastResponse) return;
				lastResponse = estat.time;
				
				_torn = estat.torn;
				
				if (_torn == 3) textSup = ObtenerFecha(_data) + " (Sopar)";
				else 		textSup = ObtenerFecha(_data) + " (Torn " + _torn + ")";
				
				

				for each(t in estat.taules) 
				{	
					// busco si ja la tinc
					for each(tn in _taules) 
					{
						if (tn.id == t.id) break;
					}
					if (tn.id == t.id) 
					{
						// la tinc, miro si si és de l'altre torn i té reserva
						if (t.dades_torn != _torn && t.reserva > 0)
						{
							data = new Date(t.dades_data.substr(0, 4), uint(t.dades_data.substr(5, 2)) - 1, t.dades_data.substr(8, 2),t.dades_hora.substr(0,2),t.dades_hora.substr(3,2));
							client = new Client( t.dades_client, "");
							torn =  t.dades_torn;
							tn.reservaB = new Reserva(t.reserva, data, torn,client, t.dades_adults, t.dades_nens4_9, t.dades_nens10_14, t.dades_cotxets, t.observacions, t.online, t.reserva_info);
						
						}
						continue;
					}
					
					if (t.dades_torn != _torn) continue;
					
					tn=afegirTaula(uint(t.id));
					
					tn.nom = t.nom;

					tn.cotxets = t.cotxets;
					tn.persones = t.persones;					
					tn.forsatPlena = Boolean(uint(t.plena));
					tn.grup = 0;
					tn.torn = _torn;
					
					if (int(t.grup)) 
					{
						tn.grup = t.grup;	
					}
					
					tn.reserva = null;
					tn.arrayGrup = null;
					if (uint(t.reserva) > 0)
					{
						data = new Date(t.dades_data.substr(0, 4), uint(t.dades_data.substr(5, 2)) - 1, t.dades_data.substr(8, 2),t.dades_hora.substr(0,2),t.dades_hora.substr(3,2));
						client = new Client( t.dades_client, "");
						torn =  t.dades_torn;
						tn.reserva = new Reserva(t.reserva, data, torn, client, t.dades_adults, t.dades_nens4_9, t.dades_nens10_14, t.dades_cotxets, t.observacions, t.online, t.reserva_info);
					}		
					
					if(int(t.x)) tn.clip.x = t.x;
					if (int(t.y)) tn.clip.y = t.y;
						
					tn.updateLabel();
					tn.activa = true;					
				}
				creaGrups();
				
				load(false);
				modo = _modo;
				
				if (!_ready) ExternalInterface.call("fromAS3_flash_ready");		
				_ready = true;
				
				ExternalInterface.call("fromAS3_canviData_ready",_peticions);		
			}
			
			private function resetMenjador():void
			{
				var tn:Taula;
				
				while (_taules.length > 1)
				{
					tn = _taules.pop();
					if (tn.clip.name != "BORRA") 
					{
						_controladorDragTaules.desactivaTaula(tn);
						tn.desactiva(_taules);
					}
				}
				
			}
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
		private function salvaEstat(taula:Taula):void
		{
				var t:TaulaVO
				var taules:Array = new Array();			
				
				if (taula.grup)
				{
					for each(var tn:Taula in _taules) 
					{
						if (tn.grup == taula.grup) 
						{
							t = new TaulaVO(tn);
							taules.push(t);
							
						}
					}
				}
				else 
				{
					t = new TaulaVO(taula);
					taules.push(t);
				}
				
				if (taules.length)
				{
					_AMFCanBorrell.respostaListeners(respostaGuardaEstat);
					_AMFCanBorrell.guardaEstat(_data,_torn,taules);
					
				}
		}
		
		private function respostaGuardaEstat(str:String):void
		{
		}
		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
			/**
			 * Load button callback
			 * @param evt Mouse Event 
			 */
			private function carregaEstatMenjador(dia:Date, torn:uint = 0) {
				
				_AMFCanBorrell.respostaListeners(respostaRecuperaEstatMenjador);
				_AMFCanBorrell.recuperaEstatMenjador(dia,torn);				
			}
			
			private function respostaRecuperaEstatMenjador(menjadors:Array):void
			{
				
				for each(var menjador:Object in menjadors) 
				{
					Sprite(this.getChildByName('bloq' + menjador.menjador)).visible = Boolean(uint(menjador.actiu));
					ordenaCapes(menjador.menjador);
				}				
			}		
	
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
/*****************************************************************************************************************************/		
			/**
			 * Load button callback
			 * @param evt Mouse Event 
			 */
			private function guardaEstatMenjador(menjador:uint,actiu:Boolean) {
				
				_AMFCanBorrell.respostaListeners(respostaGuardaEstatMenjador);
				_AMFCanBorrell.guardaEstatMenjador(_data,_torn,menjador,actiu);				
			}
			
			private function respostaGuardaEstatMenjador(str:String):void
			{
				//trace("RESPOSTA MEJ: " + str);				
			}
			
			private function ordenaCapes(n:String)
			{				
				var tapa:Sprite=Sprite(this.getChildByName("bloq" + n));
				if (tapa.visible)
				{
					for each(var tn:Taula in _taules) 
					{
						if (tapa.hitTestObject(tn.clip))
						{
							tn.treuListeners();
							this.setChildIndex(tn.clip, 0);
						}
					}
				}
				else
				{
					tapa.visible = true;
					for each(tn in _taules) 
					{
						if (tapa.hitTestObject(tn.clip))
						{
							tn.treuListeners();
							tn.posaListeners();
						}
					}					
					tapa.visible = false;
				}
			}	
			
			
		private function load(vis:Boolean=true):void 
		{
			_veladura.visible = vis;
			_loading.visible = vis;
			_veladura.alpha = 0.2;

			this.setChildIndex(_veladura, this.numChildren - 1);
			this.setChildIndex(_loading, this.numChildren - 1);
		}
		
		
		private function keepAlive(e:Event):void
		{
				_AMFCanBorrell.respostaListeners(respostakeepAlive);
				_AMFCanBorrell.recuperaUsuari();							
		}
		
		private function respostakeepAlive(usuari:UsuariVO):void
		{
			trace("KEEEEEEP ALIIIIIVE");
		}
		
	}	
}