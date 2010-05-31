<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'timeline') ?>

<div id="timeline">

    <div class="titleWithActions">
        <h1>Timeline</h1>
    </div>

    <?php echo $view->render('MiamBundle:Timeline:list', array('timeline' => $timeline)) ?>

</div>