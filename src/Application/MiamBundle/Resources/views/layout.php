<?php $view->assets->setVersion(1) ?>
<?php $view->stylesheets->add('/bundles/miam/css/reset-min.css') ?>
<?php $view->stylesheets->add('/bundles/miam/vendor/jquery-ui/css/smoothness/jquery-ui-1.8.2.custom.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/main.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/modal.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/story.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/timeline.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/sprint.css') ?>

<?php $view->javascripts->add('/bundles/miam/vendor/jquery/jquery.min.js') ?>
<?php $view->javascripts->add('/bundles/miam/vendor/jquery-ui/js/jquery-ui-1.8.2.custom.min.js') ?>
<?php $view->javascripts->add('/bundles/miam/js/sprint.js') ?>
<?php $view->javascripts->add('/bundles/miam/js/main.js') ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Miam</title>
        <?php echo $view->stylesheets ?>
    </head>
    <body class="fullPage">
        <?php echo $view->render('MiamBundle:Miam:header') ?>
        <div class="bd">
                <?php echo $view->render('MiamBundle:Miam:messages') ?>
                <?php $view->slots->output('_content') ?>
        </div>
        <?php echo $view->render('MiamBundle:Miam:footer') ?>
        <?php echo $view->render('MiamBundle::javascriptConfig') ?>
        <?php echo $view->javascripts ?>
    </body>
</html>