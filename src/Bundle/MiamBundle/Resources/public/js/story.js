(function($)
    {

        $.widget('ui.story',
        {
            storyId: null,
    
            _init: function()
            {
                this.storyId = this.element.attr('data-storyId');
            }

        });
    })(jQuery);