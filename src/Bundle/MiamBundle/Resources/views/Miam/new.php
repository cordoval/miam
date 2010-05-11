<?php $view->extend('MiamBundle::layout') ?>
  
<?php echo $form->renderFormTag($view->router->generate('story_edit')) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input type="submit" value="Valider" />
</form>