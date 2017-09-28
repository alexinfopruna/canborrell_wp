( function( $ ) {
var api = wp.customize, ids, sectionChanged = false;
$(document).on('click','#sub-accordion-section-onetone_sections_order .repeater-row-remove',function(){
	var listParent = $(this).parents('ul.repeater-fields');
	var id    = $(this).parents('li.repeater-row').find('input[data-field="id"]').val();
	var type  = $(this).parents('li.repeater-row').find('select[data-field="type"]').val();
	var removedIds = listParent.data('removed');
	ids = id+':'+type;
	if(removedIds!=='' && removedIds!==undefined){
		ids = removedIds+','+ids;
		}
	listParent.attr( 'data-removed',ids );
	sectionChanged = true;
});
	

$('#customize-control-onetone_pro-section_order .repeater-fields li').each(function(index, element) {
		var idInput   = $(this).find('input[data-field="id"]');
		idInput.attr('readonly','true');
    });

$(document).on('click','#sub-accordion-section-onetone_sections_order .repeater-add',function(){
	var sectionIDs = [];
	$('#customize-control-onetone_pro-section_order .repeater-fields li').each(function(index, element) {
		var idInput   = $(this).find('input[data-field="id"]');
		idInput.attr('readonly','true');
		if(idInput.val() !='')
			sectionIDs.push( parseInt(idInput.val()) ); 
    });
	
	 setTimeout(function(){
		  var maxID = Math.max.apply(null, sectionIDs);
		  var inputSection = $('#customize-control-onetone_pro-section_order .repeater-fields li input[data-field="id"]');
		  var newSection = $('#customize-control-onetone_pro-section_order .repeater-fields li:last input[data-field="id"]');
		  
		  maxID = maxID+1;
		  newSection.val(maxID).trigger("change");
		  inputSection.attr('readonly','true');

		 }, 1000);
	sectionChanged = true;
});

	wp.customize.bind( 'saved', function( d ){
	if( ids !=='' ){
		$.ajax({
			url: ajaxurl,
			type: 'post',
			dataType: 'html',
			data: {
				action: 'onetone_remove_sections',
				ids: ids
			},success: function(e){
				console.log(e);
				$('#customize-control-onetone_pro-section_order ul.repeater-fields').attr('data-removed','');
				}
		});
	}
	if(sectionChanged == true ){
		var sections =  new Array();
		$('#customize-control-onetone_pro-section_order .repeater-fields li.repeater-row').each(function(index, element) {
			sections[index] = {'id':$(this).find('input[data-field="id"]').val(),'type':$(this).find('select[data-field="type"]').val()};
    	});
		
		$.ajax({
			url: ajaxurl,
			type: 'post',
			dataType: 'html',
			data: {
				action: 'onetone_create_wpml',
				sections: sections
			},success: function(e){
				console.log(e);
				}
    });
		}
});


} )( jQuery );