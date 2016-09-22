<?php $hugeit_lightbox_values = $this->model->getlightboxList(); ?>
<link rel="stylesheet" type="text/css" media="all" href="http://localhost/lightbox/wp-content/plugins/lightbox/css/admin/admin.style.css" />
<div id="post-body-heading" class="post-body-line">
	<h3>Design customization</h3>
	<a onclick="document.getElementById('adminForm').submit()" class="save-lightbox-options button-primary">Save</a>		
</div>
<div id="lightbox-options-list">
	<form action="admin.php?page=huge_it_light_box&hugeit_task=save" method="post" id="adminForm" name="adminForm">
	<div class="options-block">	
		<h3>Internationalization</h3>
			<div class="has-background">
				<label for="light_box_style">Lightbox style</label>
				<select id="light_box_style" name="params[light_box_style]">	
					<option <?php if($hugeit_lightbox_values['light_box_style'] == '1'){ echo 'selected="selected"'; } ?> value="1">1</option>
					<option <?php if($hugeit_lightbox_values['light_box_style'] == '2'){ echo 'selected="selected"'; } ?> value="2">2</option>
					<option <?php if($hugeit_lightbox_values['light_box_style'] == '3'){ echo 'selected="selected"'; } ?> value="3">3</option>
					<option <?php if($hugeit_lightbox_values['light_box_style'] == '4'){ echo 'selected="selected"'; } ?> value="4">4</option>
					<option <?php if($hugeit_lightbox_values['light_box_style'] == '5'){ echo 'selected="selected"'; } ?> value="5">5</option>
				</select>
			</div>
			<div>
				<label for="light_box_transition">Transition type</label>
				<select id="light_box_transition" name="params[light_box_transition]">	
					<option <?php if($hugeit_lightbox_values['light_box_transition'] == 'elastic'){ echo 'selected="selected"'; } ?> value="elastic">Elastic</option>
					<option <?php if($hugeit_lightbox_values['light_box_transition'] == 'fade'){ echo 'selected="selected"'; } ?> value="fade">Fade</option>
					<option <?php if($hugeit_lightbox_values['light_box_transition'] == 'none'){ echo 'selected="selected"'; } ?> value="none">none</option>
				</select>
			</div>	
			<div class="has-background">
				<label for="light_box_speed">Opening speed</label>
				<input type="number" name="params[light_box_speed]" id="light_box_speed" value="<?php echo $hugeit_lightbox_values[light_box_speed]; ?>" class="text">
				<span>ms</span>
			</div>
			<div>
				<label for="light_box_fadeout">Closing speed</label>
				<input type="number" name="params[light_box_fadeout]" id="light_box_fadeout" value="<?php echo $hugeit_lightbox_values[light_box_fadeout]; ?>" class="text">
				<span>ms</span>
			</div>
			<div class="has-background">
				<label for="light_box_title">Show the title</label>
				<input type="hidden" value="false" name="params[light_box_title]" />
				<input type="checkbox" id="light_box_title"  <?php if($hugeit_lightbox_values['light_box_title']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_title]" value="true" />
			</div>
			<div>
				<label for="light_box_opacity">Overlay transparency</label>			
				<div class="slider-container">
					<input name="params[light_box_opacity]" id="light_box_opacity" data-slider-highlight="true"  data-slider-values="0,10,20,30,40,50,60,70,80,90,100" type="text" data-slider="true" value="<?php echo $hugeit_lightbox_values['light_box_opacity']; ?>" />
					<span><?php echo $hugeit_lightbox_values['light_box_opacity']; ?>%</span>
				</div>
			</div>
			<div class="has-background">
				<label for="light_box_open">Auto open</label>
				<input type="hidden" value="false" name="params[light_box_open]" />
				<input type="checkbox" id="light_box_open"  <?php if($hugeit_lightbox_values['light_box_open']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_open]" value="true" />
			</div>
			<div>
				<label for="light_box_overlayclose">Overlay close <?php if($hugeit_lightbox_values['light_box_overlayclose']){ echo "true"; } ?></label>		
				<input type="hidden" value="false" name="params[light_box_overlayclose]" />
				<input type="checkbox" id="light_box_overlayclose"  <?php if($hugeit_lightbox_values['light_box_overlayclose']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_overlayclose]" value="true" />
			</div>
			<div class="has-background">
				<label for="light_box_esckey">EscKey close</label>	
				<input type="hidden" value="false" name="params[light_box_esckey]" />
				<input type="checkbox" id="light_box_esckey"  <?php if($hugeit_lightbox_values['light_box_esckey']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_esckey]" value="true" />
			</div>
			<div>
				<label for="light_box_arrowkey">Keyboard navigation</label>				
				<input type="hidden" value="false" name="params[light_box_arrowkey]" />
				<input type="checkbox" id="light_box_arrowkey"  <?php if($hugeit_lightbox_values['light_box_arrowkey']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_arrowkey]" value="true" />
			</div>
			<div class="has-background">
				<label for="light_box_loop">Loop content</label>	
				<input type="hidden" value="false" name="params[light_box_loop]" />
				<input type="checkbox" id="light_box_loop"  <?php if($hugeit_lightbox_values['light_box_loop']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_loop]" value="true" />
			</div>
			<div>
				<label for="light_box_closebutton">Show close button</label>		
				<input type="hidden" value="false" name="params[light_box_closebutton]" />
				<input type="checkbox" id="light_box_closebutton"  <?php if($hugeit_lightbox_values['light_box_closebutton']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_closebutton]" value="true" />
			</div>
	</div>
	<div class="options-block">
		<h3>Dimensions</h3>
		
		<div class="has-background">
			<label for="light_box_size_fix">Popup size fix</label>
			<input type="hidden" value="false" name="params[light_box_size_fix]" />
			<input type="checkbox" id="light_box_size_fix"  <?php if($hugeit_lightbox_values['light_box_size_fix']  == 'true'){ echo 'checked="checked"'; } ?>  name="params[light_box_size_fix]" value="true" />
		</div>
		
		<div class="fixed-size" >
			<label for="light_box_width">Popup width</label>
			<input type="number" name="params[light_box_width]" id="light_box_width" value="<?php echo $hugeit_lightbox_values[light_box_width]; ?>" class="text">
			<span>px</span>
		</div>
		
		<div class="has-background fixed-size">
			<label for="light_box_height">Popup height</label>
			<input type="number" name="params[light_box_height]" id="light_box_height" value="<?php echo $hugeit_lightbox_values[light_box_height]; ?>" class="text">
			<span>px</span>
		</div>
		
		<div class="not-fixed-size">
			<label for="light_box_maxwidth">Popup maxWidth</label>
			<input type="number" name="params[light_box_maxwidth]" id="light_box_maxwidth" value="<?php echo $hugeit_lightbox_values[light_box_maxwidth]; ?>" class="text">
			<span>px</span>
		</div>
		<div class="has-background not-fixed-size">
			<label for="light_box_maxheight">Popup maxHeight</label>
			<input type="number" name="params[light_box_maxheight]" id="light_box_maxheight" value="<?php echo $hugeit_lightbox_values[light_box_maxheight]; ?>" class="text">
			<span>px</span>
		</div>
		<div>
			<label for="light_box_initialwidth">Popup initial width</label>
			<input type="number" name="params[light_box_initialwidth]" id="light_box_initialwidth" value="<?php echo $hugeit_lightbox_values[light_box_initialwidth]; ?>" class="text">
			<span>px</span>
		</div>
		<div class="has-background">
			<label for="light_box_initialheight">Popup initial height</label>
			<input type="number" name="params[light_box_initialheight]" id="light_box_initialheight" value="<?php echo $hugeit_lightbox_values[light_box_initialheight]; ?>" class="text">
			<span>px</span>
		</div>
	</div>
	</form>
</div>
<div id="post-body-heading" class="post-body-line">
	<a onclick="document.getElementById('adminForm').submit()" class="save-lightbox-options button-primary">Save</a>		
</div>