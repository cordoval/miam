<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>

<div id="sprint_current">
    <h1>Current Sprint</h1>

    <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau sprint</a>
</div>
