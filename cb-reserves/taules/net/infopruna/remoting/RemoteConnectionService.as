		package net.infopruna.remoting
		{

			import fl.motion.FunctionEase;
			import flash.events.Event;
//			import flash.events.NetStatusEvent;
			import flash.net.NetConnection;
			import flash.net.Responder;
			import flash.net.ObjectEncoding;

			import flash.net.registerClassAlias;
			
			public class RemoteConnectionService extends NetConnection
			{
				public var gatewayURL:String;
				public var responder:Responder;
				

				public static const readyEvent:String="AMF_READY";
				public static const faultEvent:String="AMF_ERROR";

				private var fReady:Function;
				private var fError:Function;
				
				
				
				public function RemoteConnectionService(gatewayURL:String)
				{
					this.gatewayURL = gatewayURL;

					objectEncoding = ObjectEncoding.AMF3;

					if ( gatewayURL )
					{
						responder = new Responder( defaultHandleResponseResult, defaultHandleResponseFault );
						connect( gatewayURL );
					}
				}
				
				private function defaultHandleResponseResult():void
				{
					dispatchEvent( new Event( faultEvent ) );
					trace("defaultHandleResponseResult");
				}
				
				public function respostaListeners(handleResponseResult:Function, handleResponseFault:Function=null)
				{
						handleResponseFault = handleResponseFault!=null? handleResponseFault:defaultHandleResponseFault;
					
						responder = new Responder( handleResponseResult, handleResponseFault );
					
				}

				protected function send(method:String, ... args):void
				{
						//responder = new Responder( handleResponseResult, handleResponseFault );
					call.apply( null, [ method, responder ].concat( args ) );
				}


				private function defaultHandleResponseFault(data:Object):void
				{
					dispatchEvent( new Event( faultEvent ) );
					trace("defaultHandleResponseFault");
				}
				
				public function setEncoding(encode:uint)
				{
					objectEncoding = encode;					
				}
				
				public static function registra(ruta:String, c:Class):void 
				{
					registerClassAlias(ruta,c) ;	
						
				}
			}
		}
	