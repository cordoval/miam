<div class="dialog_title">Création d'un sprint</div>
<?php echo $form->renderFormTag($view->router->generate('sprint_new')) ?>
<div class="line">
<label for="sprint_startsAt">Début:</label>
<?php echo $form['startsAt']->render(); ?>
<?php echo $form['startsAt']->renderErrors() ?>
</div>
<div class="line">
<label for="sprint_endsAt">Fin:</label>
<?php echo $form['endsAt']->render(); ?>
<?php echo $form['endsAt']->renderErrors() ?>
</div>
<div class="actions clearfix">
    <input id="submit" type="submit" value="Valider" />
</div>
</form>
