jQuery(document).ready(function($){

/* ------------------------------------------------------------------------ */
/*  section accordion         	  								  	    */
/* ------------------------------------------------------------------------ */
								
$('.section-accordion').click(function(){
 var accordion_item = $(this).find('.heading span').attr('id');
 //$('.'+accordion_item).slideToggle();
 if( $(this).hasClass('close')){
	    $(this).removeClass('close').addClass('open');
	    $(this).find('.heading span.fa').removeClass('fa-plus').addClass('fa-minus');
	 }else{
		$(this).removeClass('open').addClass('close'); 
		$(this).find('.heading span.fa').removeClass('fa-minus').addClass('fa-plus');
		 }
		 
 $(this).parent('.section').find('.section_wrapper').slideToggle();
	   
	 })	;

// select section content model

$('.section-content-model').each(function(){
   
   var model = $(this).find('input[type="radio"]:checked').val();
   if( model == 0 ){
	   $(this).parents('.home-section').find('.content-model-0').show();
	   $(this).parents('.home-section').find('.content-model-1').hide();
   }
   else
   {
	   $(this).parents('.home-section').find('.content-model-0').hide();
       $(this).parents('.home-section').find('.content-model-1').show();
	   }
										  
 });

  $( '.section-content-model input[type="radio"]' ).change(function() {
       var model = $(this).val();
   if( model == 0 ){
	   $(this).parents('.home-section').find('.content-model-0').show();
	   $(this).parents('.home-section').find('.content-model-1').hide();
   }
   else
   {
	   $(this).parents('.home-section').find('.content-model-0').hide();
       $(this).parents('.home-section').find('.content-model-1').show();
	   }
  });
  $('.section_wrapper').each(function(){
	  $(this).children(".content-model-0:first").addClass('model-item-first');
	  $(this).children(".content-model-0:last").addClass('model-item-last');   
  });
/* ------------------------------------------------------------------------ */
/*  delete section             	  								  	    */
/* ------------------------------------------------------------------------ */
 $('#optionsframework').on('click','.delete-section',function(){
	$(this).parents('.home-section').remove();	
	var i = 0;
	 $('.home-section').each(function(){
			$(this).find("[name^='onetone']").each(function(){
				var name = $(this).attr('name');
				var id   = $(this).attr('id');
				var new_name = name.replace(/[0-9]+/, i);
				var new_id   = id.replace(/[0-9]+/, i);
				$(this).attr('name',new_name);
				$(this).attr('id',new_id);
               });
			i++;
			$('#section_num').val(i);
	   });
  });
 if( $('.onetone-step-2-text').length ){
	 $('#menu-appearance > a').append($('#onetone-step-1-text').html());
	 $('.onetone-step-2-text').closest('li').addClass('onetone-step-2');
 }
 
 // onetone guide

$('.onetone-step-2-text,.onetone-step-1-text').click(function(e){
	e.preventDefault();					   							   
 });

$('.onetone-close-guide').click(function(e){
	e.preventDefault();	
	$('.onetone-guide').hide();
	$.ajax({
				 type:"POST",
				 dataType:"html",
				 url:ajaxurl,
				 data:"action=onetone_close_guide",
				 success:function(data){},error:function(){}
        });
	 });


/////


$('.onetone-import-demos .button-import-demo').click(function(){
			$('.importer-notice').show();															  
         });


$(document).on('click','#onetone-save-options',function(){
         $('.options-saving').fadeIn("fast");
	     $.post('options.php',$('#optionsframework form').serialize(),function(msg){
         $('.options-saving').fadeOut("fast");
		 $('.options-saved').fadeIn("fast", function() {
		 $(this).delay(2000).fadeOut("slow");
		});
	  return false;
    });													
   });

/* ------------------------------------------------------------------------ */
/* customizer          	  								  	    */
/* ------------------------------------------------------------------------ */
 $('#customize-theme-controls > ul').append('<li id="accordion-section-options" class="accordion-section control-section control-section-onetone-options" style="display: list-item;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box; padding: 10px 10px 20px;background: #fff;">'+onetone_admin_params.go_to_options+'</li>');


// backup theme options
 $(document).on('click','#onetone-backup-btn',function(){
		$('.onetone-backup-complete').hide();								   
		$.ajax({type: "POST",url: onetone_admin_params.ajaxurl,dataType: "html",data: { action: "onetone_options_backup"},	
		success:function(content){
			$('.onetone-backup-complete').show();
            $('#onetone-backup-lists').append(content);
			return false;
			}
		});											   
		return false;											 
   });
 // delete theme options backup
 $(document).on('click','#onetone-delete-btn',function(){
		 if(confirm("Are you sure you want to do this?")){
	     var key = $(this).data('key');								   
		$.ajax({type: "POST",url: onetone_admin_params.ajaxurl,dataType: "html",data: { key:key,action: "onetone_options_backup_delete"},	
		success:function(content){
			$('#tr-'+key).remove();
			return false;
			}
		});											   
		return false;		
		 }
   });
 // restore theme options backup
 $(document).on('click','#onetone-restore-btn',function(){
		 if(confirm("Are you sure you want to do this?")){	
		  var restore_icon = $(this).find('.fa');
		 restore_icon.addClass('fa-spin');
		var key = $(this).data('key');								   
		$.ajax({type: "POST",url: onetone_admin_params.ajaxurl,dataType: "html",data: { key:key,action: "onetone_options_backup_restore"},	
		success:function(content){
			restore_icon.removeClass('fa-spin');
			alert(content);
			window.location.reload();
			return false;
			}
		});											   
		return false;
		}
   });
 
 });