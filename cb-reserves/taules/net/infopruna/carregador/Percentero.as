package net.infopruna.carregador
{
	import flash.display.MovieClip;
	import flash.display.Loader;
	import flash.display.Shape;
	import flash.display.Stage;
	import flash.geom.Point;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.text.TextFieldAutoSize;
	import flash.net.URLRequest;
	import flash.events.Event;
	import flash.display.DisplayObjectContainer;
	////////////////////////////////////////////
	////////////////////////////////////////////
	// Alex Garcia 
	// Octubre 2009
	//
	// Es un indicador de progrés. 
	// Implementa IPercentero: funció setter percent(Number)
	// 
	// Se li pot passar un MC (ha de tenir un element barra:MC
	// Se li pot passar url: String, i carrega el recurs (ha de tenir barra)
	// Si rep altra cosa, null... crea una barra per defecte
	//
	// Crea un text indicador per defecte i el mostra o no amb set showText(Bool)
	// Si ja rep un element amb un textPercent:textField, llavors no el crea i l'utilitza
	////////////////////////////////////////////
	public class Percentero extends MovieClip implements IPercentero
	{
		public static const PERCENTERO_DEFAULT="_percentero_default_";
		
		private var _clip:MovieClip;
		protected var carregat:Boolean=false;
		private var _pc:Number=0;
		private var loader:Loader;
		private var _clip_w:Number=100;
		var _fmat:TextFormat;
		var _showText:Boolean=false;
		var _default:Boolean=false;
		var _centra:DisplayObjectContainer;
		
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		public function Percentero(mc:Object=null)
		{
			//Modifica el gràfic per marcar el percentatge
			carregat=false;
			
			_fmat=new TextFormat();
			_fmat.color = 0x888888;
			_fmat.font = "Arial";
			_fmat.size = 11;		
			_fmat.bold=true;

			
			if (mc is MovieClip)
			{
				//trace("Percentero set MC "+mc);
				_clip=MovieClip(mc);
				_clip_w=_clip.width;
				carregat=true;

				
				addChild(_clip);
			}
			else if ((mc is String)&&(mc!=PERCENTERO_DEFAULT))
			{
				//trace ("Percentero URL");
				URLClip=String(mc);
			}
			else
			{
				//trace ("Percentero per defecte");
				_clip=percenteroDefault();
				carregat=true;	
				_default=true;
				//clip_w=_clip.width;
				addChild(_clip);
	
			}

			percent = 0;
			addEventListener(Event.ADDED_TO_STAGE, addedToStage);
		   //
		}
		
		private function addedToStage(e:Event):void 
		{
			removeEventListener(Event.ADDED_TO_STAGE, addedToStage);
			//centra(this.stage);
		}
		
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		public function set percent(pc:Number):void
		{
			//Modifica el gràfic per marcar el percentatge
			_pc=pc;
			if (carregat)
			{
				if (_showText)
				{
					TextField(_clip.getChildByName("textPercent")).text=String(Math.floor(_pc*100))+" %";
					if (_default) TextField(_clip.getChildByName("textPercent")).setTextFormat( _fmat )
				}
				
				MovieClip(_clip.getChildByName("barra")).width=_clip_w*_pc;
			}
			
		}
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		private function set URLClip(url:String)
		{
		   //_pc=0;
		   carregat=false;
			
		   if (url!=null)
		   {
			   trace("CARREGANT PERCENTERO");
			   loader = new Loader( );
			   var request:URLRequest = new URLRequest( url );
			   loader.load( request );
			   loader.contentLoaderInfo.addEventListener( Event.INIT , onInit );
			   //loader.contentLoaderInfo.addEventListener( Event.COMPLETE , onComplete );
			   _clip.addChild(loader);		
		   }
		}

		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		private function onInit(e:Event)
		{
			loader.contentLoaderInfo.removeEventListener( Event.INIT , onInit );
		   _clip=MovieClip(loader.content);

			_clip_w=_clip.width;
		   
			carregat=true;
			showText=_showText;
			percent=_pc;
			//centra(_centra);

		}
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		public function centra(cont:DisplayObjectContainer=null)
		{
			//trace("centra1 "+carregat+" / "+cont);

			
			if (carregat && (cont || this.stage))
			{
				//if (cont) trace("centra12: "+cont.width);
				
				if (cont==null || cont is Stage)
				{
					var __x:int;
					var __y:int;
				
					__x=(stage.stageWidth/2)-(_clip.width/2);
					__y = (stage.stageHeight / 2) - (_clip.height / 2);
										
					
					var centre:Point= new Point(__x, __y)
					
					x = centre.x;
					y = centre.y;
					
				}
				else
				{
					//trace("centra2: "+cont.width+" / "+_clip.width);
					_clip.x=(cont.width/2)-(_clip.width/2);
					_clip.y=(cont.height/2)-(_clip.height/2);
				}
			}
			else
			{
				_centra = cont;
			}
		}
		
		

		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		public function percenteroDefault():MovieClip
		{
			var mc:MovieClip=new MovieClip();
			var barra:MovieClip=new MovieClip();
			
			// posem el fons
			mc.graphics.beginFill( 0xaaaaaa, 1 );
			mc.graphics.drawRect( 0, 17, _clip_w, 5);
			mc.graphics.endFill();

			// posem la barra
			barra.graphics.beginFill( 0x444444, 1 );
			barra.graphics.drawRect( 0, 18, _clip_w, 3);
			barra.graphics.endFill();
			barra.name="barra";
			mc.addChild(barra);

			//posem text
			var textPercent:TextField;
			textPercent=txtDefault();
			textPercent.visible=_showText;
			mc.addChild(textPercent);
			
		
			return(mc);
		}
		
		private function txtDefault(fmat:TextFormat=null):TextField
		{
			var txtPercent:TextField = new TextField()
			txtPercent.name = "textPercent";
			txtPercent.selectable = false;
			txtPercent.autoSize = TextFieldAutoSize.CENTER;
			txtPercent.htmlText = "0%";
			
			if (fmat!=null)
			{
				_fmat=fmat;
			}
			txtPercent.x = _clip_w/2-8;
			txtPercent.y= 3;
			txtPercent.width=100;
			txtPercent.setTextFormat( _fmat )
			
			return txtPercent;
		}
		
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		public function set showText(st:Boolean):void
		{
			_showText=st;
			var teText:Boolean=false;
			
			if (!carregat) return;
			
		if ((!_clip.getChildByName("textPercent"))&&(st))
		   {
			  /// trace("afegim text");
			   var textPercent:TextField=txtDefault();
			   textPercent.name="textPercent";
			   _clip.addChild(textPercent);
			   _default=true;
			}
			
			if (st) TextField(_clip.getChildByName("textPercent")).visible=st;
		}
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		/*
		private function onComplete(e:Event)
		{
trace("COMPLETE");
			loader.contentLoaderInfo.removeEventListener( Event.COMPLETE , onComplete );
		   _clip=MovieClip(loader.contentLoaderInfo);
		   if (!_clip.hasOwnProperty(textPercent))
		   {
			   var textPercent:TextField=txtDefault();
			   textPercent.name="textPercent";
			   _clip.addChild(textPercent)
			}
			
			carregat=true;
			percent=_pc;
		}
		*/
		
		public function get clip():MovieClip
		{
			return _clip;
			
		}

		
	}
}