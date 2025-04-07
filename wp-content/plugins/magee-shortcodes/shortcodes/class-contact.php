<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Magee_Contact {

	public static $args;
    private  $id;
	private  $num;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
        add_shortcode( 'ms_contact', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {
        
        Helper::get_style_depends(['font-awesome', 'bootstrap', 'magee-shortcodes']);
		Helper::get_script_depends(['magee-shortcodes']);

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'id' 				=>'',
				'class' 			=>'',
				'style'				=>'classic',
				'receiver'			=>'',
				'color'				=>'',
				'terms'             =>'yes',
				'button_text'      => __('Submit', 'magee-shortcodes'),
                'display_fields'    => '',
				'required_fields'   => 'name,email,message',
                'is_preview'		   => '',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$uniq_class = Utils::rand_str('contact-form-');
		$class     .= ' magee-shortcode magee-contact '.$uniq_class;
		$items = '';
		$required_country = array('','');
		$required_city = array('','');
		$required_telephone = array('','');
		$required_company = array('','');
		$required_website = array('','');
		$required_name = array('','');
		$required_email = array('','');
		$required_subject = array('','');
		$required_message = array('','');
        $css_style = '';

		if(stristr($required_fields,'country')):
		    $required_country[0] = 'required="required" aria-required="true" ';
		    $required_country[1] = ' *';
		endif;
		if(stristr($required_fields,'city')):
		    $required_city[0] = 'required="required" aria-required="true" ';
		    $required_city[1] = ' *';
		endif;
		if(stristr($required_fields,'telephone')):
		    $required_telephone[0] = 'required="required" aria-required="true" ';
		    $required_telephone[1] = ' *';
		endif;
		if(stristr($required_fields,'company')):
		    $required_company[0] = 'required="required" aria-required="true" ';
		    $required_company[1] = ' *';
		endif;
		if(stristr($required_fields,'website')):
		    $required_website[0] = 'required="required" aria-required="true" ';
		    $required_website[1] = ' *';
		endif;
		if(stristr($required_fields,'name')):
		    $required_name[0] = 'required="required" aria-required="true" ';
		    $required_name[1] = ' *';
		endif;
		if(stristr($required_fields,'email')):
		    $required_email[0] = 'required="required" aria-required="true" ';
		    $required_email[1] = ' *';
		endif;
		if(stristr($required_fields,'subject')):
		    $required_subject[0] = 'required="required" aria-required="true" ';
		    $required_subject[1] = ' *';
		endif;
		if(stristr($required_fields,'message')):
		    $required_message[0] = 'required="required" aria-required="true" ';
		    $required_message[1] = ' *';
		endif;
		if(stristr($display_fields,'country')):
            if($style == 'classic'){
                $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="country">'.__('Country', 'magee-shortcodes').'</label>
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-globe fa-fw"></i></span>
                                        <input type="text" '.$required_country[0].' class="form-control" name="country" id="country" placeholder="'.__('Country', 'magee-shortcodes').$required_country[1].'"> 
                                </div>		 
                            </div>
                    </div>';
            }else{
                    $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="country">'.__('Country', 'magee-shortcodes').'</label>
                                <input type="text" '.$required_country[0].' class="form-control" name="country" id="country" placeholder="'.__('Country', 'magee-shortcodes').$required_country[1].'"> 	 
                            </div>
                    </div>';      
            }
		
		endif;
		if(stristr($display_fields,'city')):
            if($style == 'classic'){
                $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="city">'.__('City', 'magee-shortcodes').'</label>
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                        <input type="text" '.$required_city[0].' class="form-control" name="city" id="city" placeholder="'.__('City', 'magee-shortcodes').$required_city[1].'"> 
                                </div>		 
                            </div>
                </div>'; 	  
            }else{
                $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="city">'.__('City', 'magee-shortcodes').'</label>
                                <input type="text" '.$required_city[0].' class="form-control" name="city" id="city" placeholder="'.__('City', 'magee-shortcodes').$required_city[1].'"> 
                            </div>
                </div>';
            }
		
		endif;

		if(stristr($display_fields,'telephone')):
		
            if($style == 'classic'){
                $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="telephone">'.__('Telephone', 'magee-shortcodes').'</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    <input type="text" '.$required_telephone[0].' class="form-control" name="telephone" id="telephone" placeholder="'.__('Telephone', 'magee-shortcodes').$required_telephone[1].'"> 
                                </div>	  
                            </div>
                        </div>'; 		   
            }else{
                    $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="telephone">'.__('Telephone', 'magee-shortcodes').'</label>
                                <input type="text" '.$required_telephone[0].' class="form-control" name="telephone" id="telephone" placeholder="'.__('Telephone', 'magee-shortcodes').$required_telephone[1].'"> 
                            </div>
                        </div>';
            }
		
		endif;

		if(stristr($display_fields,'company')):
		
		   if($style == 'classic'){
                $items .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="company">'.__('Company', 'magee-shortcodes').'</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
                                    <input type="text" '.$required_company[0].' class="form-control" name="company" id="company" placeholder="'.__('Company', 'magee-shortcodes').$required_company[1].'"> 
                                </div>	  
                            </div>
                        </div>';			
            }else{
                $items .= '<div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label sr-only" for="company">'.__('Company', 'magee-shortcodes').'</label>
                        <input type="text" '.$required_company[0].' class="form-control" name="company" id="company" placeholder="'.__('Company', 'magee-shortcodes').$required_company[1].'"> 
                    </div>
                </div>';
			}
		
		endif;
		if(stristr($display_fields,'website')):
		   
		   if($style == 'classic'){
		   $items .= '<div class="row">
                      <div class="form-group col-md-12">
                         <label class="control-label sr-only" for="website">'.__('Website', 'magee-shortcodes').'</label>
						 <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-internet-explorer fa-fw"></i></span>
                              <input type="text" '.$required_website[0].' class="form-control" name="website" id="website" placeholder="'.__('Website', 'magee-shortcodes').$required_website[1].'"> 
						 </div> 	  
                      </div>
		   </div>';
			   
			   }else{
				$items .= '<div class="row">
                      <div class="form-group col-md-12">
                         <label class="control-label sr-only" for="website">'.__('Website', 'magee-shortcodes').'</label>
                         <input type="text" '.$required_website[0].' class="form-control" name="website" id="website" placeholder="'.__('Website', 'magee-shortcodes').$required_website[1].'"> 
                      </div>
		</div>'; 
			   }
		
		endif;
        $css_style .= '
                .'.$uniq_class.' .contact-form-line {
                    color: '.esc_attr($color).';
                    }
                .'.$uniq_class.' .contact-form-custom .form-control {
                    padding: 20px;
                    border-color: '.esc_attr($color).';
                    color: '.esc_attr($color).';
                }
            .'.$uniq_class.' .contact-form-custom input:focus,
            .'.$uniq_class.' .contact-form-custom textarea:focus {
                    border-color: '.esc_attr($color).';
                    box-shadow: 0 0 5px 1px rgba(0,0,0,.1);
                }
            .'.$uniq_class.' .contact-form-custom input[type="submit"] {
                    background-color:'.esc_attr($color).';
                }
                
                .'.$uniq_class.' .magee-contact-form.contact-form-line .form-control{
                    color:'.esc_attr($color).';
                    border-color: '.esc_attr($color).';
                    }
            .'.$uniq_class.' .magee-btn-normal.btn-line {
                    border-color: '.esc_attr($color).';
                    color: '.esc_attr($color).';
                    }
            .'.$uniq_class.' .magee-contact-form.contact-form-bg .form-control,
            .'.$uniq_class.' .magee-contact-form.contact-form-bg .magee-btn-normal{
                    background-color:'.esc_attr($color).';
                }';

	   $html = '<div id="'.esc_attr($id).'" class="magee-contact-form-wrap '.esc_attr($class).'">';		
		switch( $style ){
			case 'normal':
			
                $html .= '<form action="" class="magee-contact-form contact-form-custom" >';
                    
                $html .= '<div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label sr-only" for="name">'.__('Name', 'magee-shortcodes').'</label>
                                <input type="text" '.$required_name[0].' class="form-control" name="name" id="name" placeholder="'.__('Name', 'magee-shortcodes').$required_name[1].'">                                                      
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label sr-only" for="email">'.__('Email address', 'magee-shortcodes').'</label>
                                <input type="email" '.$required_email[0].' class="form-control" name="email" id="email" placeholder="'.__('Email', 'magee-shortcodes').$required_email[1].'">                                                       
                            </div>
                        </div>';
                    $html .= $items;				
                    $html .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="subject">'.__('Subject', 'magee-shortcodes').'</label>
                                <input type="subject" '.$required_subject[0].' class="form-control" name="subject" id="subject"  placeholder="'.__('Subject', 'magee-shortcodes').$required_subject[1].'">
                            </div>
                        </div>';
                    $html .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="">'.__('Message', 'magee-shortcodes').'</label>
                                <textarea name="message" id="message" '.$required_message[0].' rows="10" placeholder="'.__('Message', 'magee-shortcodes').$required_message[1].'" class="form-control"></textarea>  
                            </div>
                        </div>';
                    
                    if( $terms == 'yes' ):	
                        $html .= '<div class="row">
                            <div class="checkbox col-md-12">
                                <label>
                                    <input type="checkbox" required="required" aria-required="true" id="checkboxWarning"  name="checkboxWarning" value="1">
                                    '.do_shortcode( Helper::fix_shortcodes($content)).'
                                </label>
                            </div>
                        </div>';
                        endif;
                
                    $html .= '<div class="row contact-failed"></div>';
                        
                    $html .= '<div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label sr-only" for="submit">'.$button_text.'</label>
                                <input type="submit" value="'.$button_text.'" id="submit" class="magee-btn-normal">
                                <input type="hidden" name="receiver" id="receiver" value="'.esc_attr($receiver).'">
                                <input type="hidden" name="terms" id="terms" value="'.$terms.'">
                                <input type="hidden" name="required_fields" id="required_fields" value="'.$required_fields.'">
                            </div>
                        </div>';
                        
                    $html   .= '</form>';
                                             
										
			    break;
			case "outline":
			    $html   .= '<form action="" class="magee-contact-form contact-form-line">';
                        $html   .= ' <div class="row"> 
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label sr-only" for="name">'.__('Name', 'magee-shortcodes').'</label>
                                                            <input type="text" '.$required_name[0].' class="form-control" name="name" id="name" placeholder="'.__('Name', 'magee-shortcodes').$required_name[1].'">                                                      
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label sr-only" for="email">'.__('Email address', 'magee-shortcodes').'</label>
                                                            <input type="email" '.$required_email[0].' class="form-control" name="email" id="email" placeholder="'.__('Email', 'magee-shortcodes').$required_email[1].'">                                                       
                                                        </div>
                                                    </div>';
						$html .= $items;									
                        $html   .= '<div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="control-label sr-only" for="subject">'.__('Subject', 'magee-shortcodes').'</label>
                                                            <input type="subject" '.$required_subject[0].' class="form-control" name="subject" id="subject" placeholder="'.__('Subject', 'magee-shortcodes').$required_subject[1].'">
                                                        </div>
                                                    </div>';
                        $html   .= '<div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="control-label sr-only" for="message">'.__('Message', 'magee-shortcodes').'</label>
                                                            <textarea '.$required_message[0].'  name="message" id="message" rows="10" placeholder="'.__('Message', 'magee-shortcodes').$required_message[1].'" class="form-control"></textarea>  
                                                        </div>
                                                    </div>';
						  						
						if( $terms == 'yes' ):					
                            $html   .= '<div class="row">
                                            <div class="checkbox col-md-12">
                                                <label>
                                                    <input required="required" aria-required="true" type="checkbox" id="checkboxWarning"  name="checkboxWarning" value="1">
                                                    '.do_shortcode( Helper::fix_shortcodes($content)).'
                                                </label>
                                            </div>
                                        </div>';
						endif;
								
						$html .= '<div class="row contact-failed"></div>';
													
                        $html   .= '<div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="control-label sr-only" for="submit">'.$button_text.'</label>
                                            <input type="submit" value="'.$button_text.'" id="submit" class="magee-btn-normal btn-line ">
                                            <input type="hidden" name="receiver" id="receiver" value="'.esc_attr($receiver).'">
                                            <input type="hidden" name="terms" id="terms" value="'.$terms.'">
                                            <input type="hidden" name="required_fields" id="required_fields" value="'.$required_fields.'">
                                        </div>
                                    </div>';
                   $html   .= '</form>';
			    break;
			
			case "background":
                $html   .= '<form action="post" class="magee-contact-form contact-form-bg dark">';
                $html   .= '<div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label sr-only" for="name">'.__('Name', 'magee-shortcodes').'</label>
                                    <input type="text" '.$required_name[0].' class="form-control" name="name" id="name" placeholder="'.__('Name', 'magee-shortcodes').$required_name[1].'">                                                      
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label sr-only" for="email">'.__('Email address', 'magee-shortcodes').'</label>
                                    <input '.$required_email[0].' type="email" class="form-control" name="email" id="email" placeholder="'.__('Email', 'magee-shortcodes').$required_email[1].'">                                                       
                                </div>
                            </div>';
                $html   .= $items;											
                $html   .= '<div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label sr-only" for="">'.__('Subject', 'magee-shortcodes').'</label>
                                    <input type="subject" '.$required_subject[0].' class="form-control" name="subject" id="subject" placeholder="'.__('Subject', 'magee-shortcodes').$required_subject[1].'">
                                </div>
                            </div>';
                $html   .= '<div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label sr-only" for="message">'.__('Message', 'magee-shortcodes').'</label>
                                    <textarea '.$required_message[0].' name="message" id="message" rows="10" placeholder="'.__('Message', 'magee-shortcodes').$required_message[1].'" class="form-control"></textarea>  
                                </div>
                            </div>';
                                                    
                if( $terms == 'yes' ):			
                    $html   .= '<div class="row">
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input required="required" aria-required="true" type="checkbox" id="checkboxWarning"  name="checkboxWarning" value="1">
                                        '.do_shortcode( Helper::fix_shortcodes($content)).'
                                    </label>
                                </div>
                            </div>';
                endif;
                            
                $html .= '<div class="row contact-failed"></div>';
                    
                $html   .= '<div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label sr-only" for="submit">'.$button_text.'</label>
                                                                <input type="submit" value="'.$button_text.'" id="submit"  class="magee-btn-normal btn-dark">
                                                                <input type="hidden" name="receiver" id="receiver" value="'.esc_attr($receiver).'">
                                                                <input type="hidden" name="terms" id="terms" value="'.$terms.'">
                                                                <input type="hidden" name="required_fields" id="required_fields" value="'.$required_fields.'">
                                                            </div>
                                                        </div>';
                $html   .= '</form>';
			    break;
			
			case "classic":
			default:
			
			    $html   .= '<form action="post" class="magee-contact-form contact-form-classic">';
                $html   .= '<div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label sr-only" for="name">'.__('Name', 'magee-shortcodes').'</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                                                <input type="text" '.$required_name[0].' class="form-control" name="name" id="name" placeholder="'.__('Name', 'magee-shortcodes').$required_name[1].'">
                                                            </div>                                                        
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label sr-only" for="">'.__('Email address', 'magee-shortcodes').'</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                                                <input type="email" '.$required_email[0].' class="form-control" name="email" id="email" placeholder="'.__('Email', 'magee-shortcodes').$required_email[1].'">
                                                            </div>                                                       
                                                        </div>
                                                    </div>';
		        $html .= $items;												
                $html   .= '<div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="control-label sr-only" for="subject">'.__('Subject', 'magee-shortcodes').'</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
                                                                <input type="subject" '.$required_subject[0].' class="form-control" name="subject" id="subject"  placeholder="'.__('Subject', 'magee-shortcodes').$required_subject[1].'">
                                                            </div>
                                                        </div>
                                                    </div>';
                $html   .= '<div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="control-label sr-only" for="message">'.__('Message', 'magee-shortcodes').'</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                                                <textarea '.$required_message[0].' name="message" id="message" rows="10" placeholder="'.__('Message', 'magee-shortcodes').$required_message[1].'" class="form-control"></textarea>
                                                            </div>    
                                                        </div>
                                                    </div>';
													
				if( $terms == 'yes' ):	
                    $html   .= '<div class="row">
                                    <div class="checkbox col-md-12">
                                        <label>
                                            <input type="checkbox" id="checkboxWarning" name="checkboxWarning" value="1" required="required" aria-required="true">
                                                '.do_shortcode( Helper::fix_shortcodes($content)).'
                                        </label>
                                    </div>
                                </div>';
				endif;
	  													
                $html .= '<div class="row contact-failed"></div>';
													
													
                $html .= '<div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label sr-only" for="submit">'.$button_text.'</label>
                                    <input type="submit" value="'.$button_text.'" id="submit" class="magee-btn-normal">
                                    <input type="hidden" name="receiver" id="receiver" value="'.esc_attr($receiver).'">
                                    <input type="hidden" name="terms" id="terms" value="'.$terms.'">
                                    <input type="hidden" name="required_fields" id="required_fields" value="'.$required_fields.'">
                                </div>
                            </div>';
                $html   .= '</form>';
												
			    break;
			
		}
	    $html   .= '<div id="failed-info" style=" display:none;">'.__('Please fill in all of the required fields', 'magee-shortcodes').'</div>';
        $html   .= '</div>';

		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$this->is_preview = "1";
		}

        if ($this->is_preview == "1"){
			$html = sprintf( '<style type="text/css" scoped="scoped">%1$s</style>%2$s' ,$css_style, $html );
		}else{
			wp_add_inline_style('magee-shortcodes', $css_style);
		}
		
		return $html;
	}
	
}

new Magee_Contact();