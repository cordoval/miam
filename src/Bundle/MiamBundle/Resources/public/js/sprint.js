(function($)
{

  $.widget('ui.sprint',
  {
    _init: function()
    {
      var self = this;
      $('body').append($('<div id="fancy_story">')); 

      setInterval(function()
      {
        $.ajax({
          url: self.element.find('table').attr('data-ping-url').replace(/_HASH_/, self.element.find('table').attr('data-sprint-hash')),
          success: function(html)
          {
            if('noop' == html) return;

            self.element.html(html);
            self.element.sprint('refresh');
          }
        });
      }, 5000);

      this.refresh();
    },

    refresh: function()
    {
      var self = this;

      this.element.find('td div.story').each(function()
      {
        $(this).draggable({
          distance:   5,
          containment: $(this).parent().parent(),
          revert: 'invalid'
        }).dblclick(function()
        {
          $.fancybox.showActivity();
          url = self.element.find('table').attr('data-story-url').replace(/_ID_/, $(this).find('table').attr('data-story-id'));
          $('#fancy_story').html('Loading').load(url, function(){
            $.fancybox.hideActivity();
            $.fancybox({
              'content': $(this).html()
            });
          });
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
              url:     self.element.find('table').attr('data-move-url'),
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
