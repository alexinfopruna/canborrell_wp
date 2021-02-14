<?php 


if (!defined('ROOT')) define('ROOT', "../taules/");
//require_once(ROOT."Gestor.php");
require_once(ROOT."gestor_reserves.php");

class Gestor_grups extends gestor_reserves {
  public function get_email($idmail){
    $query = "SELECT * FROM email WHERE email_id = $idmail";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //if ($this->total_rows = mysqli_num_rows($this->qry_result))      return $this->last_row = mysqli_fetch_assoc($this->qry_result);
    if ($this->total_rows = mysqli_num_rows($this->qry_result))      $this->last_row = mysqli_fetch_assoc($this->qry_result);
    
    $time = $this->last_row['email_timestamp'];
    $to = $this->last_row['email_recipients'];
    $subject = $this->last_row['email_subject'];
    $body = base64_decode($this->last_row['email_body']);
    $result = $this->last_row['email_resultat'];
    $categoria = $this->last_row['email_categoria'];
    $idr = $this->last_row['reserva_id'];
    
    $return = array('time' => $time, 'idr' => $idr, 'categoria' => $categoria, 'to' => $to, 'subject' => $subject, 'body' =>  $body, 'result' => $result);
    return $return;
  }
  
   public function get_html_email($idmail){
     $mail = $this->get_email($idmail);
     $time = $this->cambiaf_a_normal($mail['time']);
     $to = $mail['to'];
     $subject = $mail['subject'];
     $body = $mail['body'];
     $result = $mail['result'];
    
     $class=$result?'glyphicon-ok-sign':'glyphicon-remove-sign';
     $class2=$result?'alert-success':'alert-danger';
     $text=$result?'ok':'ERROR!!';  
    $header =  '<div class="modal-footer  '. ($result?'btn-success':'btn-danger').'"> <h5 class="alert '.$class2.'">Enviat el: '.$time.' &#10147; '.$text.' <span class="glyphicon '.$class.'"></span> </h5>';
    $header .=  '<a href="mailto:'.$to.'" class="email_recipients" target="_blank">'.$to.'</a>';
    $header .=  '<div  class="email_subject">'.$subject.'</div></div>';
    
    $modal_body =  '<div class="email_body">'.$body.'</div><span us-spinner="{radius:30, width:8, length: 16}"></span>';
    
    $footer = '       <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
            <button class="btn btn-success" type="button" ng-click="reenvia('.$idmail.')"><span class="glyphicon glyphicon-repeat"></span> Reenviar</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>';
    
   
    return $header. $modal_body. $footer;
   
   }
  

  public function llista_emails_reserva($idr){
    $query = "SELECT email_id, email_timestamp, email_recipients, email_categoria, email_resultat FROM email WHERE email.reserva_id = $idr";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//$result = $stmt->fetchAll( PDO::FETCH_ASSOC );
while( $row = mysqli_fetch_assoc($this->qry_result)){
  $row['email_id'] = intval($row['email_id']);
  
  if ($row['email_categoria']) $result['confirmada'] = true;
  $row['email_restaurant'] = ($row['email_recipients'] == MAIL_RESTAURANT);
  //$row['email_restaurant'] = true;
  $row['email_resultat'] = intval($row['email_resultat']);
  $result['rows'][] = $row;
}

$rt = json_encode($result);
return $rt;
  }
  
   
   
  public function resend_email($idmail){
     $mail = $this->get_email($idmail);
     
     $to = $mail['to'];
     $subject = $mail['subject'];
     $body = $mail['body'];
     $categoria = $mail['categoria'];
     $idr = $mail['idr'];
     
    
    
    require_once(ROOT.'../editar/mailer.php');
    $r=FALSE;
    $r = mailer_reserva($idr, $categoria, $to, $subject, $body, null);
    $resposta['resultat'] = $r;
    return json_encode($resposta);
  }
} // CLASS



/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/*********** AJAX**************/
/*********** AJAX**************/
/*********** AJAX**************/
/*********** AJAX**************/
if (isset($_REQUEST['a']))  $accio = $_REQUEST['a'];
$_REQUEST['a'] = null;

if (isset($accio) && !empty($accio)) {
  if (!isset($_REQUEST['b']))
    $_REQUEST['b'] = null;
  if (!isset($_REQUEST['c']))
    $_REQUEST['c'] = null;
  if (!isset($_REQUEST['d']))
    $_REQUEST['d'] = null;
  if (!isset($_REQUEST['e']))
    $_REQUEST['e'] = null;
  if (!isset($_REQUEST['f']))
    $_REQUEST['f'] = null;
  if (!isset($_REQUEST['g']))
    $_REQUEST['g'] = null;
  if (!isset($_REQUEST['p']))
    $_REQUEST['p'] = null;
  if (!isset($_REQUEST['q']))
    $_REQUEST['q'] = null;
  if (!isset($_REQUEST['r']))
    $_REQUEST['r'] = null;

  $gestor = new Gestor_grups(1);

  if (method_exists($gestor, $accio)) {

    $logables = array('cancelReserva', 'insertUpdateClient', 'salvaUpdate', 'submit', 'update_client', 'esborra_client', 'inserta_reserva', 'update_reserva', 'esborra_reserva', 'enviaSMS', 'permuta', 'permuta_reserva', '', '', '', '', '', '', '', '', '', '', '');
    $log = in_array($accio, $logables);
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $sessuser = $_SESSION['uSer'];

    if (isset($sessuser))
      $user = $sessuser->id;

    if ($log) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
      $gestor->xgreg_log("Petició Gestor FORM: " . $accio . "  user:$user ($ip) (b=" . $_REQUEST['b'] . ", c=" . $_REQUEST['c'] . ", d=" . $_REQUEST['d'] . " ---- p=" . $_REQUEST['p'] . ", q=" . $_REQUEST['q'] . ", r=" . $_REQUEST['r'] . ", c=" . $_REQUEST['c'] . ", d=" . $_REQUEST['d'] . ", e=" . $_REQUEST['e'] . ") > " . $req . EOL, 1);
    }

    $respostes = array('respostaTPV', 'respostaTPV_SHA256');
    if (!$gestor->valida_sessio(1) && !in_array($accio, $respostes)) {
      echo "err100";
      die();
    }
    $gestor->out(call_user_func(array($gestor, $accio), $_REQUEST['b'], $_REQUEST['c'], $_REQUEST['d'], $_REQUEST['e'], $_REQUEST['f'], $_REQUEST['g']));
  }else{
    echo "$accio action not kown ";
  }
}
