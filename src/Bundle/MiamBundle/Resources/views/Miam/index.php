<?php $view->extend('MiamBundle::layout') ?>

<h1>Miam</h1>

<ul id="stories">
<?php foreach($stories as $story): ?>
	<li class="story ui-state-default" data-storyId="<?php echo $story->getId() ?>">
	  <?php echo $story->getName() ?>
	</li>
<?php endforeach; ?>
</ul>

<script type="text/javascript" charset="utf-8">
<?php
$storiesPublic = array();
foreach($stories as $story)
{
  $storiesPublic[$story->getId()] = array(
    'id' => $story->getId(),
    'name' => $story->getName(),
    'body' => $story->getBody(),
    'createdAt' => $story->getCreatedAt(),
    'priority' => $story->getPriority(),
    'url_show' => $view->router->generate('story', array('id' => $story->getId())),
  );
}
?>
  stories = <?php echo json_encode($storiesPublic) ?>;
</script>