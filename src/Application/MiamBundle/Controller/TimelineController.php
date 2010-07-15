<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class TimelineController extends Controller
{

    public function showAction()
    {
        $timeline = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\TimelineEntry')
        ->findLatest(12);

        return $this->render('MiamBundle:Timeline:show', array(
            'timeline' => $timeline,
            'emails' => $this->container->getParameter('miam.user.emails')
        ));
    }

}
