(function($)
{

  $.widget('ui.story',
  {
    storyId: null,
    data: {},
    
    _init: function()
    {
      this.storyId = $.evalJSON(this.element.attr('data-storyId'));
      $.extend(this.data, stories[this.storyId]);
    },

    show: function()
    {
      $.ajax({
        url: this.data.url_show
      });
    }

  });
})(jQuery);