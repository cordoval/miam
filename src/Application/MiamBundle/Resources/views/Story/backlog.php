<div class="projects">
<?php foreach($sections as $section): ?>
    <div class="project project_<?php echo $section['project']->getId() ?>" data-project-id="<?php echo $section['project']->getId() ?>">
        <div class="project_name" style="background: <?php echo $section['project']->getColor() ?>">
            <?php echo $section['project']->getName() ?>
        </div>
        <ul class="stories" data-project-id="<?php echo $section['project']->getId() ?>">
        <?php foreach ($section['stories'] as $story): ?>
            <li class="story story_object story_<?php echo $story->getId() ?>" rel="story_<?php echo $story->getId() ?>" data-story-id="<?php echo $story->getId() ?>">
                <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>"><?php echo $story->getName() ?></a>
                <span class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></span>
            </li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endforeach ?>
</div>
