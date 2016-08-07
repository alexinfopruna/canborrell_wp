package net.infopruna.carregador
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;	

	public class XMLLoader implements IEventDispatcher
	{
		public static const CARREGAT:String = "carregat";
		public static const XML_ESTADO_OK:String = "xml_estado_ok";
		public static const XML_ESTADO_ERROR:String = "xml_estado_error";
		public static const XML_ERROR:String = "xml_error";
		public static const IO_ERROR:String = "io_error";
		
		private var _loader:URLLoader;
		private var urlReq:URLRequest;
			
		private var _xml:XML;
		private var _trace:Boolean=false;
		private var _url:String;
		private var _estadoOK:Boolean=false;

		private var dispatcher:EventDispatcher;
	
		function XMLLoader(url:String, datos:Object=null, estadoOK:Boolean=false)
		{
			_url=url;
			urlReq = new URLRequest( _url );
			_loader = new URLLoader();
			
			if (datos!=null)
			{
				if (datos.hasOwnProperty("requestEstadoOK")) _estadoOK=datos.requestEstadoOK;
				if (datos.hasOwnProperty("trace")) _trace=datos.trace=="on";
				urlReq.method = URLRequestMethod.POST;
	
				var urlvars:URLVariables = new URLVariables( );
				if (datos!=null) 
				{
					for (var i in datos) urlvars[i] = datos[i];
					urlReq.data = urlvars;
				}
			}
			
			dispatcher = new EventDispatcher( this );	
	

			if (_trace) trace("XMLLoader file: "+url );
			_loader.load( urlReq ); 


		_loader.addEventListener( Event.COMPLETE , onComplete );
		_loader.addEventListener( IOErrorEvent.IO_ERROR , onError );
		//_peticion.addEventListener( Event.ACTIVATE , onIni );
		//_peticion.addEventListener( ProgressEvent.PROGRESS , onProgres );

		}
		
		
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		public function get getXML():XML
		{
			return _xml;
		}

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		private function onComplete(ev:Event):void
		{
			if (_trace) trace("XMLLoader XML OK: "+ev.target.data );
			try{_xml = new XML( ev.target.data );}
			catch(err:Error){
				trace (err);
				dispatchEvent( new Event( XML_ERROR , ev.target.data) )
			}

			//_xml.ignoreWhite = true;			
			
			//trace("REBUT XML"+_xml)
			dispatchEvent( new Event(CARREGAT , ev.target.data) );			
			_loader.removeEventListener( Event.COMPLETE , onComplete );
			
			// estadoOK indica si hem de comprobar l'atribut estado="ok"
			if ((_estadoOK)&&(_xml.@estado == undefined))
			{
				//trace("XML ERROR");
				dispatchEvent( new Event( XML_ERROR , ev.target.data) );
			}		
			if ((_estadoOK)&&(_xml.@estado != undefined && _xml.@estado!="ok" && _xml.@estado!="OK"))
			{
				//trace("XML ERROR");
				dispatchEvent( new Event( XML_ERROR , ev.target.data) );
			}		
			
			if (_xml.@estado != undefined && _xml.@estado== "error" ) 
			{
				//trace("XML Estado ES ERROR");
				dispatchEvent( new Event( XML_ERROR , ev.target.data) );
				dispatchEvent( new Event( XML_ESTADO_ERROR , ev.target.data) );
			}		
			else if (_xml.@estado != undefined && (_xml.@estado== "ok" || _xml.@estado=="OK")) 
			{
				//trace("XML ESTADO OK!");
				dispatchEvent( new Event( XML_ESTADO_OK , ev.target.data) );
			}	
		}	

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		private function onError(ev:IOErrorEvent):void 
		{
			//trace(" XML error");
			if (_trace) trace("XMLLoader XML ERROR: "+ev.target.data );
			_loader.removeEventListener( IOErrorEvent.IO_ERROR , onError );
			dispatchEvent( new Event( IO_ERROR , ev.target.data) );
			dispatchEvent( new Event( XML_ERROR , ev.target.data) );
		}
		
		
		
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		// implementación de los métodos de la interfase IEventDispatcher
		/////////////////////////////////////////////////////////////////////////
		public function addEventListener(type:String, listener:Function, useCapture:Boolean = false, priority:int = 0, useWeakReference:Boolean = true):void 
		{
			dispatcher.addEventListener( type , listener , useCapture , priority , useWeakReference );
		}
		public function dispatchEvent(evt:Event):Boolean 
		{
			return dispatcher.dispatchEvent( evt );
		}
		public function hasEventListener(type:String):Boolean 
		{
			return dispatcher.hasEventListener( type );
		}
		public function removeEventListener(type:String, listener:Function, useCapture:Boolean = false):void 
		{
			dispatcher.removeEventListener( type , listener , useCapture );
		}
		public function willTrigger(type:String):Boolean 
		{
			return dispatcher.willTrigger( type );
		}

	}
}