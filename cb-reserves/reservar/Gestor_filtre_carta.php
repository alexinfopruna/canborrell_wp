<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once (ROOT."Gestor.php");
require_once("Gestor_form.php");



class Gestor_filtre_carta extends Gestor_form
{
  /**********************************************************************************************************/
  public function __construct($usuari_minim=1)
  {
    parent::__construct(DB_CONNECTION_FILE,$usuari_minim);
  }





  public function recuperaCarta($idr=0,$es_menu=false)
  {
    $lng= $this->lng;
    $llista="";
    $class="";
    //CONTROL DIES NOMES CARTA


    if ($es_menu) $were=' carta_plats.carta_plats_subfamilia_id=20 ';
    else $were=' carta_plats.carta_plats_subfamilia_id<>20 ';

    $query="select `carta_plats_id`,`carta_plats_nom_es`,`carta_plats_nom_ca`,`carta_plats_nom_en`,`carta_plats_preu`,carta_subfamilia.carta_subfamilia_id AS subfamilia_id,`carta_subfamilia_nom_$lng`, comanda_client.comanda_plat_quantitat, carta_publicat
    FROM carta_plats
    LEFT JOIN carta_publicat ON carta_plats_id=carta_publicat_plat_id
    LEFT JOIN carta_subfamilia ON carta_subfamilia.carta_subfamilia_id=carta_plats_subfamilia_id
    LEFT JOIN comanda as comanda_client ON carta_plats_id=comanda_plat_id AND comanda_reserva_id='$idr'
		LEFT JOIN carta_subfamilia_order ON carta_subfamilia.carta_subfamilia_id=carta_subfamilia_order.carta_subfamilia_id

    WHERE $were
	  ORDER BY carta_subfamilia_order,carta_plats_nom_es , carta_plats_nom_ca";
    //ORDER BY (carta_subfamilia_id=2),carta_subfamilia_id";
    //echo $query;

    $Result1 = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = mysqli_fetch_array($Result1))
    {
      if (empty($row['carta_plats_nom_ca'])) $row['carta_plats_nom_ca']=$row['carta_plats_nom_es'];
      if (empty($row['carta_plats_nom_en'])) $row['carta_plats_nom_en']=$row['carta_plats_nom_es'];
      
      $row['carta_plats_nom_'.$lng]= ucfirst(mb_strtolower($row['carta_plats_nom_'.$lng]));
      $plat=array('id'=>$row['carta_plats_id'],'nom'=>$row['carta_plats_nom_'.$lng],'preu'=>$row['carta_plats_preu'],'quantitat'=>$row['comanda_plat_quantitat'],'publicat'=>$row['carta_publicat']);
    //  $plat=array('id'=>$row['carta_plats_id'],'nom'=>$row['carta_plats_id'] ." - ".$row['carta_plats_nom_'.$lng],'preu'=>$row['carta_plats_preu'],'quantitat'=>$row['comanda_plat_quantitat'],'publicat'=>$row['carta_publicat']);
      $arCarta[$row['carta_subfamilia_nom_'.$lng]][]=   $plat;
    }

    /**********************************************************************************************************/

    $obreLlista='<ul id="carta-seccions" class="'.$class.'">'.PHP_EOL;
//print "<pre>";
//print_r($arCarta);
//print "</pre>";
    
    
    foreach ($arCarta as $key => $val)
    {
      $k=$this->normalitzar($key);
      $k=str_replace('*', '', $k);
      $k=str_replace('/', '', $k);
      $llista.='<li><a href="#carta_'.$k.'">'.$key.'</a></li>'.PHP_EOL;
    }
    $tancaLlista='</ul>'.PHP_EOL;
    $carta=$obreLlista.$llista.$tancaLlista;

    $class=$es_menu?"cmenu":"ccarta";
    foreach ($arCarta as $key => $val)
    {
      $k=$this->normalitzar($key);
      $k=str_replace('*', '', $k);
      $k=str_replace('/', '', $k);
      $obreSeccio='<div id="carta_'.$k.'" class="'.$class.'">'.PHP_EOL;
      //$seccio='<a  href="#" class="all bt">Seleccionar / Deseleccionar todo</a>';
      $seccio=$this->seccioCarta($arCarta,$key, $class);
      $tancaSeccio='</div>'.PHP_EOL.PHP_EOL;
       
      $carta.=$obreSeccio.PHP_EOL.$seccio.PHP_EOL.$tancaSeccio;
    }

    //print_r($arCarta);
    return $carta;

  }

  /**********************************************************************************************************/
  public function  seccioCarta($ar,$k, $class="")
  {
    $publicat="";
    $c=0;
    $l=0;
    $tr="";
    $obreTaula='<table id="c1" class="col_dere">'.PHP_EOL;
     
    foreach ($ar[$k] as $key => $val)
    {
      $menuEspecial=$this->menuEspecial($val['id'])?" menu-especial":"";
      if (!calsoton && ($val['id']==2010 || $val['nom']=="MENU CALÇOTADA" || $val['nom']=="MENÚ CALÇOTADA")) continue;
      $l++;
       
      if ($val['quantitat']) $value=' value="'.$val['quantitat'].'" ';
      else $value="0";
       
      /**  IVA  **/
      //$val['preu']*=IVA/100;
      $preu=round($val['preu']+$val['preu']*IVA/100,2);
      $preu=number_format($preu,2,'.','');
       
      $odd=($l%2)?"odd":"pair";
      $checked=$val['publicat']?'checked="checked"':'';
      $tr.='<tr producte_id="'.$val['id'].'" class="item-carta '.$odd.$menuEspecial.'">
          <td class="borra" style="display:none"></td>
          <td>
          '.$publicat.'
          <input id="carta_check'.$val['id'].'" cpid="'.$val['id'].'" type="checkbox" name="carta_cjeck'.$c++.'" class="contador '.$class.'" '.$value.' preu="'.$preu.'" nom="'.$val['nom'].'" '.$checked.'/></td>
              <td class="resum-carta-nom" href="/cb-reserves/reservar/Gestor_form.php?a=TTmenu&b='.$val['id'].'">'.$val['nom'].'</td>
                  <td class="td-carta-preu"><span class="carta-preu">'.$preu.'</span>&euro; </td>
                      <!--<td class="carta-subtotal"><em>(subtotal: <span class="carta-preu-subtotal">0</span>&euro; )</em></td></tr>-->'.PHP_EOL;
    }

    $tancaTaula='
        <tr><td></td><td></td><td>IVA incl.</td><td></td></tr>
        </table>'.PHP_EOL.PHP_EOL;

    return $obreTaula.$tr.$tancaTaula;
  }

  private function menuEspecial($id)
  {
    return ($id==2001 || $id==2003);
  }
  
  public function check_plat($cpid,$valor){
    if ($_SESSION['permisos']<16) return "error:sin permisos";
    if (!$cpid) return "falta cpid";
    
    //ALTER TABLE  `carta_plats` ADD  `carta_plats_publicat` BOOL NOT NULL DEFAULT  '0' AFTER  `carta_plats_preu`
    /*
UPDATE carta_plats 
LEFT JOIN `comanda` ON comanda_plat_id=carta_plats_id

SET carta_plats_publicat=comanda_plat_quantitat

WHERE comanda_reserva_id=0 
     */
    $valor = ($valor == 'true');
    $publicat = ($valor)?"TRUE":"FALSE";
    $query = "REPLACE carta_publicat SET carta_publicat=$publicat, carta_publicat_plat_id=".$cpid;
    $this->qry_result = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $query = "UPDATE comanda 
        SET comanda_plat_quantitat=$publicat  
        WHERE comanda_reserva_id=0 
        AND comanda_plat_id=".$cpid;
    $this->qry_result = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    

    return $publicat;  
    
  }
  
/*************************************************************************************************************************************/  
/*************************************************************************************************************************************/  
/**************************   ORDRE   **********************************************************************************/  
/*************************************************************************************************************************************/  
  public function recuperaSorter($idr=0,$es_menu=false)
  {
    $lng= $this->lng;
    $llista="";
    $class="";
    //CONTROL DIES NOMES CARTA


    if ($es_menu) $were=' carta_plats.carta_plats_subfamilia_id=20 ';
    else $were=' carta_plats.carta_plats_subfamilia_id<>20 ';
/*
    $query="SELECT carta_subfamilia.carta_subfamilia_id, carta_subfamilia_nom_es
	FROM carta_subfamilia
	LEFT JOIN carta_subfamilia_order ON carta_subfamilia_order.carta_subfamilia_id=carta_subfamilia.carta_subfamilia_id
	ORDER BY carta_subfamilia_order";
*/
$query="SELECT DISTINCT carta_subfamilia.carta_subfamilia_id, carta_subfamilia_nom_es
FROM carta_subfamilia
LEFT JOIN carta_subfamilia_order ON carta_subfamilia_order.carta_subfamilia_id = carta_subfamilia.carta_subfamilia_id
INNER JOIN carta_plats ON carta_subfamilia_order.carta_subfamilia_id = carta_plats.carta_plats_subfamilia_id
INNER JOIN carta_publicat ON carta_plats.carta_plats_id = carta_publicat.carta_publicat_plat_id
WHERE carta_publicat > 0 AND carta_plats.carta_plats_subfamilia_id<>20
ORDER BY carta_subfamilia_order";
    $Result1 = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    while ($row = mysqli_fetch_array($Result1))	  
	{
		$llista.='<li id="order_'.$row['carta_subfamilia_id'].'" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$row['carta_subfamilia_nom_es'].'</li>';
	}

    $obreLlista='Ordena els elements arrossegant-los amb el mouse<br/><br/><ul id="sortable" class="'.$class.'">'.PHP_EOL;
    $tancaLlista='</ul>'.PHP_EOL;
    $carta=$obreLlista.$llista.$tancaLlista;
    return $carta;
  }



  public function subfamilia_sorter($serial)
  {
	foreach ($_GET['order'] as $position => $item)
	{
		$query=$sql[] = "UPDATE carta_subfamilia_order SET carta_subfamilia_order = $position WHERE carta_subfamilia_id = $item"; 
		$Result1 = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	}  
	
	print_r ($sql); 
  }
  
  
}

if(isset($accio)) {
  
  $gestor=new Gestor_filtre_carta();
  if (method_exists($gestor,$accio)){
    $gestor->out(call_user_func(array($gestor, $accio),$_REQUEST['b'],$_REQUEST['c'],$_REQUEST['d'],$_REQUEST['e'],$_REQUEST['f'],$_REQUEST['g']));
  }
  else{
    print "deso noai";
  }
}
  ?>