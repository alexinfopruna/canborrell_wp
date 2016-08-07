<?php
define('ROOT', "../");
require_once (ROOT . "gestor_reserves.php");
$lang = gestor_reserves::getLanguage();

$file = $_GET['file'];
include(ROOT . '../' . $file);

function process_txt($v) {
  $txt = html_entity_decode($v);
  $txt = strip_tags($txt, '');
  $txt = htmlspecialchars($txt, ENT_QUOTES);

  //$txt .= "<br>---------------------------------------------------";
  $txt .= " <br><br>";

  return $txt;
}
?>
<html>
    <?php require_once (ROOT . "../head.html"); ?>


    <body>
        <h2><?php echo $file ?></h2>
        <!--<a href="">Prev</a> | <a href="">Next</a>-->


        <div id="source" class="alert alert-info">
            <?php
            foreach ($translate as $k => $v) {
              echo process_txt($v);
            }
            
            
            echo "<br><br>-------------------------------------TRANSLATE JS-----------------------------<br><br>";
            
            foreach ($translateJS as $k => $v) {
              echo process_txt($v);
            }
            ?>
        </div>



    </body>
</html>

