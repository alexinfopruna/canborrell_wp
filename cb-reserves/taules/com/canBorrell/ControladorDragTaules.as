package com.canBorrell
{
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	
	import ws.tink.display.HitTest;
	import com.canBorrell.Taula;

	public class ControladorDragTaules extends EventDispatcher
	{
		public static const MOVIMENT_TAULA:String="moviment_taula";
		public static const TAULA_AGRUPADA:String="taula_agrupada";
		static public const MOVIMENT_GRUP:String = "movimentGrup";
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
		private var _permisos:uint;
		
		public function ControladorDragTaules(taules:Array,parets:Array)
		{
			_taules = taules;
			_parets = parets;	
			
		}	
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function onDrag(e:MouseEvent):void 
		{			
			var tn:Taula;
			
			_currentClip = Sprite(e.currentTarget);
			
			for each(tn in _taules) if (tn.clip == _currentClip) _currentTaula = tn;
			
			//if (_currentTaula.arrayGrup[0])
			if (!_currentTaula.extrem)
			{
				_currentClip = null;
				return;
			}
			
			_currentTaula.treuListeners();
			_currentTaula.amagaInfo();
			
			if (_currentTaula.nom == "BORRA" ) return;
			
			
			_xini=_xant = _currentClip.x;
			_yini=_yant = _currentClip.y;
			_currentClip.stage.addEventListener(MouseEvent.MOUSE_MOVE,onMouTaula);
			_currentClip.stage.addEventListener(MouseEvent.MOUSE_UP,offDrag);	
			_currentClip.startDrag();
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function offDrag(e:MouseEvent):void 
		{
			var desplasament:Boolean = (_currentClip.x != _xini || _currentClip.y != _yini );
			
			if (_currentClip == null) return;
			_currentClip.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMouTaula);
			_currentClip.stage.removeEventListener(MouseEvent.MOUSE_UP,offDrag);	
			_currentClip.stopDrag();	
			
			if (desplasament) // SHA MOGUT
			{
				if (_currentClip.x<5 || _currentClip.x>730 || _currentClip.y <10 || _currentClip.y >710)
				{
						cancelaAccio();
						return;											
				}
				
				if (_currentTaula.arrayGrup && _currentTaula == _currentTaula.arrayGrup[0]) 
					{
						trace("MOU")
						mouGrup();
						return;
					}
				
				_segonaTaula = buscaExtremIman();
				
				if (_segonaTaula &&  _currentTaula.grup)
				{
						trace("DESAGRUPA + BORRA: "+_segonaTaula.id + " / " +_currentTaula.grup);
						cancelaAccio();
						return;						
				}
				
				
				if (_segonaTaula)
				{
					trace("SEGONA: "+_segonaTaula.id);
					trace("GRUP: " + _currentTaula.grup);
					
					//if (_segonaTaula.nom == "BORRA" && (_currentTaula.grup || _currentTaula.reserva))
					if (_segonaTaula.nom == "BORRA" && (_currentTaula.grup || _currentTaula.reserva))
					{
						trace("NO ES POT BORRAR TAULA RESERVADA / AGRUPADA");
						cancelaAccio();
						return;						
					}
					
					
					if (!_segonaTaula.extrem)
					{
						cancelaAccio();
						return;
					}
					else
					{
						iman(_segonaTaula.clip)
						if (solape())
						{
							cancelaAccio();
							return;
						}
						dispatchEvent(new Event(ControladorDragTaules.TAULA_AGRUPADA))		
					}
					
				}
				else
				{
					dispatchEvent(new Event(ControladorDragTaules.MOVIMENT_TAULA))		
				}
				_currentTaula.posaListeners();
				
			}
			else //CLICK SENSE DESPLASAMENT
			{
				editaTaula();
			}			
			_currentClip = null;
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function mouGrup():void
		{
			var dx:Number=_xini - _currentTaula.clip.x;
			var dy:Number=_yini - _currentTaula.clip.y;
			
			for each(var tn:Taula in _currentTaula.arrayGrup)
			{
				if (tn == _currentTaula) continue;
				tn.clip.x-=dx;
				tn.clip.y -= dy;
			}
			dispatchEvent(new Event(ControladorDragTaules.MOVIMENT_GRUP))		
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
				var d:int=Math.sqrt((clipTaula.x-_currentClip.x)*(clipTaula.x-_currentClip.x)+(clipTaula.y-_currentClip.y)*(clipTaula.y-_currentClip.y));
				
				if (d<minD)
				{
					minD = d;
					return tn;
				}
			}
			return null;
		}
		
		private function editaTaula():void
		{
			if (_currentTaula.arrayGrup) _currentTaula = _currentTaula.arrayGrup[0];
trace("EDIT TAULAAAAA")
//_currentTaula.clip.addEventListener(MouseEvent.CLICK, desbloqueja);
			_currentTaula.infoTaula.addEventListener(InfoTaula.GUARDA_DADES, desbloqueja)

			_currentTaula.editTaula();
			this.desActiva();
			for each(var tn:Taula in _taules) tn.treuListeners();			
		}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function desbloqueja(e:Event):void 
		{
			trace("DESBLOQUEJAAAAA")
			if (!_currentTaula.editant) 
			{
				_currentTaula.clip.removeEventListener(MouseEvent.CLICK, desbloqueja);
				this.activa();
				for each(var tn:Taula in _taules) tn.posaListeners();
			}
		}
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function solape():Boolean
		{
			if (_segonaTaula && _segonaTaula.arrayGrup)
				for each(var tn:Taula in _segonaTaula.arrayGrup) 
				{
					if (tn.clip.x == _currentClip.x && tn.clip.y == _currentClip.y && _currentClip!=tn.clip)
					{
						cancelaAccio();
						return true;
					}
				}
			return false
		}
		

/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
			private function iman(mesProper:Sprite):void
			{
				var eix1:uint;
				var eix2:uint;
				var taula:Sprite;			
				taula = mesProper;
			
				eix1 = Math.abs(_currentClip.x - taula.x);
				eix2 = Math.abs(_currentClip.y - taula.y);
				
				if (eix1 > eix2)
				{
					if (_currentClip.x  <= taula.x || _currentClip.x >= taula.x) 
					{
						_currentClip.y = taula.y;
						if (_currentClip.x > taula.x) _currentClip.x = taula.x + AMPLA_TAULA+1;
						else _currentClip.x = taula.x - (AMPLA_TAULA+1);
					}
				}else
				{
					if (_currentClip.y  <= taula.y || _currentClip.y >= taula.y) 
					{
						_currentClip.x=taula.x;
						if (_currentClip.y > taula.y) _currentClip.y = taula.y + AMPLA_TAULA+1;
						else _currentClip.y = taula.y - (AMPLA_TAULA+1);
					}	
				}
			}
		
/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		private function onMouTaula(e:Event):void 
		{
				var _clip:Sprite =  _currentClip;
				_clip.stopDrag();
				_clip.stopDrag();
				var tn:Sprite;
				var txoca:Boolean = false;
				

				for each(var taula:Taula in _taules)
				{
					tn = taula.clip;
					if (tn == _clip) continue;

					if (_clip.hitTestObject(tn) && false) 
					{
						//trace("txoca")
						//OJU!! si txoca para el drag
						_clip.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMouTaula);
						txoca = true;
						
						if (_clip.x+AMPLA_TAULA > tn.x && _clip.x < tn.x )  _clip.x=_xant; 
						if (_clip.x < tn.x+AMPLA_TAULA && _clip.x >= tn.x) _clip.x=_xant; 					
						if (_clip.y+AMPLA_TAULA > tn.y && _clip.y <= tn.y) _clip.y=_yant; 
						if (_clip.y < tn.y+AMPLA_TAULA && _clip.y >= tn.y) _clip.y=_yant; 			
					}
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
		public function desactivaTaula(t:Taula):void 
		{
			t.clip.removeEventListener(MouseEvent.MOUSE_DOWN, onDrag);
		}

/************************************************************************************/		
/************************************************************************************/		
/************************************************************************************/		
		public function activa()
		{
			for each(var tn:Taula in _taules)
			{
				//if (tn.extrem) 
					tn.clip.addEventListener(MouseEvent.MOUSE_DOWN, onDrag);
			}
			
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
			
			if (!_currentTaula) return false;
			
			_currentTaula.clip.x = _xini;
			_currentTaula.clip.y = _yini;
			_currentTaula.posaListeners();
			_currentTaula = null;
		}
		
		
		public function get currentTaula():Taula { return _currentTaula; }
		
		public function get segonaTaula():Taula { return _segonaTaula; }
		
	}
}