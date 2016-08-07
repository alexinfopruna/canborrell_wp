<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_action('widgets_init', 'calendari_reserves_init');

function calendari_reserves_init() {
  register_widget('calendari_reserves');
}

class calendari_reserves extends WP_Widget {

  public function __construct() {
    $widget_details = array(
      'classname' => 'calendari_reserves',
      'description' => 'Mostra un calendari de reserves'
    );

    parent::__construct('calendari_reserves', 'Calendari reserves', $widget_details);
  }

  public function form($instance) {
    
   // print_r($instance);
    if (isset($instance['inline'])) {
      $inline = $instance['inline']=='inline';
    }
    else {
      $inline = FALSE;
    }
    
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('inline'); ?>"><?php _e('Inline:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('inline'); ?>" name="<?php echo $this->get_field_name('inline'); ?>" type="checkbox" value="inline" <?php echo $inline?'checked="checked"':'' ?>">
    </p>
    <?php
  }

  public function update($new_instance, $old_instance) {
    
    
    $instance = array();
    $instance['inline'] = $new_instance['inline']=='inline';//(!empty($new_instance['inline']) ) ? strip_tags($new_instance['inline']) : '';
    
   /*  print_r($new_instance);
     print_r($_POST);die();*/
    return $instance;
  }

  public function widget($args, $instance) {
    if (isset($instance['inline'])) {
      $inline = $instance['inline'];
    }
    else {
      $inline = FALSE;
    }

    if ($inline) {
      echo $args['before_widget'];

      echo '<div id="datepicker"></div>';
      echo $args['after_widget'];
    }
    else {
      $html = <<<HEREDOC
     
 
     <form class = "navbar-form navbar-right" action = "reservar/form.php">
    <div class = "form-group">
    <input type = "text" name = "rdata" placeholder = "Data de reserva" id = "top-datepicker" class = "form-control top-datepicker">
    <button type = "submit" class = "btn btn-success">Reservar</button>
    </div>
      </form>
HEREDOC;

      echo $args['before_widget'] . $html . $args['after_widget'];
    }
  }

}
