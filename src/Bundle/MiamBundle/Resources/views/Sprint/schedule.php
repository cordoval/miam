<?php $view->extend('MiamBundle::layoutFullpage') ?>
<?php $view->slots->set('active_menu', 'sprint_schedule') ?>

<div id="scheduling">
    <div class="titleWithActions">
        <h1>Backlog / Planification de sprint</h1>
        <a id="newSprint" href="<?php echo $view->router->generate('story_new') ?>">Créer une story</a>
    </div>

    <div class="col col_left">
        <h2>Story candidate</h2>

        <?php if($story): ?>
        <div class="story story_planCard">
            <?php echo $story->getName() ?>
            <div class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></div>
        </div>
        <form id="story_actions" action="<?php echo $view->router->generate('sprint_addStory') ?>" method="put">
            <input type="hidden" name="story[id]" value="<?php echo $story->getId() ?>" />
            <input type="submit" name="todo" id="addStory" value="Ajouter au sprint &rarr;" />
            <input type="submit" name="pending" id="addStoryPending" value="Ajouter au sprint (en attente) &rarr;" />
        </form>
        <?php else: ?>
        <div>
            Il ne reste rien dans le backlog. Va travailler maintenant.
        </div>
        <?php endif ?>
    </div>
    
    <div class="col col_right">
        <h2>Sprint en cours</h2>
        <ul>
            <li><strong>Dates :</strong> <?php echo $sprint->getStartsAt()->format('d/m/Y') ?> au <?php echo $sprint->getEndsAt()->format('d/m/Y') ?></li>
            <li><strong>Points :</strong> <span id="sprint_points"><?php echo $sprint->getRemainingPoints() ?></span></li>
        </ul>
    </div>

    <div style="clear:both"></div>
    
    <div class="col col_left" id="backlog" data-sort-url="<?php echo $view->router->generate('story_sort') ?>">
        <h2>Backlog</h2>
        <?php $view->output('MiamBundle:Sprint:_listStories', array('stories' => $backlogStories)) ?>
    </div>
    
    <div class="col col_right">
        <h2>Backlog de sprint</h2>
        <?php $view->output('MiamBundle:Sprint:_listStories', array('stories' => $sprintStories)) ?>
    </div>
    
    
    <div style="clear:both"></div>
</div>
