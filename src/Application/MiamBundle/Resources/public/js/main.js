(function($)
{
    $('a.js_confirm, input.js_confirm').live('click', function(e)
    {
      e.stopPropagation();
      if (!confirm(($(this).attr('title') || 'Are you sure') + ' ?'))
      {
        return false;
      }

      return true;
    });

    $('.focus_me').focus();

    $('.story_object .story_points').live('click', function()
    {
        var oldPoints = $(this).text();
        var points = prompt("Nombre de points pour cette story :", oldPoints);
        if('?' == points) points = 0;
        if(null == points || isNaN(points) || points == oldPoints) return false;
        $(this).html(0 != points ? points : '?');
        $.ajax({
            type:    'POST',
            url:    miam_config.story_reestimate_url, 
            data:    {
                story_id: $(this).closest('.story').attr('data-story-id'),
                points:   points
            }
        });
        return false;
    });

    $('.story_object').live('click', function()
    {
        var storyId = $(this).attr('data-story-id');
        var dialog = $('<div>').dialog({
            zIndex: 100,
            dragStart: function(e) { $(e.target).parent().css('opacity', 0.5); },
            dragStop: function(e) { $(e.target).parent().css('opacity', 1); },
            resizable: false,
            width: '500px',
            title: $(this).text()
        });
        $.ajax({ url: miam_config.story_url.replace(/_ID_/, storyId), success: function(html) {
            dialog.html(html);
        }});

        return false;
    });

})(jQuery);
