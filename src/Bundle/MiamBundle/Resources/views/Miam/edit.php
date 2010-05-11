<?php $view->extend('MiamBundle::layout') ?>
  
<?php echo $form->renderFormTag($view->router->generate('story_edit', array('id' => $story->getId()))) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input type="submit" value="Valider" />
</form>

<a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">
    Retour à la story
</a>