(function($)
{

  $.widget('ui.sprint',
  {
    _init: function()
    {
      var self = this;
      $('body').append($('<div id="fancy_story">').hide()); 

      $('#timeline_close').click(function(){
        $('.colRight').hide();
      });
      
      setInterval(function()
      {
        self.element.sprint('reload');
      }, 5000);

      this.refresh();
    },

    reload: function()
    {
      var self = this;
      $.ajax({
        url: self.table.attr('data-ping-url').replace(/_HASH_/, self.table.attr('data-sprint-hash')),
        success: function(html)
        {
          if('noop' == html) return;

          self.element.html(html);
          self.element.sprint('refresh');
        }
      });
    },

    refresh: function()
    {
      var self = this;
      self.table = self.element.find('table');

      this.element.find('td div.story').each(function()
      {
        var storyId = $(this).attr('data-story-id');
        
        $(this).draggable({
          distance:   5,
          containment: $(this).parent().parent(),
          revert: 'invalid'
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
            ui.draggable.css('opacity', 0.4);
            $.ajax({
              type:    'POST',
              url:     self.table.attr('data-move-url'),
              data:    {
                story_id: ui.draggable.attr('data-story-id'),
                status:   $(this).attr('data-status')
              },
              success: function(html)
              {
                self.element.html(html);
                self.element.sprint('refresh');
              }
            });
            ui.draggable.css({'left': 0, 'top': 0}).appendTo($(this));
          }
        });
      });
    }
  });
})(jQuery);
