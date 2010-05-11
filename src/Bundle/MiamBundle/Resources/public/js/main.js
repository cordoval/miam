(function($)
{
  
  $(function()
  {
    $('#stories')
    .sortable({
        handle:     'span.drag',
        axis:       'y',
        update:     function(event, ui) {
            console.debug(event, ui);
        }
    })
    .disableSelection()
    .find('li.story').click(function() {
      $('#backlog').hide();
      $(this).story('show');
    })
    .story();
  });
})(jQuery);