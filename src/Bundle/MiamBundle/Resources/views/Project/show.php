<?php $view->extend('MiamBundle::layout') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('projects') ?>">Projets</a>
  &gt;
  <?php echo $project->getName() ?>
</div>

<h1 class="project"><?php echo $project->getName() ?></h1>

<a href="<?php echo $view->router->generate('project_edit', array('id' => $project->getId())) ?>">
    Modifier
</a>