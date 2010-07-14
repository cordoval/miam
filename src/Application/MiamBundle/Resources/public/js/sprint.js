(function ($) {
    $(function () {
        var sprint = $('#sprint');
        var reloadDelay = 8000;

        setTimeout(reload = function () { 
            $.ajax({
                url: sprint.attr('data-ping-url').replace(/_HASH_/, sprint.attr('data-sprint-hash')),
                success: function (html) {
                    if ('noop' == html) return;
                    if (html) refresh(html);
                    setTimeout(reload, reloadDelay);
                }
            });
        }, reloadDelay);

        function refresh(html) {
            html && sprint.html(html);
            sprint.find('.colSide').tabs({
            });
            var table = sprint.find('div#sprintBacklog table');
            table.find('td div.story').each(function () {
                $(this).draggable({
                    distance: 5,
                    containment: $(this).parent().parent(),
                    revert: 'invalid'
                });
            });
            table.find('td').each(function () {
                var id = $(this).parent().attr('id');

                $(this).droppable({
                    accept: '#' + id + ' div.story',
                    activeClass: 'droppable_active',
                    hoverClass: 'droppable_hover',
                    tolerance: 'intersect',
                    drop: function (e, ui) {
                        ui.draggable.css('opacity', 0.4);
                        $.ajax({
                            type: 'POST',
                            url: table.attr('data-move-url'),
                            data: {
                                story_id: ui.draggable.attr('data-story-id'),
                                status: $(this).attr('data-status')
                            },
                            success: refresh
                        });
                        ui.draggable.css({
                            'left': 0,
                            'top': 0
                        }).appendTo($(this));
                    }
                });
            });
            sprint.find('div.titleWithActions').height(sprint.find('div.colSide ul.tabs').height());
        };
        refresh();
    });
})(jQuery);
