<ol class="timeline">
    <?php foreach ($timeline as $index => $entry): ?>
    <li class="tentry<?php !$index && print ' first' ?>" id="tentry_<?php echo $entry->getId() ?>"><?php echo strtr(
                '<b class="tentry_user">{user}</b> ' . $entry->renderAction() . ' {date}',
                array(
              '{story}' => '<a href="' . $view->router->generate('story', array('id' => $entry->getStory()->getId())) . '">'. $entry->getStory()->getName() . ' [' . $entry->getStory()->getProject()->getName() . ']</a>',
              '{user}' => $entry->getUser()->getUsername(),
              '{date}' => '<span class="tentry_ago">à ' . $entry->getCreatedAt()->format('H:i') . '</span>',
        )) ?></li>
    <?php endforeach ?>
</ol>
