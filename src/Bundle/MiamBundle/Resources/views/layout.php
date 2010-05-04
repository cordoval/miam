<?php $view->stylesheets->add('css/main.css') ?>
<?php $view->stylesheets->add('ui/css/ui-lightness/jquery-ui-1.8.1.custom.css') ?>
<?php $view->javascripts->add('js/jquery.min.js') ?>
<?php $view->javascripts->add('ui/js/jquery-ui-1.8.1.custom.min.js') ?>
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
