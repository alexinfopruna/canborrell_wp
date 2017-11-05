<?php 
header('Content-Type: text/html; charset=UTF-8');
header('Set-Cookie: fileDownload=true');

//define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
//define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
require_once("Gestor.php");
define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
 if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");


require_once("gestor_reserves.php");
$gestor=new gestor_reserves();  

require_once(ROOT . "RestrictionController.php");

if (!$gestor->valida_sessio())  die("Login...");


class Test extends gestor_reserves {
  
  public function __construct(){
    parent::__construct(DB_CONNECTION_FILE, 1);
  }
  
  public function run(){
    
  
$data = '2017-11-18';
$coberts = 3;
$nens = 0;
$cotxets = 0;
$accesible = 0;
$data = '2017-11-22';



    $rc = new RestrictionController();
    
    
    
    
        $mydata = $this->cambiaf_a_mysql($data);

    $this->taulesDisponibles->tableHores = "estat_hores";   //ANULAT GESTOR HORES FORM. Tot es gestiona igual, des d'estat hores


    $this->taulesDisponibles->data = $mydata;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->accesible = $accesible;
    $this->taulesDisponibles->tableHores = "estat_hores";  //ANULAT GESTOR HORES FORM. Toto es gestiona igual, des de estat hores

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;
    $cacheNens = $nens;
    $cacheAdults = $coberts - $nens;


    $rc = new RestrictionController();
   // $this->taulesDisponibles->rang_hores_nens = $rc->getHores($mydata, $cacheAdults, $cacheNens, $cotxets);
   // $rules = $rc->getActiveRules($mydata, $cacheAdults, $cacheNens, $cotxets);
    
    //RestriccionsTaules ALEX
    //TORN1
    $this->taulesDisponibles->torn = 1;
    $dinar = $this->taulesDisponibles->recupera_hores();
    $taules = $this->taulesDisponibles->taulesDisponibles();
    
   $hores_taula=array();
    
foreach($taules as $k => $v){
  $hores = $rc->getHoresTaula($mydata, $v->id);//$rc->
  $hores_taula = array_merge($hores_taula, $hores);
  
  

  
  echo $v->nom." --- ";
  foreach($hores as $k => $v) echo " $v  / ";
  echo "<br>";
}

$hores_taula = array_unique($hores_taula);
$hores_taula = array_diff( $hores_taula, ['99:99'] );
 sort($hores_taula);

 echo "<br>----------------------------------<br>";
foreach($hores_taula as $k => $v) echo " $v  / ";

    $this->taulesDisponibles->rang_hores_taules = $hores_taula;//$rc->getHores($mydata, $cacheAdults, $cacheNens, $cotxets);
  }
}
  
  
  $t=new test();
  $t->run();
?>
<html xmlns="//www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MenjadorEditor</title>
<link type="text/css" href="css/print.css" rel="stylesheet" />			
		<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
<script>

</script>

<style>

</style>
</head>
<body bgcolor="#ffffff">

</body>
</html>
