(function($)
{
  $.evalJSON = function(src)
  {
      if (typeof(JSON) == 'object' && JSON.parse)
          return JSON.parse(src);
      return eval("(" + src + ")");
  };
  
  $(function()
  {
    $('#stories').sortable();
		$('#stories').disableSelection();
		$('li.story')
  		.click(function() { $(this).story('show'); })
  		.story()
  		;
  });
})(jQuery);