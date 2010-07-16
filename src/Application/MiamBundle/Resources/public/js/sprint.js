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
            sprint.find('div.titleWithActions').height(sprint.find('div.colSide ul.tabs').height());

            var table = sprint.find('div#sprintBacklog div.projects');
            sprint.find('div.stories').each(function() {
                var projectId = $(this).closest('.project').attr('data-project-id');
                var status = $(this).closest('.status').attr('data-status');
                $(this).sortable({
                    distance: 5,
                    connectWith: 'div.project_'+projectId+' div.stories',
                    helper: 'clone',
                    placeholder: 'story_placeholder',
                    update: function(e, ui) {
                        if(ui.sender) {
                            if(ui.item.find('.story_points').text() == '?') {
                                alert('This story has no points!');
                                return;
                            }
                            $.ajax({
                                type: 'POST',
                                url:        sprint.attr('data-schedule-url')+'?'+$(this).sortable('serialize', { attribute: 'rel' }),
                                data:       { story_id: ui.item.attr('data-story-id'), status: status },
                                success: refresh
                            });
                        }
                        else if(status == ui.item.closest('.status').attr('data-status')) {
                            $.ajax({
                                type: 'POST',
                                url:        sprint.attr('data-sort-story-url'),
                                data:       $(this).sortable('serialize', { attribute: 'rel' }),
                                success:    refresh
                            });
                        }
                    }
                }).disableSelection();
            });
            sprint.find('div.projects').sortable({
                axis: 'y',
                handle: '.project_name',
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
        };
        refresh();
    });
})(jQuery);
