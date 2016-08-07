(function($)
{
// --------------
	$.fn.amaga = function()
	{

		return this.each(function(i,obj)
		{
			$(obj).remove(".cb_hide");
		});

	};
})(jQuery);