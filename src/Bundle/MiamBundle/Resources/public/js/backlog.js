(function($)
{

  $.widget('ui.backlog',
  {
    _init: function()
    {
        var self = this;
        
        this.element.find('ol.stories').sortable({
            distance:   10,
            axis:       'y',
            update:     function(event, ui) {
                $.ajax({
                   type:    'POST',
                   url:     self.element.attr('data-sort-url'),
                   data:    $(this).sortable('serialize')
                });
            }
        });
    }

  });
})(jQuery);
