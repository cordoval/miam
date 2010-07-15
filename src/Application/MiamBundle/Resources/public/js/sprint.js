(function ($) {
    $(function () {
        var sprint = $('#sprint');
        var reloadDelay = 80000;
        var selectedTabIndex = 0;

        setTimeout(reload = function () { 
            $.ajax({
                url: sprint.attr('data-ping-url').replace(/_HASH_/, sprint.find('#sprint_current').attr('data-sprint-hash')),
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
                select: function(e, ui) { selectedTabIndex = ui.index; },
                selected: selectedTabIndex
            });
            var table = sprint.find('div#sprintBacklog div.projects');
            table.find('div.story').each(function () {
                $(this).draggable({
                    distance: 5,
                    containment: $(this).parent().parent(),
                    revert: 'invalid',
                    axis: 'x'
                });
            }).disableSelection();
            table.find('div.story_line > div').each(function () {
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
                            url: sprint.attr('data-move-url'),
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
            table.find('.stories').each(function() {
                var projectId = $(this).parent().attr('data-project-id');
                $(this).sortable({
                    distance: 5,
                    connectWith: '#backlog .project_'+projectId+'.stories',
                    update: function(e, ui) {
                        if(!ui.sender) {
                            $.ajax({
                                type: 'POST',
                                url:        sprint.attr('data-sort-story-url'),
                                data:       $(this).sortable('serialize', { attribute: 'rel' }),
                                success:    refresh
                            });
                        }
                        else {
                            if(ui.item.find('.story_points').text() == '?') {
                                alert('This story has no points!');
                                return;
                            }
                            $.ajax({
                                type: 'POST',
                                url:        sprint.attr('data-schedule-url'),
                                data:       { story_id: ui.item.attr('data-story-id') },
                                success: refresh
                            });
                        }
                    }
                }).disableSelection();
            });
            $('#backlog .stories').each(function() {
                var projectId = $(this).parent().attr('data-project-id');
                $(this).sortable({
                    distance: 5,
                    connectWith: '#sprint_current .project_'+projectId+' .stories',
                    update: function(e, ui) {
                        $.ajax({
                            type: 'POST',
                            url:        sprint.attr('data-sort-story-url'),
                            data:       $(this).sortable('serialize', { attribute: 'rel' }),
                            success:    refresh
                        });
                    }
                }).disableSelection();
            });
            table.sortable({
                axis: 'y',
                distance: 5,
                update: function(e, ui) {
                    $.ajax({
                        type: 'POST',
                        url:        sprint.attr('data-sort-project-url'),
                        data:       $(this).sortable('serialize', { attribute: 'rel' }),
                        success:    refresh
                    });
                }
            }).disableSelection();

            sprint.find('div.titleWithActions').height(sprint.find('div.colSide ul.tabs').height());
        };
        refresh();
    });
})(jQuery);
