<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'timeline') ?>

<div id="timeline">

    <div class="titleWithActions">
        <h1>Timeline</h1>
    </div>
    <?php $view->actions->output('MiamBundle:Timeline:_list', array('timeline' => $timeline, 'emails' => $emails)) ?>

</div>
