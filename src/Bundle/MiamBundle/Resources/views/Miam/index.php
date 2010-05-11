<?php $view->extend('MiamBundle::layout') ?>

<div id="backlog">
    <h1>Backlog</h1>

    <ul id="stories">
        <?php foreach ($stories as $story): ?>
            <li class="story ui-state-default" data-storyId="<?php echo $story->getId() ?>">
          	  #<?php echo $story->getId() ?> − <?php echo $story->getName() ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="story">

</div>