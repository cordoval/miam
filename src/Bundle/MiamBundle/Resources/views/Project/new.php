<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'project_new') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('projects') ?>">Projets</a>
</div>

<h1>Création d'un projet</h1>

<?php echo $form->renderFormTag($view->router->generate('project_new')) ?>
    <table>
      <?php echo $form['name']->renderErrors() ?>
      <label>Name: <?php echo $form['name']->render(); ?></label>
<br />
      <?php echo $form['color']->renderErrors() ?>
      <label>Color: <?php echo $form['color']->render(); ?></label> 
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
