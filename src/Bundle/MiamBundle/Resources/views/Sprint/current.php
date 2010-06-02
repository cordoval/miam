<?php $view->extend('MiamBundle::layout') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>

<?php
    $total = $sprint->getTotalPoints();
    $finished = $sprint->getFinishedPoints();
    $percentage = floor($finished/$total*100);
?>
<div id="sprint_current">
    <div class="titleWithActions">
        <h1 class="sprint">Backlog de Sprint</h1>
        <span class="finished"><?php echo $finished ?>/<?php echo $total ?></span>
        <span class="percentage"><?php echo $percentage ?>%</span>
        <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Changer de sprint</a>
    </div>

<div id="sprintBacklog">
  <?php $view->output('MiamBundle:Sprint:_table', array('sprint' => $sprint, 'projects' => $projects, 'statuses' => $statuses)); ?>    
</div>
</div>
