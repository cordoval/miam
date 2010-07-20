<div class="story story_object story_<?php echo $story->getId() ?> story_domain_<?php echo $story->getDomain() ?>" rel="story_<?php echo $story->getId() ?>" data-story-id="<?php echo $story->getId() ?>">
    <img src="<?php echo $view->assets->getUrl('bundles/miam/images/domain/'.$story->getDomain().'.png') ?>" alt="<?php echo $story->renderDomain() ?>" class="story_domain_icon" />
    <?php echo $story->getName() ?>
    <span class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></span>
</div>
