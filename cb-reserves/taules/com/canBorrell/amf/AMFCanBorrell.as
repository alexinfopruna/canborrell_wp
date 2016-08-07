package com.canBorrell.amf 
{
	import com.canBorrell.InfoTaula;
	import com.canBorrell.MenjadorEditor;
	import com.canBorrell.Taula;
	import net.infopruna.remoting.RemoteConnectionService;
	import net.infopruna.remoting.RemoteConnectionServiceEvent;
	import flash.net.ObjectEncoding;
	
	/**********************************************/
	/** 
	 * CLASSES VO
	 */
	import com.canBorrell.amf.vo.EstatTaulesVO;
	import com.canBorrell.amf.vo.UsuariVO;
	import com.canBorrell.amf.vo.TaulaVO;
	/**********************************************/

			public class AMFCanBorrell extends RemoteConnectionService
			{
				public function AMFCanBorrell( url:String )
				{
					/*******************************************************************************/
					/** 
					 * REGISTRA CLASSES VO
					 */
					RemoteConnectionService.registra("com.canBorrell.UsuariVO", UsuariVO);
					RemoteConnectionService.registra("com.canBorrell.EstatTaulesVO", EstatTaulesVO);
					//RemoteConnectionService.registra("com.canBorrell.TaulaVO", TaulaVO);
					/********************************************************************************/
					
					super( url );					
				}
			
			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
/*********************      METODES DEL SERVEI                                    ********************************/			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
					
			
			public function recuperaUsuari() {
				
				trace("AMF recuperant usuari ")
				super.send("ControlTaules.recuperaUsuari");
			}
/****************************************************************************************************************/			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
			/**
			 * recupera estat 
			 *
			 */
			public function recuperaEstat(data:Date,torn:uint) {
				
				
				//data.setHours(MenjadorEditor.TORNS[torn].substr(0, 2),MenjadorEditor.TORNS[torn].substr(3, 2))
				var strData = InfoTaula.ObtenerFechaHora(data,1);
				trace("load ",strData)
				super.send("ControlTaules.recuperaEstat",strData,torn);
			}

/****************************************************************************************************************/			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
			
			public function guardaEstat(data:Date,torn:uint,taules:Array ) {
				
				//data.setHours(MenjadorEditor.TORNS[torn].substr(0, 2),MenjadorEditor.TORNS[torn].substr(3, 2))
				var strData = InfoTaula.ObtenerFechaHora(data);
				trace("save ",strData)
				super.send("ControlTaules.guardaEstat",strData,torn,taules);
			}
/****************************************************************************************************************/			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
			 
			/**
			 * recupera estat callback
			 *
			 */
			public function recuperaEstatMenjador(data:Date,torn:uint) {
				
				//data.setHours(MenjadorEditor.TORNS[torn].substr(0, 2),MenjadorEditor.TORNS[torn].substr(3, 2))
				var strData = InfoTaula.ObtenerFechaHora(data,1);
				trace("load MENJ ",strData)
				
				super.send("ControlTaules.recuperaEstatMenjador",strData,torn);
			}
/****************************************************************************************************************/			
/****************************************************************************************************************/			
/****************************************************************************************************************/			
			 
			/**
			 * recupera estat callback
			 *
			 */
			public function guardaEstatMenjador(data:Date,torn:uint,menjador:uint,actiu:Boolean) {
				
				//data.setHours(MenjadorEditor.TORNS[torn].substr(0, 2),MenjadorEditor.TORNS[torn].substr(3, 2))
				var strData = InfoTaula.ObtenerFechaHora(data,1);
				trace("save MENJ ",strData)
				
				super.send("ControlTaules.guardaEstatMenjador",strData,torn,menjador,actiu);
			}
			
	}
}