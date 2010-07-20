<?php $view->extend('MiamBundle::layout') ?>

<div data-schedule-url="<?php echo $view->router->generate('sprint_schedule') ?>" data-sort-project-url="<?php echo $view->router->generate('project_sort') ?>" data-sort-story-url="<?php echo $view->router->generate('story_sort') ?>" data-move-url="<?php echo $view->router->generate('story_move') ?>" data-ping-url="<?php echo $view->router->generate('sprint_ping', array('hash' => '_HASH_')) ?>" id="sprint" class="clearfix">
    <?php $view->actions->output('MiamBundle:Sprint:ping', array('path' => array('hash' => null))); ?>    
</div>
