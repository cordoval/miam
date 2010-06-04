<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'sprint_schedule') ?>

<div id="backlog" data-sort-url="<?php echo $view->router->generate('story_sort') ?>">

    <div class="titleWithActions">
        <h1>Backlog</h1>
        <a id="newSprint" href="<?php echo $view->router->generate('story_new') ?>">Créer une story</a>
    </div>

    <?php echo $view->render('MiamBundle:Story:backlog', array('stories' => $stories)) ?>

</div>
