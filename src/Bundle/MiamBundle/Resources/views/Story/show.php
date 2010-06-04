<?php $view->extend('MiamBundle::layout') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">Backlog</a>
  &gt;
  <a id="back_project" href="<?php echo $view->router->generate('project', array('id' => $story->getProject()->getId())) ?>"><?php echo $story->getProject()->getName() ?></a>
  &gt;
  <?php echo $story->getName() ?>
</div>

<div class="titleWithActions">
    <h1 class="story"><?php echo $story->getName() ?></h1>
    <a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">Modifier</a>
    <a title="Supprimer la story" class="js_confirm"  href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
</div>

<div class="story_body">
  <?php echo $view->markdown->transform($story->getBody()) ?>
</div>

<div class="story_timeline">
  <?php $view->output('MiamBundle:Timeline:list', array('timeline' => $timeline, 'emails' => $emails)) ?>
</div>
