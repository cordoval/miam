<ol class="timeline">
    <?php foreach ($timeline as $index => $entry): ?>
    <li class="tentry<?php !$index && print ' first' ?>" id="tentry_<?php echo $entry->getId() ?>"><?php echo strtr(
        '<strong class="tentry_user">{user}</strong> ' . $entry->renderAction() . ' <span class="date">{date}</span>',
        array(
            '{story}' => '<a href="' . $view->router->generate('story', array('id' => $entry->getStory()->getId())) . '">'. $entry->getStory()->getName() . ' [' . $entry->getStory()->getProject()->getName() . ']</a>',
            '{user}' => $entry->getUser()->getUsername(),
            '{date}' => '<span class="tentry_ago">à ' . $entry->getCreatedAt()->format('H:i') . '</span>',
            '{points}' => $entry->getStory()->getPoints()
        )) ?></li>
    <?php endforeach ?>
</ol>
