<?php

use Bundle\MiamBundle\Entities\Entry;

$em = $this->container->getDoctrine_ORM_DefaultEntityManagerService();

$story = new Story();
$story->setName('Smoke in the water');
$story->setPriority(1);
$story->setBody("Hey there where ya goin', not exactly knowin', who says you have to call just one place home. He's goin' everywhere, B.J. McKay and his best friend Bear.");