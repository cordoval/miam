<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'sprint_new') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('sprint_current') ?>">Sprint</a>
  &gt;
  Nouveau sprint
</div>

<h1>Création d'un sprint</h1>

<?php echo $form->renderFormTag($view->router->generate('sprint_new')) ?>
    <table>
      <?php echo $form['startsAt']->renderErrors() ?>
      <label>Début: <?php echo $form['startsAt']->render(); ?></label>
<br />
      <?php echo $form['endsAt']->renderErrors() ?>
      <label>Fin: <?php echo $form['endsAt']->render(); ?></label> 
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
