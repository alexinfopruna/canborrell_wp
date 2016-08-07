package com.canBorrell
{
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.text.TextField;
//	import flash.events.KeyboardEvent;
//	import flash.events.MouseEvent;
//	import flash.events.TimerEvent;
//	 import flash.utils.Timer;
//	import flash.ui.Keyboard
//	import flash.geom.Rectangle;
	
	import ws.tink.display.HitTest;
	import com.canBorrell.Taula;

	public class ControladorDragPermuta extends EventDispatcher
	{
		static public const CLICK:String = "ControladorDragPermuta_click";
		public static const PERMUTA:String="ControladorDragPermuta_permuta";
		static public const SAFATA:String = "safata";
		public static const DELAY:uint = 50;
		static public const MIN_D:uint = 35;
		
		private var AMPLA_TAULA:uint=Taula.AMPLA_TAULA;
		
		private var _xant:int;
		private var _yant:int;		
		private var _xini:int;
		private var _yini:int;		
		private var _taules:Array;
		private var _parets:Array;
		
		private var _currentClip:Sprite;
		private var _currentTaula:Taula;
		private var _segonaTaula:Taula;
		private var _safata:Safata;
		
		private var _dragReserva:MovieClip;
		private var _permis_drag:Boolean;
		
		public function ControladorDragPermuta(taules:Array,parets:Array,safata:Safata )
		{
			_taules = taules;
			_parets = parets;					
			_safata = safata;
		}	
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function onDrag(e:MouseEvent):void 
		{			
			var tn:Taula;
			
			_currentClip = Sprite(e.currentTarget);
			
			if (_currentClip == _safata.clip) _currentTaula = _safata;
			else for each(tn in _taules) if (tn.clip == _currentClip) _currentTaula = tn;
			
			if (_currentTaula.nom == "BORRA" ) return;
			if (!_permis_drag || !_currentTaula.extrem || !_currentTaula.reserva || (_currentTaula.reserva==_safata.reserva && _currentTaula!=_safata))
			{
				_currentClip = null;
				dispatchEvent(new MouseEvent(ControladorDragPermuta.CLICK));	
				return;
			}			
			_currentTaula.treuListeners();
			_currentTaula.amagaInfo();
			
			
			
			_xini=_xant = _currentClip.x;
			_yini = _yant = _currentClip.y;
			
			_dragReserva = new DragReserva();
			_dragReserva.x = _xini;
			_dragReserva.y = _yini;
			_dragReserva.alpha = 0.5;
			TextField(_dragReserva.getChildByName("txt")).text=TextField(_currentTaula.clip.getChildByName("lin2")).text
			
			_currentClip.parent.addChild(_dragReserva);
			
			
			_dragReserva.stage.addEventListener(MouseEvent.MOUSE_MOVE,onMouTaula);
			_dragReserva.stage.addEventListener(MouseEvent.MOUSE_UP,offDrag);	
			_dragReserva.startDrag();
			
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function offDrag(e:MouseEvent):void 
		{
			for each(var tn:Taula in _taules) if (tn.reserva || tn.taulaGrup && tn.taulaGrup.reserva) tn.clip.alpha = 1;

			var desplasament:Boolean = (_dragReserva.x != _xini || _dragReserva.y != _yini );		
			if (_dragReserva == null) return;
			
			_dragReserva.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMouTaula);
			_dragReserva.stage.removeEventListener(MouseEvent.MOUSE_UP,offDrag);	
			_dragReserva.stopDrag();	
			
			if (desplasament) // SHA MOGUT
			{
				if (_dragReserva.x<5 || _dragReserva.x>730  || _dragReserva.y >710)
				{
						cancelaAccio();
						return;											
				}
				
				_segonaTaula=buscaExtremIman();
				
				if ( _dragReserva.y < 10 )
				{
					trace("111111");
					_segonaTaula = _safata;
					dispatchEvent(new Event(ControladorDragPermuta.SAFATA));
					cancelaAccio();	
					return;
				}
								
				
				
				if (validaPermuta())
				{
					// TOT VA BE, CANVIEM RESERVA
					dispatchEvent(new Event(ControladorDragPermuta.PERMUTA));	
					cancelaAccio();				
				}
				else
				{
					if (_segonaTaula!=_safata) trace("MALA " + (_segonaTaula?_segonaTaula.id:"BLANC"));
					cancelaAccio();				
				}
				
			}
			else //CLICK SENSE DESPLASAMENT
			{
				if (_segonaTaula!=_safata) dispatchEvent(new MouseEvent(ControladorDragPermuta.CLICK));	
				cancelaAccio();				
			}
			
			if (_dragReserva) _currentClip.parent.removeChild(_dragReserva);
			_currentClip = _dragReserva = null;
			
		}
		
/************************************************************************************/		
/*****************  COMPROVACIONS DE LA TAULA-RESERVA***********************/		
/************************************************************************************/		
		private function validaPermuta():Boolean
		{
			if (!_segonaTaula || _segonaTaula == _safata) return false;
			if (_segonaTaula.reserva) return false;
			
			return true;
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function buscaExtremIman():Taula
		{
			var clipTaula:Sprite;			
			var minD:int = MIN_D;		
			var tn:Taula;			
			
			for each(tn in _taules)
			{		
				clipTaula = tn.clip;
				if (!clipTaula.visible) continue;
				if (clipTaula == _currentClip) continue;
				var d:int=Math.sqrt((clipTaula.x-_dragReserva.x)*(clipTaula.x-_dragReserva.x)+(clipTaula.y-_dragReserva.y)*(clipTaula.y-_dragReserva.y));
				
				if (d<minD)
				{
					minD = d;
					
					if (tn.taulaGrup) return tn.taulaGrup;
					return tn;
				}
			}			
			return null;
		}
		
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function onMouTaula(e:Event):void 
		{
				var _clip:Sprite =  _dragReserva;
				_clip.stopDrag();
				_clip.stopDrag();
				var tn:Sprite;
				var txoca:Boolean = false;
				
				if (_currentTaula.clip.alpha==1) for each(var t:Taula in _taules) if (t.reserva || t.taulaGrup && t.taulaGrup.reserva) t.clip.alpha = 0.1;

				for each(var taula:Taula in _taules)
				{
					tn = taula.clip;
					if (tn == _clip) continue;
				}
				
				for each(var paret:Sprite in _parets)
				{
					if (_clip.hitTestObject(paret)) 
					{
						txoca = true;
						//OJU!! si txoca para el drag
						_clip.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMouTaula);
						_clip.x = _xant; 	
						_clip.y=_yant; 
					}
				
				}
				
				if (!txoca)
				{
					_xant = _clip.x;
					_yant = _clip.y;
					_clip.startDrag();	
				}
		}
		
		
		

/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		public function activa(permis_drag:Boolean)
		{
			_permis_drag = permis_drag;
			for each(var tn:Taula in _taules)
			{
				tn.clip.addEventListener(MouseEvent.MOUSE_DOWN, onDrag);
			}
			
			_safata.clip.addEventListener(MouseEvent.MOUSE_DOWN, onDrag);
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		public function desActiva()
		{
			for each(var tn:Taula in _taules)
			{
				tn.clip.removeEventListener(MouseEvent.MOUSE_DOWN,onDrag);
			}
			
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		public function cancelaAccio()
		{
			
			if (!_dragReserva) return false;
			_dragReserva.stage.removeEventListener(MouseEvent.MOUSE_MOVE,onMouTaula);
			_dragReserva.stage.removeEventListener(MouseEvent.MOUSE_UP,offDrag);		
			_dragReserva.parent.removeChild(_dragReserva);
			_dragReserva = null;
			
			_currentTaula.posaListeners();
		}
		
		
		public function get currentTaula():Taula { return _currentTaula; }
		
		public function get segonaTaula():Taula { return _segonaTaula; }
		
	}
}