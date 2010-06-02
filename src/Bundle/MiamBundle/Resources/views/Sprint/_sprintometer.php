<?php

$url = 'http://chart.apis.google.com/chart?chs=widthxheight&cht=type&chd=data&chl=label&chf=background';

$params = array(
    'width' => 90,
    'height' => 43,
    'type' => 'gom',
    'data' => 't:'.$percentage,
    'label' => $percentage.'%',
    'background' => 'bg,s,65432100'
);

?>

    <img class="sprintometer" src="<?php echo strtr($url, $params) ?>" alt="<?php echo $percentage ?>%" width="<?php echo $params['width'] ?>" height="<?php echo $params['height'] ?>"/>
