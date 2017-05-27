<?php
header('Content-Type: text/html; charset=UTF-8');
if (!defined('EOL')) define ('EOL',"\r\n");
require_once("Gestor.php");
//$_REQUEST['s']="josep";

class Gestor_chef extends Gestor
{
	public function __construct($db_connection_file=DB_CONNECTION_FILE,$usuari_minim=16) 	
	{
		//die("gr:".$usuari_minim);
		parent::__construct($db_connection_file,$usuari_minim);
	}

	public function setLang($l)
	{
		parent::setLang($l);	
	}
	
	
		function llistatReserves($data,$cerca)
		{	
			if ($data) 
			{
				$data=$this->cambiaf_a_mysql($data);
				$filtre="WHERE data='$data' ";// AND client_id>0;	
			}

			//$order=" ORDER BY data DESC, hora DESC, data_creacio DESC";
			$order=" ORDER BY data , estat_taula_torn , sm, hora , client.client_cognoms, data_creacio ";
			$query = "SELECT 
						id_reserva,
						client_cognoms,
						client_nom,
						client_mobil,
						data,
						hora,
						estat_taula_nom,	
						adults,
						nens10_14,
						nens4_9,
						cotxets,
						observacions,
						(adults + nens10_14 + nens4_9) AS sm

			FROM ".T_RESERVES." 
					LEFT JOIN "."client ON ".T_RESERVES.".client_id=client.client_id
					LEFT JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva = ".ESTAT_TAULES.".reserva_id	
					
					$filtre
					$order
					";
				
				//echo $query=$query;
				$this->qry_result = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));		
				if (!$this->total_rows = mysqli_num_rows($this->qry_result)) return $html="";
				$cometa="\"";
				$html="";
				
				
				$l=$this->lng; //IDIOMA!!
				while ($row= $this->last_row = mysqli_fetch_assoc($this->qry_result))
				{
					$fila=implode(';',$row);
					$scerca=strtolower($this->normalitzar($cerca));
					
					
					$sfila="id".$row['id_reserva'].";t:".$row['client_mobil'].";c:".$row['client_cognoms'].";h:".$row['hora'].";n:".$row['client_nom'].$row['client_nom']." ".$row['client_cognoms'];
					//$sfila=strtolower($this->normalitzar(utf8_encode($sfila)));
					
					
					if (empty($cerca)) $html.="C;".$fila.";".EOL;
					elseif (strpos($sfila, $scerca) !== false) $html.="C;".$fila.";".EOL;
					else continue;
					
					$query_comanda="SELECT 1 as l, comanda_plat_id, carta_plats_nom_$l, comanda_plat_quantitat,  carta_subfamilia_nom_$l, '0' AS observacions
FROM comanda
LEFT JOIN carta_plats ON carta_plats_id = comanda_plat_id
LEFT JOIN carta_subfamilia ON carta_subfamilia_id = carta_plats_subfamilia_id
WHERE comanda_reserva_id =".$row['id_reserva'];

					$result = $this->log_mysql_query($query_comanda, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));		
					$i=0;
					while ($row2= mysqli_fetch_assoc($result))
					{
						$row2['l']=++$i;
						$fila2=implode(';',$row2);
						$html.="D;".$fila2.";".EOL;
					}
					
					
				}
				return $html;
		}
}

$gestor=new Gestor_chef();
$gestor->setLang("ca");

/*$capsalera("<?xml version='1.0' encoding='ISO-8859-1'?>")*/
//header('Content-Type: text/xml; charset=ISO-8859-1');
header('Content-Type: text/plain');

if ($_REQUEST['u']=='chef') echo $capsalera.$gestor->llistatReserves($_REQUEST['d'],$_REQUEST['s']);
else echo "Usuari no identificat";
?>