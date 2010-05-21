<?php $view->extend('MiamBundle::layout') ?>
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
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
