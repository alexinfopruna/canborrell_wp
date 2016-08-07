<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$btn[]='<button type="button" value="1" style="padding:15px;">Josep Rovira</button>';
$btn[]='<button type="button" value="7" style="padding:15px;">Lluís Rovira</button>';
$btn[]='<button type="button" value="8" style="padding:15px;">Mari</button>';

shuffle($btn);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
</head>
<body>
<div id="confirma-editor">
  <h1>Confirma editor</h1>
  
  <?php echo $btn[0]; ?>
  <?php echo $btn[1]; ?>
  <?php echo $btn[2]; ?>
</div>
 
 
</body>
</html>
