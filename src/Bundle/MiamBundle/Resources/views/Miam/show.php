<?php if(!$decorate) $view->extend('MiamBundle::layout') ?>

<a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">« Retour au backlog</a>

<h1 class="story"><?php echo $story->getName() ?></h1>

<div class="story_body">
  <?php echo $story->getBody() ?>
</div>