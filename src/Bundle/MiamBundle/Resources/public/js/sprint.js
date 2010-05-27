(function($)
{

  $.widget('ui.sprint',
  {
    _init: function()
    {
        var self = this;
        
        this.element.find('td div.story').draggable({
            distance:   10,
            axis:       'x',
            update:     function(event, ui) {
                $.ajax({
                   type:    'POST',
                   url:     self.element.attr('data-move-url'),
                   data:    $(this).sortable('serialize')
                });
            }
        });

        this.element.find('td').each(function()
        {
          var id = $(this).parent().attr('id');

          $(this).droppable({
            accept: '#'+id+' div.story',
            activeClass: 'droppable_active',
            hoverClass: 'droppable_hover',
            //          tolerance:    'touch',
            drop: function(e, ui)
            {
                $.ajax({
                   type:    'POST',
                   url:     self.element.attr('data-move-url'),
                   data:    {
                     story_id: ui.draggable.attr('data-story-id'),
                     status:   $(this).attr('data-status')
                   }
                });
             }
          });
       });
    }

  });
})(jQuery);
