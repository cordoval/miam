<ol class="stories">
    <?php foreach ($stories as $story): ?>
        <li class="story" id="story_<?php echo $story->getId() ?>">
            <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>"><?php echo $story->getName() ?></a>
            <span class="story_project" style="background:<?php echo $story->getProject()->getColor() ?>"><a href="<?php echo $view->router->generate('project', array('id' => $story->getProject()->getId())) ?>"><?php echo $story->getProject()->getName() ?></a></span>
            <span class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></span>
            <span class="editLink"><a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">modifier</a></span>
        </li>
    <?php endforeach ?>
</ol>
