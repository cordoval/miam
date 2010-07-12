<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'story_new') ?>

<div id="breadcrumb">
    <a id="back_backlog" href="<?php echo $view->router->generate('sprint_schedule') ?>">Backlog</a>
    &gt;
    Nouvelle story
</div>

<h1>Création d'une nouvelle story</h1>
<?php echo $form->renderFormTag($view->router->generate('story_new')) ?>
    <table>
      <?php echo $form['name']->renderErrors() ?>
      <label>Name: <?php echo $form['name']->render(array('class' => 'focus_me')); ?></label>
<br />
      <?php echo $form['body']->renderErrors() ?>
      <label>Body: <?php echo $form['body']->render(); ?></label> 
<br />
      <?php echo $form['project']->renderErrors() ?>
      <label>Project: <?php echo $form['project']->render(); ?></label> 
<br />
      <?php echo $form['points']->renderErrors() ?>
      <label>Points: <?php echo $form['points']->render(); ?></label> 
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
