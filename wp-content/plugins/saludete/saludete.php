<?php
   /*
      Plugin Name: saludete
      Plugin URI: saludet.com
      Description: saludete saludete saludete
      Version: 2.3.4
      Author: alex
      Author URI: dadapuntcat.cat
   */
   
   /*
      SALUDETE esto aparecerá directamente en el panel de 
      administración de plugins
   */ 

function saludo(){
      echo '<br>hola mundo-CA';
      
   }
   
   
function saludo_instala(){
   global $wpdb; // <-- sin esto no funcionara nada con la DB no cambies nada
   $table_name= $wpdb->prefix . "saludos";
   $sql = " CREATE TABLE $table_name(
      id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
      saludo tinytext NOT NULL ,
      PRIMARY KEY ( `id` )   
   ) ;";
   $wpdb->query($sql);
   $sql = "INSERT INTO $table_name (saludo) VALUES ('Hola Mundo');";
   $wpdb->query($sql);
}   

function saludo_desinstala(){
   global $wpdb; 
   $tabla_nombre = $wpdb->prefix . "saludos";
   $sql = "DROP TABLE $tabla_nombre";
   $wpdb->query($sql);
}   
   

   function saludo_panel(){  
     echo "WWWWW";
      include('template/panel.html');
       echo "<h1>{$_POST['saludo_inserta']}</h1>";
   }
  
   function saludo_add_menu(){   
      if (function_exists('add_options_page')) {
         //add_menu_page
         add_options_page('saludete', 'saludete', 8, basename(__FILE__), 'saludo_panel');
      }
   }
   if (function_exists('add_action')) {
      add_action('admin_menu', 'saludo_add_menu'); 
   } 
   
/*****************************************************************************/   
/*****************************************************************************/   
/*****************************************************************************/   
   
//ojo con la sintaxis de la funcion add_action 
add_action('activate_saludete/saludete.php','saludo_instala');
add_action('deactivate_saludete/saludete.php', 'saludo_desinstala');


//add_action("wp_head","saludo");
add_action("wp_footer","saludo");
?>
