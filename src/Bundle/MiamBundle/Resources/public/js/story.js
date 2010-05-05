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
        url: this.options.url_show
      });
    }

  });
})(jQuery);