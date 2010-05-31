<div class="titleWithActions">
    <h1 class="story"><?php echo $story->getName() ?></h1>
    <a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">Modifier</a>
    <a title="Supprimer la story" class="js_confirm"  href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
</div>

<div class="story_body">
  <?php echo $view->markdown->transform($story->getBody()) ?>
</div>
