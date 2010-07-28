<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class TimelineController extends Controller
{

    public function showAction()
    {
        $timeline = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entity\TimelineEntry')
        ->findLatest(12);

        return $this->render('MiamBundle:Timeline:show', array(
            'timeline' => $timeline,
            'emails' => $this->container->getParameter('miam.user.emails')
        ));
    }

    protected function getEntityManager()
    {
        return $this->container->getDoctrine_ORM_EntityManagerService();
    }

}
