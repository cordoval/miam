<table data-move-url="<?php echo $view->router->generate('story_move') ?>" data-story-url="<?php echo $view->router->generate('story', array('id' => '_ID_')) ?>" data-ping-url="<?php echo $view->router->generate('sprint_ping', array('hash' => '_HASH_')) ?>" data-sprint-hash="<?php echo $sprint->getHash() ?>">
    <thead>
    <tr>
        <th>En attente</th>
        <th>A faire</th>
        <th>En cours</th>
        <th>Fait</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($projects as $project): ?>
        <tr>
        <th colspan="4" class="project" style="background: <?php echo $project->getColor() ?>"><?php echo $project ?></th>
        </tr>
        <?php foreach($project->getStories() as $story): ?>
        <tr id="story_column_<?php echo $story->getId() ?>">
            <?php foreach($statuses as $status => $name): ?>
            <td data-status="<?php echo $status ?>">
                <?php if($story->isStatus($status)): ?>
                <div class="story" data-story-id="<?php echo $story->getId() ?>"><?php echo $story->getName() ?>
                    <div class="story_points_wrapper">
                        <div class="story_points"><?php echo $story->getPoints() ? $story->getPoints() : '?' ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </td>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>
</table>
