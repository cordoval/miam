<?php $view->extend('MiamBundle::layout') ?>

<h1>Backlog</h1>

<ul id="stories">
<?php foreach($stories as $story): ?>
	<li class="story ui-state-default" data-storyId="<?php echo $story->getId() ?>">
	  #<?php echo $story->getId() ?> − <?php echo $story->getName() ?>
	</li>
<?php endforeach; ?>
</ul>

<script type="text/javascript" charset="utf-8">
  var stories = <?php echo $storiesRenderer->renderStoriesAsJson($stories) ?>
</script>