<?php $view->extend('MiamBundle::layoutFullpage') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>


<div id="timeline" class="colRight">
  <div id="timeline_close">X</div>
  <?php $view->output('MiamBundle:Timeline:list', array('timeline' => $timeline, 'emails' => $emails)); ?>
</div>

<div id="sprint_current" class="colLeft">
  <?php $view->output('MiamBundle:Sprint:_current', array('sprint' => $sprint, 'projects' => $projects, 'statuses' => $statuses)); ?>    
</div>

<div style="clear:both"></div>
