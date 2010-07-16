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
                story_id: $(this).closest('.story_object').attr('data-story-id'),
                points:   points
            }
        });
        $('body').trigger('miam.change');
        return false;
    });

    $('.story_object').live('click', function()
    {
        showStory($(this).attr('data-story-id'));
        return false;
    });

    function showStory(id)
    {
        $.ajax({ url: miam_config.story_url.replace(/_ID_/, id), success: function(html) {
            var dialog = $('<div>').html(html).dialog({
                zIndex: 100,
                dragStart: function(e) { $(e.target).parent().css('opacity', 0.5); },
                dragStop: function(e) { $(e.target).parent().css('opacity', 1); },
                resizable: false,
                width: '500px'
            });
            storyDialog(dialog);
        }});
    }

    function storyDialog(dialog)
    {
        dialog.dialog('option', 'title', dialog.find('.dialog_title').text());
        dialog.find('.dialog_title').remove();
        dialog.find('a.edit, a.cancel').click(function() {
            dialog.load($(this).attr('href'), function() { storyDialog(dialog); });
            return false;
        });
        dialog.find('form').ajaxForm({
            target: dialog,
            success: function() { storyDialog(dialog); $('body').trigger('miam.change'); }
        });
        dialog.find('.focus_me').focus();
        dialog.find('a.delete').click(function() {
            if (confirm(($(this).attr('title')) + ' ?')) {
                $.post($(this).attr('href'), function() { dialog.dialog('close'); $('body').trigger('miam.change'); });
            }
            return false;
        });
    }

})(jQuery);
