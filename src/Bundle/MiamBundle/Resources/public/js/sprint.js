(function($)
{

  $.widget('ui.sprint',
  {
    _init: function()
    {
      var self = this;
      $('body').append($('<div id="fancy_story">')); 
      
      this.element.find('td div.story').each(function()
      {
        var storyId = $(this).attr('data-story-id');
        
        $(this).draggable({
          distance:   5,
          containment: $(this).parent().parent(),
          revert: 'invalid'
        }).dblclick(function()
        {
          $.fancybox.showActivity();
          url = self.element.attr('data-story-url').replace(/_ID_/, $(this).attr('data-story-id'));
          $('#fancy_story').html('Loading').load(url, function(){
            $.fancybox.hideActivity();
            $.fancybox({
              'content': $(this).html()
            });
          });
        });
        
        $(this).find('div.story_points').click(function()
        {
          var oldPoints = $(this).html();
          var points = prompt("Nombre de points pour cette story :", oldPoints);
          if(points && points != oldPoints) {
            if(isNaN(parseInt(points))) {
              alert("Nombre de points invalide : " + points);
              
            } else  {
              $(this).html(points);
              $.ajax({
                type:    'POST',
                url:     self.element.attr('data-reestimate-url'),
                data:    {
                  story_id: storyId,
                  points:   points
                }
              });
            }
          }
        });
      });

      this.element.find('td').each(function()
      {
        var id = $(this).parent().attr('id');

        $(this).droppable({
          accept: '#'+id+' div.story',
          activeClass: 'droppable_active',
          hoverClass: 'droppable_hover',
          tolerance:    'intersect',
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
            ui.draggable.css({'left': 0, 'top': 0}).appendTo($(this));
          }
        });
      });
    }

  });
})(jQuery);
