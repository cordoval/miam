<?php

use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Entities\Project;
use Bundle\DoctrineUserBundle\Entities\User as User;

$colors = $this->container->getParameter('miam.colors');
$colorIt = 0;

$pMiam = new Project();
$pMiam->setName('Miam');
$pMiam->setColor($colors[$colorIt++]);

$pKnp = new Project();
$pKnp->setName('knplabs.com');
$pKnp->setColor($colors[$colorIt++]);

$story1 = new Story();
$story1->setName('Smoke in the water');
$story1->setPriority(1);
$story1->setBody("##Hey there where ya goin'\n
not exactly knowin', **who says** you have to call just one place home. He's goin' everywhere, B.J. McKay and his best friend Bear.");
$story1->setProject($pMiam);

$story2 = new Story();
$story2->setName('Danse on a volcano');
$story2->setPriority(2);
$story2->setBody("Ulysses, Ulysses\n
- Soaring through all the galaxies\n
- In search of Earth\n
- flying in to the night.");
$story2->setProject($pMiam);
$story2->setPoints(5);

$story3 = new Story();
$story3->setName('Saucerful of secrets');
$story3->setPriority(3);
$story3->setPoints(8);
$story3->setBody("I never spend much time in school\n
    but I taught ladies plenty.\n
    It's true I hire my body out for pay, hey hey.\n
\n
__I've gotten burned__ over Cheryl Tiegs, `blown u` for Raquel Welch.");
$story3->setProject($pKnp);

for($itProject=1; $itProject<=5; $itProject++)
{
  $p = 'project_'.$itProject;
  $$p = new Project();
  $$p->setName($p);
  $$p->setColor($colors[$colorIt++]);

  for($itStory = 1; $itStory<=8; $itStory++)
  {
    $s = 'story_'.$itStory;
    $$s = new Story();
    $$s->setName($s);
    $$s->setPriority($itStory);
    $$s->setBody(str_repeat('this text gets repeated '.$itStory.' times'."\n", $itStory));
    $$s->setProject($$p);
  }
}

$admin = new User();
$admin->setUsername('admin');
$admin->setPassword('admin');
$admin->setIsSuperAdmin(true);

$laet = new User();
$laet->setUsername('laet');
$laet->setPassword('changeme');

$matt = new User();
$matt->setUsername('matt');
$matt->setPassword('changeme');

$thib = new User();
$thib->setUsername('thib');
$thib->setPassword('changeme');
