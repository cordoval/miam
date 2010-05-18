<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'backlog') ?>

<div id="backlog" data-sort-url="<?php echo $view->router->generate('story_sort') ?>">
    <h1>Backlog</h1>

    <ol class="stories">
        <?php foreach ($stories as $story): ?>
            <li class="story" id="story_<?php echo $story->getId() ?>">
                <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">#<?php echo $story->getId() ?> − <?php echo $story->getName() ?></a>
                <span class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></span>
                <span class="editLink"><a href="<?php echo $view->router->generate('story_edit', array('id' => $story->getId())) ?>">modifier</a></span>
            </li>
        <?php endforeach ?>
    </ol>
</div>