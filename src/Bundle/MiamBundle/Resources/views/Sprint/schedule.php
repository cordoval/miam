<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'sprint_schedule') ?>

<div id="scheduling">
    <h1>Planification de sprint</h1>

    <h2>Ajouter une story</h2>

    <div class="story_planCard">
        <h3 class="story"><?php echo $story->getName() ?></h3>

        <div class="story_body">
          <?php echo $view->markdown->transform($story->getBody()) ?>
        </div>
    </div>
    
    <div id="scheduling_backlog">
        <h2>Backlog</h2>
        <?php $view->output('MiamBundle:Story:backlog', array('stories' => $backlogStories)) ?>
    </div>

    <div id="scheduling_sprint">
        <h2>Sprint</h2>
        <?php $view->output('MiamBundle:Story:backlog', array('stories' => $sprintStories)) ?>
    </div>
    
    <div style="clear:both"></div>
</div>