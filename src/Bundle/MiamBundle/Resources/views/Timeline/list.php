<ol class="timeline">
    <?php foreach ($timeline as $entry): ?>
        <li class="tentry" id="tentry_<?php echo $entry->getId() ?>">
            <?php echo $entry->getUser()->getUsername() ?>
            <?php echo $entry->renderAction() ?>
            sur
            <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>"><?php echo $story->getName() ?></a>
            de
            <span class="story_project" style="background:<?php echo $story->getProject()->getColor() ?>"><a href="<?php echo $view->router->generate('project', array('id' => $story->getProject()->getId())) ?>"><?php echo $story->getProject()->getName() ?></a></span>
        </li>
    <?php endforeach ?>
</ol>
