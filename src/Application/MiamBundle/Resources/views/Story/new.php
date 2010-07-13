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
      
      <tr>
        <th>
          <label for="story_project">Projet*</label>
        </th>
        <td>
          <?php echo $form['project']->render(array('class' => 'focus_me')); ?>
          <?php echo $form['project']->renderErrors() ?>
        </td>
      </tr>
      
      <tr>
        <th>
          <label for="story_name">Nom*</label>
        </th>
        <td>
          <?php echo $form['name']->render(); ?>
          <?php echo $form['name']->renderErrors() ?>
        </td>
      </tr>
      
      <tr>
        <th>
          <label for="story_points">Points</label>
        </th>
        <td>
          <?php echo $form['points']->render(); ?>
          <?php echo $form['points']->renderErrors() ?>
        </td>
      </tr>

      <tr>
        <th>
          <label for="story_body">Description</label>
        </th>
        <td>
          <?php echo $form['body']->render(); ?>
          <?php echo $form['body']->renderErrors() ?>
        </td>
      </tr>
          
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>
