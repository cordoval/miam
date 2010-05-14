<?php $view->extend('MiamBundle::layout') ?>

<h1>Edition de la story</h1>

<?php echo $form->renderFormTag($view->router->generate('story_edit', array('id' => $story->getId()))) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input id="submit" "type="submit" value="Valider" />
</form>

<a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>">
    Retour à la story
</a>