<?php $view->extend('MiamBundle::layout') ?>
<?php $view->slots->set('active_menu', 'story_new') ?>

<?php echo $form->renderFormTag($view->router->generate('story_new')) ?>
    <table>
        <?php echo $form ?>
    </table>
    <input type="submit" value="Valider" />
</form>