<?php
    $total = $sprint->getTotalPoints();
    $finished = $sprint->getFinishedPoints();
    $percentage = $total ? floor($finished/$total*100) : 0;
?>

<div class="titleWithActions">
    <?php $view->output('MiamBundle:Sprint:_sprintometer', array('percentage' => $percentage)) ?>
    <h1 class="sprint">Backlog de Sprint</h1>
    <span class="finished"><?php echo $finished ?>/<?php echo $total ?></span>
    <a id="editSprint" href="<?php echo $view->router->generate('sprint_schedule') ?>">Modifier</a>
    <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau</a>
</div>

<div id="sprintBacklog">
    <table data-move-url="<?php echo $view->router->generate('story_move') ?>" data-ping-url="<?php echo $view->router->generate('sprint_ping', array('hash' => '_HASH_')) ?>" data-sprint-hash="<?php echo $hash ?>">
        <thead>
        <tr>
            <th class="status_pending">En attente (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_PENDING) ?>)</th>
            <th class="status_todo">A faire (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_TODO) ?>)</th>
            <th class="status_wip">En cours (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_WIP) ?>)</th>
            <th class="status_finished">Fait (<?php echo $sprint->getPointsByStatus(Application\MiamBundle\Entities\Story::STATUS_FINISHED) ?>)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($projects as $project): ?>
            <tr>
            <th colspan="4" class="project" style="background: <?php echo $project->getColor() ?>"><?php echo $project ?></th>
            </tr>
            <?php foreach($project->getStories() as $story): ?>
            <tr class="story_line" id="story_column_<?php echo $story->getId() ?>">
                <?php foreach($statuses as $status => $name): ?>
                <td data-status="<?php echo $status ?>">
                    <?php if($story->isStatus($status)): ?>
                    <div class="story story_object" data-story-id="<?php echo $story->getId() ?>"><?php echo $story->getName() ?>
                        <div class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></div>
                    </div>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
