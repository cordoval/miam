(function($)
{

  $.widget('ui.story',
  {
    storyId: null,
    
    _init: function()
    {
      this.storyId = $.evalJSON(this.element.attr('data-storyId'));
      $.extend(this.options, stories[this.storyId]);
    },

    show: function()
    {
      $.ajax({
        url: this.options.url_show,
        success: function(data) {
           $('#story').html(data);
           $('#back_backlog').click(function() {
             $('#story').hide();
             $('#backlog').show();
           })
         }
      });
    }

  });
})(jQuery);