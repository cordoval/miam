<?php $view->extend('MiamBundle::layout') ?>

<h1>Miam</h1>

<ul id="stories">
<?php foreach($stories as $story): ?>
	<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $story->getName() ?></li>
<?php endforeach; ?>
</ul>