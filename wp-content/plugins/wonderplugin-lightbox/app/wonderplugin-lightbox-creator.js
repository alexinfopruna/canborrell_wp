(function($){
	$(document).ready(function() {
		
		$('.wonderplugin-tab-buttons-horizontal').each(function() {
			
			$(this).find('li').each(function(index) {
				
				$(this).click(function(){
										
					if ( $(this).hasClass('wonderplugin-tab-button-horizontal-selected') )
						return;
					
					// switch button
					$(this).parent().find('li').removeClass('wonderplugin-tab-button-horizontal-selected');
					$(this).addClass('wonderplugin-tab-button-horizontal-selected');
					
					// switch panel
					var panelsID = $(this).parent().data('panelsid');	
					$('#' + panelsID).children('li').removeClass('wonderplugin-tab-horizontal-selected');
					$('#' + panelsID).children('li').eq(index).addClass('wonderplugin-tab-horizontal-selected');
					
				});
			});
		});
		
	});
})(jQuery);