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
        <?php if(!$story->isDeleted()): ?>
            <a title="Supprimer la story" class="js_confirm"  href="<?php echo $view->router->generate('story_delete', array('id' => $story->getId())) ?>">Supprimer</a>
        <?php endif; ?>
        <?php if($story->isScheduled()): ?>
            <a title="Retirer la story du sprint" class="js_confirm" href="<?php echo $view->router->generate('sprint_unschedule', array('id' => $story->getId())) ?>">Déplanifier</a> 
        <?php endif; ?>
    </div>
</div>
<?php if (!$story->isScheduled()): ?>
<div class="story_schedule">
    <a title="Planifier la story à faire" href="<?php echo $view->router->generate('sprint_addStory', array('id' => $story->getId(), 'pending' => false)) ?>">Planifier (à faire)</a>
    <a title="Planifier la story en attente" href="<?php echo $view->router->generate('sprint_addStory', array('id' => $story->getId(), 'pending' => true)) ?>">Planifier (en attente)</a>
</div>
<?php endif; ?>

<div class="story_timeline">
  <?php $view->output('MiamBundle:Timeline:list', array('timeline' => $timeline, 'emails' => $emails, 'disable' => true)) ?>
</div>
