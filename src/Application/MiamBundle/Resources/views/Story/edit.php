<div class="dialog_title">Edit <?php echo $story->getName() ?></div>
<?php echo $form->renderFormTag($view->router->generate('story_edit', array('id' => $story->getId()))) ?>
<?php echo $form['name']->renderErrors() ?>
<div class="line name">
<label for="story_name">Name</label>
<?php echo $form['name']->render(array('class' => 'focus_me')); ?>
<?php echo $form['name']->renderErrors() ?>
</div>
<div class="line body">
<label for="story_body">Body</label>
<?php echo $form['body']->render(); ?>
<?php echo $form['name']->renderErrors() ?>
</div>
<div class="line project">
<label for="story_project">Project</label>
<?php echo $form['project']->render(); ?>
<?php echo $form['project']->renderErrors() ?>
</div>
<div class="line points">
<label for="story_points">Points</label>
<?php echo $form['points']->render(); ?>
<?php echo $form['points']->renderErrors() ?>
</div>
<div class="actions clearfix">
    <a class="cancel" href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">Annuler</a>
    <input id="submit" type="submit" value="Valider" />
</div>
    
</form>
