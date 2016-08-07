<?php
define("ROOT", "../taules/");
define("READER_SCRIPT", "read.php?f=");
require_once(ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();

if (!$gestor->valida_sessio(64)) {
  header("Location: login.php");
  die();
}
  
$file = $_GET['f'];
if (isset($_GET['reset'])){
  $gestor->rename_big_file($file, 0);
  $redir = 'read.php?'.$_SERVER['QUERY_STRING'];
  $redir = str_replace('&reset','',$redir);
  header("location: ".$redir);
  exit();
}
  
$path_parts = pathinfo($file);
if (strtolower($path_parts['extension'] == 'pdf'))
  header('Content-type: application/pdf');
else
  header('Content-Type: text/html; charset=utf-8');
?>
<html>
    <head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

        <?php echo Gestor::loadJQuery(); ?>
        <script>
          $(function () {
              var opened
              
              $("li, pre").hide();
              $("ul:odd").addClass("odd");
              $("li, pre").click(function (e) {e.preventDefault();return false;});
              $("ul").click(function (e) {
                  if ($(this).children("li, pre").is(":visible")) {
                      $(this).children("li").hide();
                      $(this).children("pre").hide();
                      return;
                  }
                 else{
                   $(this).children("li").show();
                   $(this).children("pre").show();
                 // $(this).find("li").each(function () {$(this).show()});
                 // $(this).find("pre").each(function () {$(this).show()});
                   
                 }

                 // $("li").hide();
                 // $("pre").hide();

              });
          });
        </script>
        <style>
            ul{margin:0}
            li{font-size: 0.9em;color:#0063dc;margin-let:30px;list-style-type: square}
            .date{color:#444;}
            .level-0,.fila{padding:4px;}
            .level-0.amfphp{color:deepskyblue}
            .level-0 .ajax{color:blueviolet}
            .level-0 .cron{color:grey}
            .level-0 .grups{color:darksalmon}
            .even{}
            .odd{background:#EEF}
            .level-0, .margin{border-top:#444 dotted 2px;font-weight:bold;color:blue;}
            .level-1{
                margin-left:25px;
                color:#999;
                font-size: 0.8em;
            }
            .dspnn{display:none;}
           // li, pre{display:none;}
            pre{font-size:0.8em;color:#999}
            .miniquery{font-size: 0.8em;color:#999;}
            
            .idr{color:red;font-weight:bold}
            .query{color:green}
            .EXIT{color:green}
            .ERROR{color:RED}
        </style>
    </head>
    <body>
        <?php
        echo "Llegim fitxer: <b>$file</b><br/><br/><div>";
        $parodd = false;
        $cnt = 0;
        $file_handle = fopen($file, "r");
        $first = TRUE;
        while (!feof($file_handle)) {
          $line = fgets($file_handle);
          $date = date("Y-m-d H:i:s");

          $cnt++;
         
          $line = str_replace('<br/>', '', $line);
          $line = str_replace('<br>', '', $line);
          
          echo $line;
          if ($cnt > 500) {
            $cnt = 0;
            flush();
          }
        }
        fclose($file_handle);
        ?>
    </body>
</html>