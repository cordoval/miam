(function ($) {
    $(function () {
        var sprint = $('#sprint');
        var current = $('#sprint_current');
        var reloadDelay = 3000;
        var selectedTabIndex = 0;

        function reload(callback, force) {
        console.debug(current.attr('data-sprint-hash'));
            $.ajax({
                url: sprint.attr('data-ping-url').replace(/_HASH_/, force ? 'force' : current.attr('data-sprint-hash')),
                success: function (html) {
                    if (html && 'noop' != html) refresh(html);
                    if($.isFunction(callback)) callback();
                }
            });
        }

        function resize() {
            current.width($('body').width() - current.offset().left - 15);
        }

        function editionDialog(dialog)
        {
            dialog.dialog('option', 'title', dialog.find('.dialog_title').text());
            dialog.find('.dialog_title').remove();
            dialog.find('form.ajax_form').ajaxForm({
                success: function(data) {
                    if(data == 'ok') {
                        dialog.dialog('close');
                        $('body').trigger('miam.change');
                    }
                    else {
                        dialog.html(data);
                        editionDialog(dialog);
                    }
                }
            });
            dialog.find('.focus_me').focus();
        }

        setTimeout(ping = function () { 
            reload(function() {setTimeout(ping, reloadDelay);});
        }, reloadDelay);

        $('body').bind('miam.change', reload);

        function refresh(html) {
            html && sprint.html(html);
            var table = sprint.find('div#sprintBacklog div.projects');
            current = $('#sprint_current');
            sprint.find('.colSide').tabs({
                select: function(e, ui) { selectedTabIndex = ui.index; },
                selected: selectedTabIndex
            });
            sprint.find('div.titleWithActions').height(sprint.find('div.colSide ul.tabs').height());
            sprint.find('div.stories').each(function() {
                var projectId = $(this).closest('.project').attr('data-project-id');
                var status = $(this).closest('.status').attr('data-status');
                $(this).sortable({
                    distance: 5,
                    connectWith: 'div.project_'+projectId+' div.stories',
                    helper: 'clone',
                    placeholder: 'story_placeholder',
                    receive: function(e, ui) {
                        var points = ui.item.find('.story_points').text();
                        if(points == '?') {
                            points = prompt("Nombre de points pour cette story :", points);
                            if(!points || isNaN(points)) {
                                reload(null, true);
                                return;
                            }
                            ui.item.find('.story_points').text(points);
                        }
                        $.ajax({
                            type: 'POST',
                            url:        sprint.attr('data-schedule-url')+'?'+$(this).sortable('serialize', { attribute: 'rel' }),
                            data:       { story_id: ui.item.attr('data-story-id'), status: status, points: ui.item.find('.story_points').text() },
                            success: refresh
                        });
                    },
                    update: function(e, ui) {
                        if(!ui.sender && status == ui.item.closest('.status').attr('data-status')) {
                            $.ajax({
                                type: 'POST',
                                url:        sprint.attr('data-sort-story-url'),
                                data:       $(this).sortable('serialize', { attribute: 'rel' }),
                                success:    refresh
                            });
                        }
                    }
                })
                .disableSelection();
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

            sprint.find('div.statuses').each(function() {
                var height = $(this).height();
                $(this).find('div.stories').css('min-height', (height-5)+'px');
            });
            $('#sprint .story_new, #sprint .sprint_new').click(function() {
                $.ajax({ url: $(this).attr('href'), success: function(html) {
                    var dialog = $('<div>').html(html).dialog({
                        zIndex: 100,
                        dragStart: function(e) { $(e.target).parent().css('opacity', 0.5); },
                        dragStop: function(e) { $(e.target).parent().css('opacity', 1); },
                        resizable: false,
                        width: '500px'
                    });
                    editionDialog(dialog);
                }});
                return false;
            });
            $('div.colSide').resizable({
                handles: 'e',
                helper: 'ui-resizable-helper',
                stop: function(e, ui) {
                   setTimeout(function(){current.css('margin-left', ($('div.colSide').width()+30)+'px'); resize();}, 100);
                }
            });
            $('#filters input').button().bind('change', function() {
                var classes = [];
                $('#filters input:checked').each(function() {
                    classes.push('div.story_domain_'+$(this).val());
                });
                var selector = classes.length ? classes.join(', ') : 'div.story';
                $('#backlog div.project, #sprintBacklog div.project').each(function() {
                    var $this = $(this);
                    var visibleStories = $this.find(selector);
                    $this.find('div.story').hide();
                    visibleStories.show();
                    $this[visibleStories.length ? 'show' : 'hide']();
                    $('.nb_filters').text(classes.length || '*');
                    resize();
                });
            }).first().trigger('change');
        };
        refresh();
    });
})(jQuery);
