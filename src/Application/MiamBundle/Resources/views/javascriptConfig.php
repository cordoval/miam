<script type="text/javascript">
var miam_config = <?php echo json_encode(array(
    'story_url' => $view->router->generate('story', array('id' => '_ID_')),
    'story_reestimate_url' => $view->router->generate('story_reestimate'),
    'home_url' => $view->router->generate('homepage')
)); ?>;
</script>
