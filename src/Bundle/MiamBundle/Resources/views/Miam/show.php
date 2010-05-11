<?php $view->extend('MiamBundle::layout') ?>

<a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">« Retour au backlog</a>

<h1 class="story"><?php echo $story->getName() ?></h1>

<div class="story_body">
  <?php echo $view->markdown->transform($story->getBody()) ?>
</div>

<a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">
    Modifier
</a>