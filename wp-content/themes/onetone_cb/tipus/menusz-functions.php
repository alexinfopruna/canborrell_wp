<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//
// New Post Type
//


add_action('init', 'cb_menusz_register');  

function cb_menusz_register() {
    $args = array(
        'label' => __('MenúsZ', 'cb_backend'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => true,
        'supports' => array('title','thumbnail','editor')
       );  

    register_post_type( 'menusz' , $args );
}


//
// Thumbnail column
//



//
// Testimonial Title and Caption
//

add_action("admin_init", "cb_menusz_title_settings");   

function cb_menusz_title_settings(){
 //  echo "sssssssWWW";die();
    add_meta_box("menusz_title_settings", "Menús", "cb_menusz_title_config", "menusz", "normal", "high");
}   

function cb_menusz_title_config(){
        global $post;
       // echo "EEEEE";die();
       if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		
		if(isset($custom["menusz_content"][0])) $testimonial_content = $custom["menusz_content"][0];
		if(isset($custom["role"][0])) $role = $custom["role"][0];
		if(isset($custom["name"][0])) $name = $custom["name"][0];
?>
	<div class="metabox-options form-table fullwidth-metabox image-upload-dep">
		
		<div class="metabox-option">
			<h6><?php _e('Name', 'cb_backend') ?>:</h6>
			<input type="text" name="name" value="<?php echo $name; ?>">
		</div>		
		
		<div class="metabox-option">
			<h6><?php _e('Role', 'cb_backend') ?>:</h6>
			<input type="text" name="role" value="<?php echo $role; ?>">
		</div>
		
		<div class="metabox-option">
			<h6><?php _e('Menús', 'cb_backend') ?>:</h6>
			<textarea name="testimonial_content"><?php echo $testimonial_content; ?></textarea>
		</div>
		
	</div>
<?php
    }	
	
	
// Save Slide
	
add_action('save_post', 'cb_save_menusz_meta'); 

function cb_save_menusz_meta(){
    global $post;  	
	
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
	
		$post_metas = array('name','role','menusz_content');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}
    }

}

