package net.infopruna.carregador
{
	import flash.display.MovieClip;

	
	public class Percentero_barra extends Percentero implements IPercentero
	{
		
		public function Percentero_barra()
		{
			percent=0;			
		}
		
		override public function set percent(pc:Number):void
		{
			//Modifica el gràfic per marcar el percentatge
			//trace("set percent barra "+pc);
			barra.scaleX=pc;					
		}	
	}
}