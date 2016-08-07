(function($)
{
// --------------
	$.fn.amaga = function()
	{

		return this.each(function(i,obj)
		{
			$(obj).hide();
			return false;
			
			var pp=$('<div class="cb_hide"></div>');
			var w=$(obj).width();
			var h=$(obj).height();
			pp.width(w+4);
			pp.height(h+4);
			$(obj).prepend(pp);
		});

	};
})(jQuery);