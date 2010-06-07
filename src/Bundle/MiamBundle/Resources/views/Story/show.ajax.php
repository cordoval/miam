<div class="titleWithActions">
    <a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">Modifier</a>
    <a title="Supprimer la story" class="js_confirm"  href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
    <h1 class="story_title"><?php echo $story->getName() ?></h1>
</div>

<div class="story_body">
  <?php echo $view->markdown->transform($story->getBody()) ?>
</div>

<div class="story_timeline">
  <?php $view->output('MiamBundle:Timeline:list', array('timeline' => $timeline, 'emails' => $emails)) ?>
</div>
