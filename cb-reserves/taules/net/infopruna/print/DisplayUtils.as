package net.infopruna.print
{
import flash.display.BitmapData;
import flash.display.Graphics;
import flash.display.Sprite;
import flash.events.Event;
import flash.events.IOErrorEvent;
import flash.external.ExternalInterface;
import flash.geom.Rectangle;
import flash.net.URLLoader;
import flash.net.URLRequest;
import flash.net.URLRequestMethod;
import flash.net.URLVariables;
import flash.net.sendToURL;
//Importo la clase PNGEncoder, que se va a encargar de codificar el Bitmap a PNG
import com.adobe.images.PNGEncoder;
//Importo la clase Base64, que va a pasar el ByteArray creado por PNGEncoder a un 
//código BASE64 que posteriormente interpretará el PHP
import com.dynamicflash.util.Base64;


	import flash.display.DisplayObject;	
	
	public class DisplayUtils	
	{
		public function DisplayUtils()
		{
			
		}
		
	
			///////////////////////////////////////////////////////////////////////
			//FUNCIONES
		public static function salvaDisplay(dob:DisplayObject,w:Number,h:Number,url:String="guardar.php",resposta:Function=null):void 
		{
			///////////////////////////////////////////////////////////////////////
			//VARIABLES

			//Url del archivo PHP que va a codificar la imagen
			//var url:String = "http://www.esedeerre.com/ejemplos/as3/guardarfoto/guardar.php"
			var codificador:PNGEncoder;


				trace( "Codificando imagen para su envio...");
				
				//Creo los contenedores para enviar datos y recibir respuesta
				var enviar:URLRequest = new URLRequest(url);
				var recibir:URLLoader = new URLLoader();
				
				//Creo el Bitmap que voy a convertir
				var bmd:BitmapData = new BitmapData(w,h);
				bmd.draw(dob);
				var area:Rectangle = new Rectangle(0, 0, bmd.width, bmd.height);

				
				//Creo la variable que va a ir dentro de enviar, con los campos que tiene que recibir el PHP.
				var variables:URLVariables = new URLVariables();
				
				//Creo el campo imgen, pasando primero el bitmap a un bytearray, y después codificandolo a Base64
				variables.imagen = Base64.encodeByteArray(PNGEncoder.encode(bmd));
				
				//Indico el método por el que se va a enviar la información.
				enviar.method = URLRequestMethod.POST;
				//Indico que voy a enviar variables dentro de la petición
				enviar.data = variables;
				
				//Añado listeners a recibir, para un posible error y una respuesta.
				recibir.addEventListener(Event.COMPLETE,Respuesta);
				recibir.addEventListener(IOErrorEvent.IO_ERROR,HayError);
				
				//Hago la petición al PHP
				recibir.load(enviar);
				trace( "Esperando conversión del archivo...");
				
				
				
				//Funcion que se ejecuta al recibir una respuesta del PHP
				function Respuesta(event:Event){
						trace(event.target.data);
						trace(" Tu imagen se ha guardado en: \n\n" + event.target.data);
						if (resposta!=null) resposta();

				}
				
				
				
				
				//Función que se ejectuta cuando no se puede cargar el PHP
				function HayError(event:IOErrorEvent):void {
						trace("Error al cargar la url");
				}
		}
	}
}

