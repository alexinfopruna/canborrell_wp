  package net.infopruna.remoting
		{
			import net.infopruna.remoting.RemoteConnectionServiceEvent;

			import flash.net.ObjectEncoding;

			public class AMFPHPService extends RemoteConnectionService
			{
				public function AMFPHPService( url:String )
				{
					super( url, RemoteConnectionServiceEvent.LOADED, RemoteConnectionServiceEvent.READY, RemoteConnectionServiceEvent.FAULT, ObjectEncoding.AMF3 );
				}
			}
		}