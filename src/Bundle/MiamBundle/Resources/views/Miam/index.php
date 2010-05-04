<?php $view->extend('MiamBundle::layout') ?>

Miam index!

<?php foreach($stories as $story): ?>
<div class="story">
  <h2><?php echo $story->getName() ?></h2>
</div>
<?php endforeach; ?>
