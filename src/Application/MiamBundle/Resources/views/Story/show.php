<div class="dialog_title"><?php echo $story->getName() ?> (<?php echo $story->getPoints() ?>)</div>
<div class="story_body clearfix">
    <?php echo $view->markdown->transform($story->getRawValue()->getBody()) ?>
    <div class="story_infos">
        Créé le <?php echo $story->getCreatedAt()->format('d F à H\hi') ?>
        <?php if(count($timeline)): ?>
            par <?php echo $timeline[count($timeline)-1]->getUser()->getUsername() ?>
        <?php endif; ?>
    </div>
    <div class="story_actions">
        <a class="edit" href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">Modifier</a>
        <?php if(!$story->isDeleted()): ?>
            <a title="Supprimer la story" class="delete" href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
        <?php endif; ?>
    </div>
</div>

<div class="story_timeline">
  <?php $view->output('MiamBundle:Timeline:show', array('timeline' => $timeline, 'emails' => $emails, 'disable' => true)) ?>
</div>
