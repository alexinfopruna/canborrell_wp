<?php
if( !class_exists('Magee_Accordion') ):
class Magee_Accordion {

	public static $args;
    private  $id;
	private  $num;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_accordion', array( $this, 'render_parent' ) );
        add_shortcode( 'ms_accordion_item', array( $this, 'render_child' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render_parent( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'style'=>'simple',
				'type' =>1
			), $args
		);
		

		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid('accordion-');
		$this->id = $id.$uniqid;
        $this->num = 1;

		$class .= ' style'.$type;
		
		$html = '<div class="panel-group magee-accordion accordion-'.$style.' '.esc_attr($class).'" role="tablist" aria-multiselectable="true" id="'.esc_attr($this->id).'">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>';
	    $html .= '<script>
	   jQuery(function($) {
	      if($("#magee-sc-form-preview").length>0){ 
			  num = $("#magee-sc-form-preview").contents().find(".panel-heading").length ;
				  for($i=0;$i<num;$i++){
					  $("#magee-sc-form-preview").contents().find(".panel-heading").eq($i).on("click",function(e){
					      e.preventDefault();	
						  if($(this).find("a").attr("class") == "accordion-toggle" || $(this).find("a").attr("class") == "accordion-toggle "){
						  $(this).find("a").addClass("collapsed");
						  $(this).find("a").attr("aria-expanded","false");
						  $(this).next().removeClass("in");		
						  }else{
						  $(this).find("a").removeClass("collapsed");
						  $(this).find("a").attr("aria-expanded","true");
						  $(this).next().addClass("in");
						  $(this).parent(".panel-default").siblings().find("a").addClass("collapsed");
						  $(this).parent(".panel-default").siblings().find("a").attr("aria-expanded","false");
						  $(this).parent(".panel-default").siblings().find(".panel-heading").next().removeClass("in");		
						  }
					   }); 
				  };
		$("#magee-sc-form-preview").contents().find(".panel-title").each(function(){
		if($(this).find(".open-magee-accordion").length>0 || $(this).find(".close-magee-accordion").length>0){
			var open_icon =$(this).find("i").attr("data-open");
			var close_icon = $(this).find("i").attr("data-close");
			var now_class = $(this).find("i").attr("class");
			$(this).click(function(){					
			  if($(this).find("i").hasClass("open-magee-accordion")){ 
				  var new_class = now_class.replace("open-magee-accordion","close-magee-accordion").replace(open_icon,close_icon);
				  $(this).find("i").attr("class",new_class);
				  }else{
				  var new_class = now_class.replace("close-magee-accordion","open-magee-accordion").replace(close_icon,open_icon);
				  $(this).find("i").attr("class",new_class);
				  $(this).parents(".panel-default").siblings().each(function(){
					  var sub_icon1 =  $(this).find(".panel-title i").attr("data-open");
					  var sub_icon2 =  $(this).find(".panel-title i").attr("data-close");
					  var sub_class = $(this).find(".panel-title i").attr("class");
					  var new_sub_class = sub_class.replace("open-magee-accordion","close-magee-accordion").replace(sub_icon1,sub_icon2);
					  $(this).find(".panel-title i").attr("class",new_sub_class);															 
																				 
				  });
				  }					  				   								   
			  });						
		}	   
  });	  
		  }	   	  
	   });
	   </script>'; 

		return $html;

	}
	
	/**
	 * Render the child shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render_child( $args, $content = '') {
		
		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'title' =>'',
				'status' =>'',
				'close_icon' =>'',
				'open_icon' =>'',
				'background_color' => '',
				'color' => '',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
        $html = '';
		$icon_str = '';
		if( $status == "open" ) {
		$status   = "in";
		$expanded = "true";
		$collapse = "";
		if($open_icon !== ''):
		$icon_str = '<i class="fa '.esc_attr($open_icon).' open-magee-accordion" data-close="'.$close_icon.'" data-open="'.$open_icon.'"></i>';
		endif;
		}
		else{
		$status = "";
		$expanded = "false";
		$collapse = "collapsed";
		if($close_icon !== ''):
		$icon_str = '<i class="fa '.esc_attr($close_icon).' close-magee-accordion" data-close="'.$close_icon.'" data-open="'.$open_icon.'"></i>';
		endif;
		}
        /*if( stristr($icon,'fa-')):
		
		else:
		$icon_str = '<img class="image-instead" src="'.esc_attr($icon).'"/>';
		endif;*/
		
        $itemId = 'collapse'.$this->id."-".$this->num;
		$addclass = 'panel-css-'.$this->num;
		
		
		$html .= '<div class="panel panel-default '.$addclass.'">';
		$html .= '<style type="text/css">';
		if($background_color !== '')
		$html .= '#'.$this->id.' .'.$addclass.' .panel-heading{
		background-color:'.$background_color.'!important;}
		#'.$this->id.' .'.$addclass.'{border-color:'.$background_color.'!important;}';
		
		if($color !== '')
		$html .= '#'.$this->id.' .'.$addclass.' .panel-title{color:'.$color.'!important;}
		#'.$this->id.' .'.$addclass.' .panel-title i{color:'.$color.';}
		#'.$this->id.' .'.$addclass.' .panel-heading .accordion-toggle:after{color:'.$color.';}';
		
		$html .= '</style>';
		
		$html .= '
                                                    <div class="panel-heading" role="tab" id="heading'.$itemId.'">
                                                        <a class="accordion-toggle '.$collapse.'" data-toggle="collapse" data-parent="#'.$this->id.'" href="#'.$itemId.'" aria-expanded="'.$expanded.'" aria-controls="'.$itemId.'">
                                                            <h4 class="panel-title">
                                                                 '.$icon_str.esc_attr($title).'
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div id="'.$itemId.'" class="panel-collapse collapse '.$status.'" role="tabpanel" aria-labelledby="heading'.$itemId.'" aria-expanded="'.$expanded.'">
                                                        <div class="panel-body">
                                                          '.do_shortcode( Magee_Core::fix_shortcodes($content)).'
														  <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>';
         
$this->num++;
       
		return $html;
	}


}

new Magee_Accordion();
endif;