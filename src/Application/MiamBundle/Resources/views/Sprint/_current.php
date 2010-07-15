<?php
$total = $sprint->getTotalPoints();
$finished = $sprint->getFinishedPoints();
$percentage = $total ? floor($finished/$total*100) : 0;
?>
<div class="colSide">
    <ul class="tabs">
        <li><a href="#timeline">Timeline</a></li>
        <li><a href="#backlog">BackLog</a></li>
    </ul>
    <div id="timeline">
        <?php $view->actions->output('MiamBundle:Timeline:show'); ?>
    </div>
    <div id="backlog">
        <?php $view->actions->output('MiamBundle:Sprint:backlog'); ?>
    </div>
</div>

<div data-sprint-hash="<?php echo $hash ?>" id="sprint_current" class="colCenter">
    <div class="titleWithActions">
        <?php $view->output('MiamBundle:Sprint:_sprintometer', array('percentage' => $percentage)) ?>
        <h1 class="sprint">Backlog de Sprint</h1>
        <span class="finished"><?php echo $finished ?>/<?php echo $total ?></span>
        <a id="editSprint" href="<?php echo $view->router->generate('sprint_schedule') ?>">Modifier</a>
        <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau</a>
    </div>

    <div id="sprintBacklog">
        <div class="headers quarters clearfix">
            <div class="status_pending">En attente (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_PENDING) ?>)</div>
            <div class="status_todo">A faire (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_TODO) ?>)</div>
            <div class="status_wip">En cours (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_WIP) ?>)</div>
            <div class="status_finished">Fait (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_FINISHED) ?>)</div>
        </div>
        <div class="projects">
            <?php foreach($sections as $section): ?>
            <div class="project project_<?php echo $section['project']->getId() ?>" rel="project_<?php echo $section['project']->getId() ?>" data-project-id="<?php echo $section['project']->getId() ?>">
                <div class="project_name" style="background: <?php echo $section['project']->getColor() ?>"><?php echo $section['project']->getName() ?></div>
                <div class="stories">
                    <?php foreach($section['stories'] as $story): ?>
                    <div class="story_line quarters clearfix" rel="story_<?php echo $story->getId() ?>">
                        <?php foreach($statuses as $status => $name): ?>
                        <div data-status="<?php echo $status ?>">
                            <?php if($story->isStatus($status)): ?>
                            <div class="story story_object story_<?php echo $story->getId() ?>" data-story-id="<?php echo $story->getId() ?>">
                                <?php echo $story->getName() ?>
                                <div class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
