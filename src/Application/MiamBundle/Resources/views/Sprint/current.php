<?php $view->extend('MiamBundle::layout') ?>

<div data-move-url="<?php echo $view->router->generate('story_move') ?>" data-ping-url="<?php echo $view->router->generate('sprint_ping', array('hash' => '_HASH_')) ?>" data-sprint-hash="<?php echo $hash ?>" id="sprint">
    <?php $view->output('MiamBundle:Sprint:_current', array('sprint' => $sprint, 'projects' => $projects, 'statuses' => $statuses)); ?>    
</div>
