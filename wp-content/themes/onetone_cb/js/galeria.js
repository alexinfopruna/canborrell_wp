/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var ajaxgaleria = {"ajaxurl":"http:\/\/wordpress.local\/wp-admin\/admin-ajax.php"};

jQuery(document).ready( function($) {
    $("#gallery .img-frame a").click(load_galeria);
     
    $("#galeria-ajax").hide("slow");
    function load_galeria(e){
        $("#galeria-ajax").remove();
    $("#gallery .section-subtitle").append('<div id="galeria-ajax" class="well"></div>');
        ajaxgaleria = $(this).attr("href");
        //alert(ajaxgaleria);
        $("#galeria-ajax").html('<img src="/wp-content/plugins/photo-gallery/images/ajax_loader.gif" class="loading"/>');
        
	$.ajax({
		url: ajaxgaleria,
		type: 'post',
		data: {
			action: 'ajax_galeria'
		},
		success: function( result ) {
                    $("#galeria-ajax").hide();
                        $("#galeria-ajax").html(result).fadeIn("slow");//show('slow');
                        $('html, body').animate({
    scrollTop: $("#gallery").offset().top
}, 1000);
$("#gallery-close").click(function(){  $("#galeria-ajax").fadeOut("slow");});
                        
		}

});//function

      // alert(gallery_texts.exterior);
        e.preventDefault();
        return false;
    }


/*
var titol = ['Exterior','Interior','Cuina','Graelles','Equip','Plats'];
var i=0;

$("#gallery .img-box a").each(function(){$( this ).attr('title',titol[i]);i++;});
$("#gallery .img-box a").hover(function(){
	//alert($(this).index("#gallery .img-box a"));
        })        ;
        */
       
       $("#mbYTP_onetone-youtube-video").css("bacground","black");
})
