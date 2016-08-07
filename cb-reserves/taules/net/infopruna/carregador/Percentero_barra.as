package net.infopruna.carregador
{
	import flash.display.MovieClip;

	
	////////////////////////////////////////////
	////////////////////////////////////////////
	////////////////////////////////////////////
	public class Percentero_barra extends Percentero implements IPercentero
	{
		
		public function Percentero_barra(url:String=null)
		{
			if (url!=null) 
			{
				super(url);
				percent=0;			
			}
		}
		
		////////////////////////////////////////////
		////////////////////////////////////////////
		////////////////////////////////////////////
		override public function set percent(pc:Number):void
		{
			//Modifica el gràfic per marcar el percentatge
			if (carregat) _grafic.barra.scaleX=pc;		
			//if (carregat) _grafic.getChildByName("barra").scaleX=pc;
		}	
	}
}