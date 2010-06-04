<?php $view->stylesheets->add('/bundles/miam/css/reset-min.css') ?>
<?php $view->stylesheets->add('/bundles/miam/vendor/fancybox/jquery.fancybox-1.3.1.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/main.css') ?>
<?php $view->stylesheets->add('/bundles/miam/css/story.css') ?>

<?php $view->javascripts->add('/bundles/miam/vendor/jquery/jquery.min.js') ?>
<?php $view->javascripts->add('/bundles/miam/vendor/jquery-ui/js/jquery-ui-1.8.1.custom.min.js') ?>
<?php $view->javascripts->add('/bundles/miam/vendor/fancybox/jquery.fancybox-1.3.1.pack.js') ?>
<?php $view->javascripts->add('/bundles/miam/js/backlog.js') ?>
<?php $view->javascripts->add('/bundles/miam/js/sprint.js') ?>
<?php $view->javascripts->add('/bundles/miam/js/main.js') ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Miam</title>
        <?php echo $view->stylesheets ?>
    </head>
    <body>
        <?php echo $view->render('MiamBundle:Miam:header') ?>
        <div class="bd">
                <?php echo $view->render('MiamBundle:Miam:messages') ?>
                <?php $view->slots->output('_content') ?>
        </div>
        <?php echo $view->render('MiamBundle:Miam:footer') ?>

        <?php echo $view->javascripts ?>
    </body>
</html>
