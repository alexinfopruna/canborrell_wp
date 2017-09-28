<?php

$option_name   = onetone_option_name();
Kirki::add_config( $option_name, array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'option',
	'option_name'   => $option_name
) );

$f = 1;
$p = 1;
$s = 1;
$section = '';
$options = onetone_theme_options();

$onetone_companion_options = get_option('onetone_companion_options');
if(!$onetone_companion_options){
	$onetone_companion_options = array();
}
if(class_exists('OnetoneCompanion') ){
	$onetone_companion_options = array_merge(OnetoneCompanion::default_options(),$onetone_companion_options);
}
$onetone_companion_options = apply_filters('onetone_companion_options',$onetone_companion_options);
$display = 1;
foreach($options as $key=>$option ){
	
	if(!isset($option['settings']))
		$option['settings'] = $option['slug'];
		
	if($option['type']=='panel'){
		$display = 1;
		
		if( isset($onetone_companion_options[$option['settings']]) && $onetone_companion_options[$option['settings']] == '1'){
			
			$display = 0;
			}
	}
	
	if($display == 1){
		if($option['type']=='panel'){
		Kirki::add_panel( $option['settings'], array(
		  'priority'    => $p,
		  'title'       => $option['label'],
		  'description' => '',
		  ) );
		  $p++;
		  $s = 1;
	}elseif($option['type']=='section'){
		
		Kirki::add_section( $option['settings'], array(
		  'title'          => $option['label'],
		  'description'    => '',
		  'panel'          => $option['panel'], 
		  'priority'       => $s,
		  'capability'     => 'edit_theme_options',
		  'theme_supports' => '',
	  ) );
	  
	$section = $option['settings'];
	$s++;
	$f = 1;
	
	}else{
		
		$default = array(
		
			'choices'         => '',
			'row_label'       => '',
			'fields'          => '',
			'active_callback' => '',
			'transport'       => '',
			'output'          => '',
			'js_vars'         => '',
			'partial_refresh' => '',
			'description'     =>''
		
		);
		
		$option = array_merge($default, $option);
			
		Kirki::add_field( $option_name,  $option );
		
		$f++;
		
		}
	}
	
	}