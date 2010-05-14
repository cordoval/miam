<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'story_new') ?>

<h1>Création d'une nouvelle story</h1>

<?php echo $form->renderFormTag($view->router->generate('story_new')) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input id="submit" type="submit" value="Valider" />
</form>