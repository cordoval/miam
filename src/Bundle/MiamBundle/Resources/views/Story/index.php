<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'backlog') ?>

<div id="backlog" data-sort-url="<?php echo $view->router->generate('story_sort') ?>">
    <h1>Backlog</h1>

    <?php $view->output('MiamBundle:Story:backlog', array('stories' => $stories)) ?>

</div>