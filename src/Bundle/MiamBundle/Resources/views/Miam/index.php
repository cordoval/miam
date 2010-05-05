<?php $view->extend('MiamBundle::layout') ?>

<h1>Miam</h1>

<ul id="stories">
<?php foreach($stories as $story): ?>
	<li class="ui-state-default"><a href="<?php echo $view->router->generate('story', array('id' => $story->getId())) ?>"><?php echo $story->getName() ?></a></li>
<?php endforeach; ?>
</ul>