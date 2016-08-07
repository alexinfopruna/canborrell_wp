  package net.infopruna.remoting
		{
			import flash.events.Event;

			public class RemoteConnectionServiceEvent extends Event
			{
				public static const NAME:String							= 'RemoteConnectionServiceEvent';

				public static const LOADED:String						= NAME + 'Loaded';
				public static const READY:String						= NAME + 'Ready';
				public static const FAULT:String						= NAME + 'Fault';

				public var data:Object;

				public function RemoteConnectionServiceEvent(type:String, data:Object=null, bubbles:Boolean=true, cancelable:Boolean=false)
				{
					super( type, bubbles, cancelable );

					this.data = data;
				}
			}
		}
	