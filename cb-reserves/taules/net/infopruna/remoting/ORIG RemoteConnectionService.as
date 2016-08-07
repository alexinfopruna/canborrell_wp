		package net.infopruna.remoting
		{
			import net.infopruna.remoting.RemoteConnectionServiceEvent;

			import flash.events.NetStatusEvent;
			import flash.net.NetConnection;
			import flash.net.Responder;
			import flash.net.ObjectEncoding;

			import flash.net.registerClassAlias;
			
			public class RemoteConnectionService extends NetConnection
			{
				public var handleReady:Boolean							= true;

				public var data:Object;
				public var gatewayURL:String;
				public var responder:Responder;

				private var loadedEvent:String;
				private var readyEvent:String;
				private var faultEvent:String;

				public function RemoteConnectionService(gatewayURL:String, loadedEvent:String='', readyEvent:String='', faultEvent:String='', encoding:uint=ObjectEncoding.AMF3)
				{
					this.gatewayURL = gatewayURL;
					this.loadedEvent = loadedEvent;
					this.readyEvent = readyEvent;
					this.faultEvent = faultEvent;

					objectEncoding = encoding;

					if ( gatewayURL )
					{
						responder = new Responder( handleResponseResult, handleResponseFault );

						addEventListener( NetStatusEvent.NET_STATUS, handleNetEvent );

						connect( gatewayURL );
					}
				}

				protected function send(method:String, ... args):void
				{
					call.apply( null, [ method, responder ].concat( args ) );
				}

				private function handleNetEvent(e:NetStatusEvent):void
				{
					dispatchEvent( new RemoteConnectionServiceEvent( faultEvent, e.info.code ) );
				}

				private function handleResponseResult(data:Object):void
				{
					dispatchEvent( new RemoteConnectionServiceEvent( loadedEvent, data ) ); 

					if ( handleReady )
					{
						handleLoaderDataReady( data );
					}
				}

				protected function handleLoaderDataReady(data:Object):void
				{
					this.data = data;

					dispatchEvent( new RemoteConnectionServiceEvent( readyEvent, data ) );
				}

				private function handleResponseFault(data:Object):void
				{
					dispatchEvent( new RemoteConnectionServiceEvent( faultEvent, data ) );
				}
				
				
				
				public static function registra(ruta:String, c:Class):void 
				{
					//registerClassAlias("com.canBorrell.PersonVO",PersonVO) ;	
					registerClassAlias(ruta,c) ;	
						
				}
			}
		}
	