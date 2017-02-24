<?php
function out($t)
{
	Gestor::out($t);
}

if (isset($_REQUEST['a']) && !empty($_REQUEST['a']))
{
	$gestor=new gestor_reserves();
    if (!$gestor->valida_sessio(1))  header("Location: index.php");

	$logables=array('update_client','esborra_client','inserta_reserva','update_reserva','esborra_reserva','enviaSMS','permuta','permuta_reserva');
	$log=in_array($_REQUEST['a'], $logables);
		
	$ip=isset($ips[$_SERVER['REMOTE_ADDR']])?$ips[$_SERVER['REMOTE_ADDR']]:$_SERVER['REMOTE_ADDR'];
	$sessuser=$_SESSION['uSer'];
		if (isset($sessuser)) $user=$sessuser->id;
                
                $a=isset($_REQUEST['a'])?$_REQUEST['a']:'';
                $b=isset($_REQUEST['b'])?$_REQUEST['b']:'';
                $c=isset($_REQUEST['c'])?$_REQUEST['c']:'';
                $d=isset($_REQUEST['d'])?$_REQUEST['d']:'';
                $e=isset($_REQUEST['e'])?$_REQUEST['e']:'';
                $f=isset($_REQUEST['f'])?$_REQUEST['f']:'';
                $g=isset($_REQUEST['g'])?$_REQUEST['g']:'';
                $p=isset($_REQUEST['p'])?$_REQUEST['p']:'';
                $q=isset($_REQUEST['q'])?$_REQUEST['q']:'';
                $r=isset($_REQUEST['r'])?$_REQUEST['r']:'';
                $term=isset($_REQUEST['term'])?$_REQUEST['term']:'';
                
		if ($log)	$gestor->reg_log("<span class='ajax'>AJAX >> $a</span>:  user: $user ($ip) (b=".$b.", c=".$c.", d=".$d." ---- p=".$p.", q=".$q.", r=".$r.", c=".$c.", d=".$d.", e=".$e.")<<< */".EOL);
	
	switch ($accio=$a)
	{
		case "accordion_clients":
			out( $gestor->accordion_clients($p));
			$gestor->refresh(true);
		break;	
		
		case "combo_clients":
			out( $gestor->combo_clients($p));
		break;	
		
		case "htmlDadesClient":
			out( $gestor->htmlDadesClient($p));
		break;
		
		case "inserta_client":
			out( $gestor->inserta_client());
			$gestor->refresh(true);
		break;
		
		case "load_client":
			out( $gestor->load_client($p,$q));
		break;
		
		case "update_client":
			out( $gestor->update_client());
			$gestor->refresh(true);
		break;	
		
		case "esborra_client":
			out( $gestor->esborra_client($p));
			$gestor->refresh(true);
		break;	
		
		case "inserta_reserva":
			out( $gestor->inserta_reserva());
			$gestor->refresh(true);
		break;
		
		case "update_reserva":
			out( $gestor->update_reserva());
			$gestor->refresh(true);
		break;	
		
		case "esborra_reserva":
			out( $gestor->esborra_reserva($p,$q));
			$gestor->refresh(true);
		break;	
		
		case "accordion_reserves":
			out( ($gestor->accordion_reserves($q)));
			$gestor->refresh(true);
		break;	
		
		case "canvi_data":
			out( $gestor->canvi_data($p,$q));
			$gestor->refresh(true);
		break;	
		
		case "canvi_modo":
			out( $gestor->canvi_modo($p));
		break;	
		
		case "recupera_hores":
			out( $gestor->recupera_hores($c,$d,$e));
		break;	
		
		case "total_coberts_torn":
			out( $gestor->total_coberts_torn($p,$c));
		break;	
		
		case "canvi_torn":
			out( $gestor->canvi_torn($p));
		break;	
		
		case "cerca_reserves":
			out( $gestor->accordion_reserves($p,$c));
		break;	
		
		case "cerca_clients":
			out( $gestor->accordion_clients($p,$c));
		break;	
		
		case "clientHistoric":
			out( $gestor->clientHistoric($p));
		break;	
		
		case "valida_reserva":
			out( $gestor->valida_reserva($p));
		break;	
		
		case "cerca_taula":
			out( $gestor->cerca_taula($p,$q,$r));
		break;	
		
		case "recupera_torn":
			out( $gestor->recupera_torn($p,$q,$r));
		break;	
		

		case "insert_id":
			out( $gestor->insert_id());
		break;

		case "refresh":
			out( $gestor->refresh());
		break;

		case "edita_hores":
			echo( $gestor->edita_hores($p,$q));
		break;

		case "update_hora":
			out( $gestor->update_hora($p,$c,$d,$e,$f,$g));
		break;

		case "guarda_missatge_dia":
			out( $gestor->guarda_missatge_dia($p,$c));
		break;
		
		case "recupera_missatge_dia":
			out( $gestor->recupera_missatge_dia($p,$c));
		break;

		case "enviaSMS":
			out( $gestor->enviaSMS($p,$c));
		break;

		case "llistaSMS":
			out( $gestor->llistaSMS($p));
		break;

		case "autocomplete_clients":
			out( $gestor->autocomplete_clients($term,$p));
		break;

		case "autocomplete_reserves":
			out( $gestor->autocomplete_reserves($term));
		break;

		case "permuta":
			out( $gestor->permuta($c,$d,$r));
			$gestor->refresh(true);
		break;

		case "permuta_reserva":
			out( $gestor->permuta_reserva($c,$d,$r));
			$gestor->refresh(true);
		break;

		case "plats_comanda":
			out( $gestor->plats_comanda($p));
		break;

		case "taula_bloquejada":
			out( $gestor->taula_bloquejada($p));
		break;

		case "bloqueig_taula":
			out( $gestor->bloqueig_taula($p,$_SESSION['data'],$_SESSION['torn'],$q));
		break;

		case "cambiaf_a_mysql":
			out( $gestor->cambiaf_a_mysql($p,$q));
		break;

		case "cambiaf_a_normal":
			out( $gestor->cambiaf_a_normal($p,$q));
		break;

		case "sql":
			out( $gestor->sql());
		break;

		case "test":
			out( "TEST (param P): ".$p);			
		break;

		
		
		case "tanca_sessio":
			out( $gestor->tanca_sessio());
			header("location: .");
		break;
		
		default:
                                                                                    if (method_exists($gestor, $accio)) 
			  $gestor->out(call_user_func(array($gestor, $accio),$b,$c,$d,$e,$f,$g));	
		break;
	}
}
?>