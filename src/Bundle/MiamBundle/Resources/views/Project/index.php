<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'projects') ?>

<div id="projects">
    <div class="titleWithActions">
        <h1>Backlog</h1>
        <a id="newSprint" href="<?php echo $view->router->generate('project_new') ?>">Créer un projet</a>
    </div>

    <ol class="projects">
        <?php foreach ($projects as $project): ?>
            <li class="project" id="project_<?php echo $project->getId() ?>">
                <a href="<?php echo $view->router->generate('project', array('id' => $project->getId())) ?>"><?php echo $project->getName() ?></a>
                <span class="editLink"><a href="<?php echo $view->router->generate('project_edit', array('id' => $project->getId())) ?>">modifier</a></span>
            </li>
        <?php endforeach ?>
    </ol>
</div>