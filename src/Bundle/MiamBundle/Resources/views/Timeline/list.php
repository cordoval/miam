<ol class="timeline">
    <?php foreach ($timeline as $index => $entry): ?>
    <li class="tentry<?php !$index && print ' first' ?> clearfix" id="tentry_<?php echo $entry->getId() ?>">

        <img class="gravatar" src="<?php echo Bundle\GravatarBundle\Api::getUrl($emails[$entry->getUser()->getUsername()], array('size' => 40)) ?>" width="40" height="40"/>
        <div class="title">
        <?php
        $storyUrl = $view->router->generate('story', array('id' => $entry->getStory()->getId()));
        echo strtr(
            '<strong class="tentry_user">{user} ' . $entry->renderAction() . ' </strong><span class="date">{date}</span>',
            array(
                '{story}' => '<a href="' . $storyUrl . '">#'. $entry->getStory()->getId().'</a>',
                '{user}' => $entry->getUser()->getUsername(),
                '{date}' => '<span class="tentry_ago">à ' . $entry->getCreatedAt()->format('H:i') . '</span>',
                '{points}' => $entry->getStory()->getPoints()
        )) ?>
        </div>
        <div class="details">
            <a href="<?php echo $storyUrl ?>"><?php echo $entry->getStory()->getName() ?></a>
            <span class="points"><?php echo $entry->getStory()->getPoints() ?></span>
        </div>
    </li>
    <?php endforeach ?>
</ol>
