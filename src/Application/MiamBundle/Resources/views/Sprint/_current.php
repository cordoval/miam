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
        <li><a href="#filters">Filters<span class="nb_filters">*</span></a></li>
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
                            <?php $view->output('MiamBundle:Story:postit', array('story' => $story)) ?>
                        <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <div id="filters">
        <?php foreach(Application\MiamBundle\Entities\Story::getDomains() as $number => $name): ?>
            <input type="checkbox" value="<?php echo $number ?>" id="toggle_domain_<?php echo $number ?>" />
            <label for="toggle_domain_<?php echo $number ?>">
                <img src="<?php echo $view->assets->getUrl('bundles/miam/images/domain/'.$number.'.png') ?>" alt="<?php echo $name ?>" class="story_domain_icon" />
                <?php echo $name ?>
            </label>
        <?php endforeach ?>
    </div>
</div>

<div data-sprint-hash="<?php echo $hash ?>" id="sprint_current" class="colCenter">
    <div class="titleWithActions">
        <a class="sprint_new" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau</a>
        <a href="<?php echo $view->router->generate('projects') ?>">Projets</a>
        <?php $view->output('MiamBundle:Sprint:_sprintometer', array('percentage' => $percentage)) ?>
        <span class="finished"><?php echo $finished ?>/<?php echo $total ?></span>
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
                                <?php $view->output('MiamBundle:Story:postit', array('story' => $story)) ?>
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
