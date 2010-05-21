<?php $view->extend('MiamBundle::layout') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>
<?php $view->slots->set('active_menu', 'sprint_current') ?>

<div id="sprint_current">
    <h1>Current Sprint</h1>

    <a id="newSprint" href="<?php echo $view->router->generate('sprint_new') ?>">Nouveau sprint</a>
    
    <table>
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
            <tr>
              <?php foreach($statuses as $status => $name): ?>
                <td>
                  <?php if($story->isStatus($status)): ?>
                    <div class="story"><?php echo $story ?></div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
