<?php $view->extend('MiamBundle::layout') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>

<div id="sprint_current">
    <div class="titleWithActions">
        <h1>Backlog de Sprint</h1>
        <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Changer de sprint</a>
    </div>
    
    <table id="sprintBacklog" data-move-url="<?php echo $view->router->generate('story_move') ?>">
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
                    <div class="story" data-story-id="<?php echo $story->getId() ?>"><?php echo $story->getName() ?></div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
