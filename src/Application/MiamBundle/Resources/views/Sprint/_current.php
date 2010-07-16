<?php
$total = $sprint->getTotalPoints();
$finished = $sprint->getFinishedPoints();
$percentage = $total ? floor($finished/$total*100) : 0;
?>
<div class="colSide">
    <a href="<?php echo $view->router->generate('story_new') ?>" class="story_new" title="Add story"></a>
    <ul class="tabs">
        <li><a href="#timeline">Timeline</a></li>
        <li><a href="#backlog">BackLog</a></li>
    </ul>
    <div id="timeline">
        <?php $view->actions->output('MiamBundle:Timeline:show'); ?>
    </div>
    <div id="backlog">
        <div class="projects">
            <?php foreach($sections as $section): ?>
            <div class="project project_<?php echo $section['project']->getId() ?>" rel="project_<?php echo $section['project']->getId() ?>" data-project-id="<?php echo $section['project']->getId() ?>">
                <div class="project_name" style="background: <?php echo $section['project']->getColor() ?>"><?php echo $section['project']->getName() ?></div>
                <div class="status status_10" data-status="10">
                    <div class="stories" data-project-id="<?php echo $section['project']->getId() ?>">
                        <?php foreach ($section['stories'] as $story): ?>
                        <?php if($story->isStatus(Application\MiamBundle\Entities\Story::STATUS_CREATED)): ?>
                        <div class="story story_object story_<?php echo $story->getId() ?>" rel="story_<?php echo $story->getId() ?>" data-story-id="<?php echo $story->getId() ?>">
                            <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>"><?php echo $story->getName() ?></a>
                            <span class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></span>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div data-sprint-hash="<?php echo $hash ?>" id="sprint_current" class="colCenter">
    <div class="titleWithActions">
        <?php $view->output('MiamBundle:Sprint:_sprintometer', array('percentage' => $percentage)) ?>
        <h1 class="sprint">Backlog de Sprint</h1>
        <span class="finished"><?php echo $finished ?>/<?php echo $total ?></span>
        <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau</a>
        <a href="<?php echo $view->router->generate('projects') ?>">Projets</a>
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
                <div class="statuses quarters clearfix">
                    <?php foreach(array_keys(Application\MiamBundle\Entities\Story::getSprintStatuses()) as $status): ?>
                    <div class="status status_<?php echo $status ?>" data-status="<?php echo $status ?>">
                        <div class="stories">
                            <?php foreach($section['stories'] as $story): ?>
                            <?php if($story->isStatus($status)): ?>
                            <div class="story story_object story_<?php echo $story->getId() ?>" data-story-id="<?php echo $story->getId() ?>" rel="story_<?php echo $story->getId() ?>">
                                <?php echo $story->getName() ?>
                                <div class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
