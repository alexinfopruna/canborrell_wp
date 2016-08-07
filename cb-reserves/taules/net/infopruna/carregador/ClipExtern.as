package net.infopruna.carregador
{
	import flash.display.Loader;
	import flash.display.LoaderInfo;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.events.ProgressEvent;
	import flash.events.EventDispatcher;
	import flash.geom.Point;
	import flash.net.URLRequest;	
	import flash.display.Stage; //FALTA
	import flash.display.DisplayObject;
    import flash.filters.DropShadowFilter;
	
	//import com.gskinner.motion.*
	import caurina.transitions.*;
	import fl.transitions.*;
	import fl.transitions.easing.*;
	
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
	public class ClipExtern extends MovieClip
	{
		public static  const CARREGAT:String = "carregat";
		public static  const CARREGA_ACABADA:String = "carrega_acabada";
		public static  const AMAGAT:String = "amagat";
		public static  const MOSTRAT:String = "mostrat";
		public static  const TANCA_PANEL:String = "tanca_panel";
		
		public var  EFECTE_FORSAT:Boolean = false;
		public var modal:Boolean=false;

		protected var _carregat:Boolean = false;
		protected var _config:Object;

		private var _clip:*;
		private var _urlclip:String;
		private var loader:Loader;
		protected var _percentero:Percentero;
		private var _default:Boolean=false;
		private var _mostrant:Object;
		private var _mostrat:Boolean=true;
		private var _amagant:Object;
		private var _amagat:Boolean=false;
		private var  _centrantW:Number;
		private var  _centrantH:Number;
		private var _sensible:Boolean=true;
		private var _w:Number=-1;
		private var _h:Number=-1;
		private var _ombra:Boolean=false; 
		private var _retallaW:Number;
		private var _retallaH:Number;
	
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function ClipExtern( mc:Object = null,conf:Object=null)
		{
			// Carrega per URL
			_config = conf;
			//_clip = new MovieClip();			
			
			if ((mc is String)&&(mc!="demo"))
			{
				if ((_config!=null)&&(_config.hasOwnProperty("percentero")))
				{
					var percentero:Object;
					percentero=_config.percentero;
					//Crea el percentero en funció del tipus de paràmetre
					if (percentero!=null && percentero is Percentero) _percentero=Percentero(percentero);  //EP! FALTA
					else if (percentero is MovieClip) _percentero=new Percentero(percentero);
					if (percentero is String) _percentero = new Percentero(percentero);
					
				}
				//else _percentero=new Percentero();
				// Carrega url
				//addChild(_clip);
				URLClip=String(mc);
			}
			// Monta un MC que li passen
			else if (mc is MovieClip)
			{
				_clip=mc;
				carregat=true;				
				addChild(_clip);
				dispatchEvent(new Event(ClipExtern.CARREGAT));
				
				if (_clip.hasOwnProperty("tanca"))
				{
					trace("te tanca")
					_clip.tanca.addEventListener(MouseEvent.CLICK,onTanca);
				}
			}
			// Crea un MC buit per defecte
			else
			{
				// MC buit
				if ((mc is String)&&(mc=="demo")) _clip=MCDemo();
				else _clip=new MovieClip();
				
				carregat=true;	
				_default=true;
				addChild(_clip);	
			}
		}
		//////////////////////////////////////////////////////////////////
		//////////   SHOW / HIDE          ////////////////////////////////
		//////////////////////////////////////////////////////////////////

		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function mostra(params:Object=null)
		{
			if (!carregat)
			{
				if (_amagant)
				{
					_amagant=new Object();
					_amagant.alpha=0;
				}
				_mostrant=params;
				
				if (_mostrant==null) 
				{
					_mostrant=new Object();
					_mostrant.alpha=1;
				}
				
				_mostrat=false;
				ombra=_ombra;
				return;
			}
			else
			{
				_mostrat=false;
				
				if (params==null)
				{
					//PER DEFECTE VISIBLE
					//_clip.alpha=1;
					//onMostraComplete();
					params={alpha:1};
					//return;
					
				}
				if (params is String)
				{
					/* arguments*/
					var trans:Array=String(params).split(",");
					
					switch (trans[0].toLowerCase())
					{											
						case "zoomfade":
							if (EFECTE_FORSAT)
							{
								_clip.x=_w/2
								_clip.y=_h/2
								_clip.alpha=0;
								_clip.scaleX=0;
								_clip.scaleY=0;								
							}
							if (!mostrat)
							{
								_clip.scaleX=0;
								_clip.scaleY=0;										
								_clip.alpha=0;
							}

								_clip.alpha=1;
							//params={time:0.7,x:0,y:0,scaleX:1,scaleY:1,alpha:1,onComplete:onMostraComplete};
						break;
						
						case "zoom":
						
						
							if (EFECTE_FORSAT)
							{
								_clip.x=_w/2+_clip.x
								_clip.y=_h/2+_clip.y
								_clip.alpha=1;
								_clip.scaleX=0;
								_clip.scaleY=0;		
							}
							if (!mostrat)
							{
								_clip.scaleX=0;
								_clip.scaleY=0;		
								
							}
							
							params={time:0.7,x:0,y:0,scaleX:1,scaleY:1,alpha:1,onComplete:onMostraComplete};
						break;
						
						case "fade":
							if (EFECTE_FORSAT)
							{
								_clip.alpha=0;
							}
							if (!mostrat)
							{
								_clip.alpha = 0;
							}

							params={time:1.2,alpha:1,onComplete:onMostraComplete};
						break;
						default:
							params={alpha:1,onComplete:onMostraComplete};
					}
					
					if (trans.length>1) params.time=Number(trans[1]);
					if (trans.length>2) params.transition=trans[2];
				}
				else 
				{
					params.onComplete=onMostraComplete;
				}
			
				_clip.visible=true;
				_mostrat=true;
				
				// CAURINA 
				//_clip.visible=true;onMostraComplete();
				Tweener.addTween(_clip,params);		
				//Tweener.addCaller(_clip,{caller:onMostraComplete})
			}
		}
		///////////////////////////////////////////
		private function onMostraComplete(e:Event=null)
		{
			_amagat=false;
			_mostrat=true;
			_mostrant=null;
			dispatchEvent(new Event(ClipExtern.MOSTRAT));
			ombra=_ombra;
			if (clip.hasOwnProperty("tanca")) 
			{
				clip.tanca.addEventListener(MouseEvent.CLICK,onTanca);
			}
		}
		
		
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function amaga(params:Object=null)
		{
			if (!carregat)
			{
				if (_mostrant)
				{
					_mostrant=null;
				}
				if (params==null) 
				{
					_amagant=new Object();
					_amagant.alpha=0;
				}
				else
				{
					_amagant=params;
				}
				_mostrat=false;
				return;
			}
			else
			{			
				if (params==null || _amagant!=null)
				{
					//PER DEFECTE INVISIBLE
					if (params==null)
					{
						_clip.alpha=0;
						onAmagaComplete();
						return;
					}
					else
					{
						_amagant = null;	
						params = { time:0, alpha:0 };//1-2011
					}
				}
				else
				{
					_clip.visible=true;
				}
				if (params is String)
				{
					/* arguments*/
					var trans:Array=String(params).split(",");
					switch (trans[0].toLowerCase())
					{								
						case "zoomFade":
							if (EFECTE_FORSAT)
							{
								clip.x=0;
								clip.y=0;
								clip.scaleX=1;
								clip.scaleY=1;
								clip.alpha=1;
							}
							params={time:0.7,x:_w/2,y:_h/2,scaleX:0,scaleY:0,alpha:0,onComplete:onAmagaComplete};
						break;
						case "zoom":
							if (EFECTE_FORSAT)
							{
								clip.x=0;
								clip.y=0;
								clip.scaleX=1;
								clip.scaleY=1;
							}

							params={time:0.7,x:_w/2,y:_h/2,scaleX:0,scaleY:0,onComplete:onAmagaComplete};
						break;
						
						case "fade":
							if (EFECTE_FORSAT)
							{
								clip.alpha=1;
							}
							params={time:1.2,alpha:0,onComplete:onAmagaComplete};
						break;
						
						case "noTrans":
							clip.alpha=0;							
							params={time:0,alpha:0,onComplete:onAmagaComplete};
						break;
						
						default:
							params={alpha:0,onComplete:onAmagaComplete};
					}
					if (trans.length>1) 
					{
						params.time=Number(trans[1]);
					}
					if (trans.length>2)
					{
						params.transition=trans[2];
					} 

				}
				else 
				{
					params.onComplete=onAmagaComplete;

				}

				
				
				// CAURINA 


				Tweener.addTween(_clip,params);
				//Tweener.addCaller(_clip,{caller:onAmagaComplete})
			}
		}
		///////////////////////////////////////////
		private function onAmagaComplete(e:Event=null)
		{
			_amagat=true;
			_amagant=null;
			_mostrat=false;
			_clip.visible=false;

			dispatchEvent(new Event(ClipExtern.AMAGAT));
		}
		///////////////////////////////////////////
		public function retalla(w:Number=-1,h:Number=-1)
		{
			var proporcio:Number;
			
			if (_clip==null) 
			{
				
				if (w == -1) w = this.parent.width;
				if (h == -1) h = this.parent.height;
				_retallaW=w;
				_retallaH = h;
				return;
			}
			_retallaW = _retallaH = -1;
			
			proporcio = _clip.width / _clip.height;
			
			if (_clip.width > w) 
			{
				_clip.width = w;
				_clip.height= _clip.width/proporcio;
			}
			if (_clip.height > h) 
			{
				_clip.height = h;
				_clip.width = _clip.height*proporcio;
			}
			
		}
		public function centra(w:Number=-1,h:Number=-1)
		{
			if (_clip==null) 
			{
				
				if (w == -1) w = this.parent.width;
				if (h == -1) h = this.parent.height;
				_centrantW=w;
				_centrantH = h;
				return;
			}
			_centrantW = _centrantH = -1;
			//w = _clip.parent.width;
			//h = _clip.parent.height;
			//if (w>=0) _clip.x=w/2-_clip.width/2;
			//if (h>=0) _clip.y=h/2-_clip.height/2;
			if (w>=0) this.x=w/2-_clip.width/2;
			if (h >= 0) this.y = h / 2 - _clip.height / 2;
			
			//this.x = 400;
			
		}
		
		
		
		//////////////////////////////////////////////////////////////////
		//////////   SET / GET            ////////////////////////////////
		//////////////////////////////////////////////////////////////////
		
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get config():Object
		{
			return _config;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function getConfig(param:String):Object
		{
			if ((_config!=null)&&(_config.hasOwnProperty(param)))	return _config[param];
			
			return null																					 
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		
		public function set config(conf:Object):void
		{
			_config=conf;
		}
		/**/
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get mostrat():Boolean
		{
			return _mostrat;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get amagat():Boolean
		{
			return _amagat;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get urlclip():String
		{
			return _urlclip;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get clip():MovieClip
		{
			return _clip;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function set carregat(c:Boolean):void
		{
			_carregat=c;
			if (c)
			{
				_w=_clip.width;
				_h=_clip.height;
			}
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get carregat():Boolean
		{
			return _carregat;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function get sensible():Boolean
		{
			return _sensible;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function set sensible(c:Boolean):void
		{
			
			_sensible=c;
		}

		
		//////////////////////////////////////////////////////////////////
		//////////   DUPLICADOR           ////////////////////////////////
		//////////////////////////////////////////////////////////////////
		
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		/*
		  public static function duplicaClip():ClipExtern
		  {
			// var targetClass:Class;
			 //targetClass = Object(target).constructor;
			 var duplicado:ClipExtern = new ClipExtern();
	
			 duplicado.transform = clip.transform;
			 duplicado.filters = clip.filters;
			 duplicado.cacheAsBitmap = clip.cacheAsBitmap;
			 duplicado.opaqueBackground = clip.opaqueBackground;
	
			 target.parent.addChild(duplicado);
			 return duplicado;
		  }
		  */
		//////////////////////////////////////////////////////////////////
		//////////   DRAGGER       ////////////////////////////////
		//////////////////////////////////////////////////////////////////
		
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		public function addDragger(dragger:DisplayObject,x:Number=0,y:Number=0,w:Number=0,h:Number=0):void
		{
			//FALTA
		}

		public function removeDragger(dragger:DisplayObject):void
		{
			//FALTA
		}
		
		//////////////////////////////////////////////////////////////////
		//////////   CARREGA RECURS       ////////////////////////////////
		//////////////////////////////////////////////////////////////////
		
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////

		public function set URLClip(url:String):void
		{
			
			carrega(_urlclip=url);
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		private function carrega(url:String):void
		{
			var request:URLRequest = new URLRequest( url );
			loader = new Loader( );
			loader.contentLoaderInfo.addEventListener( Event.INIT , onInit );
			loader.contentLoaderInfo.addEventListener( Event.COMPLETE , onComplete );
			if (_percentero!=null) 
			{
			/*	
			//CENTRA PERCENTERO
				if (this.stage)
				{
					var centre:Point = new Point(this.stage.stageWidth / 2, this.stage.stageHeight / 2)
					//centre=localToGlobal(centre);
					_percentero.x = centre.x;
					_percentero.y = centre.y;
					trace(this.stage.stageWidth/2 + " H " + this.stage.stageWidth/2)
					trace(_percentero.x + " H " + _percentero.y)


				}
*/
				addChild(_percentero);				
				//_percentero.centra();
				loader.contentLoaderInfo.addEventListener( ProgressEvent.PROGRESS , onProgress );
			}
			loader.load( request );
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		private function onInit(e:Event = null):void
		{
			LoaderInfo(e.target).removeEventListener( Event.INIT , onInit );
			
			if (LoaderInfo(e.target).contentType.substring(0,5)=="image")
			{
				//trace(LoaderInfo(e.target).contentType+" CLIP "+_clip)
				if (!_clip) _clip = new MovieClip();			
				_clip.addChild(loader);
				addChild(_clip);
				
			}
			else
			{
				_clip=LoaderInfo(e.target).content;
				addChild(loader);
			}
			
			ombra=_ombra;
			
			/*
			*/
			carregat = true;
			
			if (_amagant!=null) 
			{
				//_clip.alpha=0;
				amaga(_amagant); //??????
			}
			if (_mostrant!=null) 
			{
				mostra();
				//mostra(_mostrant);
			}
			if (_retallaW>-1 || _retallaH>-1) 
			{
				retalla(_retallaW,_retallaH);
			}
			if (_centrantW>-1 || _centrantH>-1) 
			{
				centra(_centrantW,_centrantH);
			}
			dispatchEvent( new Event( ClipExtern.CARREGAT ) );
/*			
			if (clip.hasOwnProperty("tanca")) 
			{
				clip.tanca.addEventListener(MouseEvent.CLICK,onTanca);
			}
*/	
			//visible=true;
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		private function onProgress(e:ProgressEvent)
		{
			var tpercent:Number=e.bytesLoaded/e.bytesTotal;			
			
		    _percentero.percent=tpercent;
		}
		
		private function onComplete(e:Event)
		{
			try 
			{
				if (_percentero!=null) removeChild(_percentero);				
			}catch (err:Error)
			{
				//trace ("EPA!, percentero null!")
			}
			//_clip.y+=50;
			loader.contentLoaderInfo.removeEventListener( ProgressEvent.PROGRESS , onProgress );
			loader.contentLoaderInfo.removeEventListener( Event.COMPLETE , onComplete );
			dispatchEvent( new Event( ClipExtern.CARREGA_ACABADA ) );
		}
		
		//////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////
		private function onTanca(e:Event)
		{
			//clip.tanca.removeEventListener(MouseEvent.CLICK,onTanca);
			if (_mostrat && _sensible) 
			{
				dispatchEvent(new Event(ClipExtern.TANCA_PANEL));
				clip.tanca.removeEventListener(MouseEvent.CLICK, onTanca);
			}
			
		}
		
		//////////////////////////////////////////////////////////////////
		//////////   DEMO                 ////////////////////////////////
		//////////////////////////////////////////////////////////////////
		private function MCDemo():MovieClip
		{
			var mc:MovieClip=new MovieClip();
			var barra:MovieClip=new MovieClip();
			
			// posem el fons
			mc.graphics.beginFill( 0xFFAAAA, 1 );
			mc.graphics.drawRect( 0, 0, 100, 100);
			mc.graphics.endFill();

			// posem la barra
			barra.graphics.beginFill( 0x884444, 1 );
			barra.graphics.drawRect( 15, 15, 70, 70);
			barra.graphics.endFill();
			barra.name="barra";
			
			barra.rotation=30;
			
			mc.addChild(barra);
			mc.rotation=15;
			mc.x=mc.y=150;
			
			return(mc);
		}
		
		public function set ombra(v:Boolean)
		{
			_ombra=v;
			if (_clip==null) 
			{
				return;
			}
			
			if (v)
			{
			  var _color:Number=0;
			  var _angulo:Number=45;
			  var _alfa:Number=0.7;
			  var _blurX:Number=5;
			  var _blurY:Number=5;
			  var _distancia:Number=7;
			  var _strength:Number=0.65;
			  var myFilters:Array = new Array();
			  myFilters.push(new DropShadowFilter(_distancia,_angulo,_color,_alfa,_blurX,_blurY,_strength));
			  _clip.filters = myFilters;				
			}
		}

	}
}

