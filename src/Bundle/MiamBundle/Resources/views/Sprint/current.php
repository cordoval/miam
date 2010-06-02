<?php $view->extend('MiamBundle::layout') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>

<div id="sprint_current">
  <?php $view->output('MiamBundle:Sprint:_current', array('sprint' => $sprint, 'projects' => $projects, 'statuses' => $statuses)); ?>    
</div>
