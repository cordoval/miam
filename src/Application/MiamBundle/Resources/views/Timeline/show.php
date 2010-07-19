<ol class="timeline">
    <?php foreach ($timeline as $index => $entry): ?>
    <?php $story = $entry->getStory() ?>
    <li class="tentry<?php !$index && print ' first' ?> action_<?php echo $entry->getAction() ?> clearfix" id="tentry_<?php echo $entry->getId() ?>">

        <img class="gravatar" src="<?php echo Bundle\GravatarBundle\Api::getUrl(@$emails[$entry->getUser()->getUsername()], array('size' => 40)) ?>" width="40" height="40"/>
        <div class="title">
        <?php
        $storyUrl = $view->router->generate('story', array('id' => $story->getId()));
        echo strtr(
            '<strong class="tentry_action"><span class="tentry_user">{user}</span> ' . $entry->renderAction() . ' </strong><span class="date">{date}</span>',
            array(
                '{story}' => '',
                '{user}' => $entry->getUser()->getUsername(),
                '{date}' => '<span class="tentry_ago">à ' . $entry->getCreatedAt()->format('H:i') . '</span>',
                '{points}' => $entry->getPoints() ? $entry->getPoints() : '?'
        )) ?>
        </div>
        <div class="story_object story" data-story-id="<?php echo $story->getId() ?>">
            <img src="<?php echo $view->assets->getUrl('bundles/miam/images/domain/'.$story->getDomain().'.png') ?>" alt="<?php echo $story->renderDomain() ?>" class="story_domain_icon" />
            <?php echo $story->getName() ?>
            <span class="story_points"><?php echo $entry->getPoints() ? $entry->getPoints() : '?' ?></span>
        </div>
    </li>
    <?php endforeach ?>
</ol>
