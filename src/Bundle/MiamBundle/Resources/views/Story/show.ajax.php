<div class="story_title"><?php echo $story->getName() ?></div>

<div class="story_body clearfix">
    <?php echo $view->markdown->transform($story->getBody()) ?>
    <div class="story_infos">
        Créé le <?php echo $story->getCreatedAt()->format('d F à H\hi') ?>
        <?php if(!empty($timeline)): ?>
            par <?php echo $timeline[count($timeline)-1]->getUser()->getUsername() ?>
        <?php endif; ?>
    </div>
    <div class="story_actions">
        <a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">Modifier</a>
        <a title="Supprimer la story" class="js_confirm"  href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
    </div>
</div>

<div class="story_timeline">
  <?php $view->output('MiamBundle:Timeline:list', array('timeline' => $timeline, 'emails' => $emails, 'disable' => true)) ?>
</div>
