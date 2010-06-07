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

    $('.focus_me').focus();

    $('.story_object .story_points').live('click', function()
    {
        var oldPoints = $(this).text();
        var points = prompt("Nombre de points pour cette story :", oldPoints);
        if(!points || points == oldPoints) return false;
        if(isNaN(parseInt(points))) {
            alert("Nombre de points invalide : " + points);
            return false;
        }
        $(this).html(points);
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
        $.modal('');
        $.ajax({ url: miam_config.story_url.replace(/_ID_/, storyId), success: function(html) {
            $.modal.close();
            $.modal(html, { overlayClose: true });
        }});

        return false;
    });

})(jQuery);
