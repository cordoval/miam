<div id="scheduling">
    <div class="col col_right">
        <h2>Sprint en cours</h2>
        <ul>
            <li><strong>Dates :</strong> <?php echo $sprint->getStartsAt()->format('d/m/Y') ?> au <?php echo $sprint->getEndsAt()->format('d/m/Y') ?></li>
            <li><strong>Points :</strong> <span id="sprint_points"><?php echo $sprint->getRemainingPoints() ?></span></li>
        </ul>
    </div>
    
    <div class="titleWithActions">
        <h1>Backlog / Planification de sprint</h1>
        <a id="newSprint" href="<?php echo $view->router->generate('story_new') ?>">Créer une story</a>
    </div>
    
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
