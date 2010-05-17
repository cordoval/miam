<?php $view->extend('MiamBundle::layout') ?>

<div id="breadcrumb">
  <a id="back_backlog" href="<?php echo $view->router->generate('backlog') ?>">Backlog</a>
  &gt;
  <a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">
    <?php echo $story->getName() ?>
  </a>
</div>

<h1>Edition de la story</h1>

<?php echo $form->renderFormTag($view->router->generate('story_edit', array('id' => $story->getId()))) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
