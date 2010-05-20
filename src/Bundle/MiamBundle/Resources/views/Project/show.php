<?php $view->extend('MiamBundle::layout') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">Backlog</a>
  &gt;
  <?php echo $project->getName() ?>
</div>

<h1 class="project">Backlog de <?php echo $project->getName() ?></h1>

<a href="<?php echo $view->router->generate('project_edit', array('id' => $project->getId())) ?>">
    Modifier le projet
</a>

<?php echo $view->render('MiamBundle:Story:backlog', array('stories' => $project->getStories())) ?>
