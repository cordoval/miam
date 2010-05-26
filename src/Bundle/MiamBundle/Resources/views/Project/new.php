<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'project_new') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('projects') ?>">Projets</a>
</div>

<h1>Création d'un projet</h1>

<form action="<?php echo $view->router->generate('project_new') ?>" method="post">
    <table>
        <?php echo $form->render() ?>
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
