(function($)
{

  $.widget('ui.story',
  {
    storyId: null,
    
    _init: function()
    {
      this.storyId = this.element.attr('data-storyId');

      this.element.append($('<span>').addClass('drag'))
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