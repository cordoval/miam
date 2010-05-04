<?php $view->stylesheets->add('/bundles/miam/css/main.css') ?>
<?php $view->stylesheets->add('/bundles/miam/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.8.1.custom.css') ?>
<?php $view->javascripts->add('/bundles/miam/vendor/jquery/jquery.min.js') ?>
<?php $view->javascripts->add('/bundles/miam/vendor/jquery-ui/js/jquery-ui-1.8.1.custom.min.js') ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Miam</title>
    <?php echo $view->stylesheets ?>
  </head>
  <body>
    <?php $view->slots->output('_content') ?>
    <?php echo $view->javascripts ?>
  </body>
</html>
