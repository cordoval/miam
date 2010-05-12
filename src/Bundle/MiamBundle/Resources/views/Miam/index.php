<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'backlog') ?>

<div id="backlog" data-sort-url="<?php echo $view->router->generate('story_sort') ?>">
    <h1>Backlog</h1>

    <ol class="stories">
        <?php foreach ($stories as $story): ?>
            <li class="story" id="story_<?php echo $story->getId() ?>">
                <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">
                    #<?php echo $story->getId() ?> − <?php echo $story->getName() ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</div>