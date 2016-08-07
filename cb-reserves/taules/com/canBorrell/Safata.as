package com.canBorrell 
{
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.text.TextField;
	
	/**
	 * ...
	 * @author alex
	 */
	public class Safata extends Taula
	{
		
		public function Safata(clip:Sprite, tnom:String, info:InfoTaula, preserva:Reserva = null) 
		{
			super(clip, tnom, info, preserva);
			this.persones = 0;
			this.cotxets = 0;
			
			trace(clip.numChildren);
			/*			*/	

			for (var i=0; i < clip.numChildren; i++)
				clip.getChildAt(i).visible = false;
			clip.getChildByName("safata").visible = true;
			clip.getChildByName("lin2").visible = true;
			//TextField(clip.getChildByName("lin2")).text = "";
			
			
		}
		
		public override function  mostraInfo(e:Event=null)
		{
			if (this.reserva) _infoTaula.mostraInfo(this);
		}		
		
		public override function updateLabel():void
		{
			super.updateLabel();
			clip.getChildByName("txt").visible = true;
			if (this.reserva) TextField(clip.getChildByName("txt")).text = this.reserva.client.nom +  this.reserva.client.cognom;
			else 
			{
				TextField(clip.getChildByName("txt")).text = "";
				clip.getChildByName("txt").visible = false;
			}
		}
		
		
		
	}

}