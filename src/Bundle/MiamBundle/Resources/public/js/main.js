(function($)
{
    $('#backlog').backlog();

    $('#sprint_current').sprint();

    $('a.js_confirm, input.js_confirm').live('click', function(e)
    {
      e.stopPropagation();
      if (!confirm(($(this).attr('title') || 'Are you sure') + ' ?'))
      {
        return false;
      }

      return true;
    });

})(jQuery);
