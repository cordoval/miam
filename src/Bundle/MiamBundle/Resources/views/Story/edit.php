<?php $view->extend('MiamBundle::layout') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">Backlog</a>
  &gt;
  <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">
    <?php echo $story->getName() ?>
  </a>
</div>

<h1>Story <?php echo $story->getName() ?></h1>

<?php echo $form->renderFormTag($view->router->generate('story_edit', array('id' => $story->getId()))) ?>
     <table>
      <?php echo $form['name']->renderErrors() ?>
      <label>Name: <?php echo $form['name']->render(); ?></label>
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
