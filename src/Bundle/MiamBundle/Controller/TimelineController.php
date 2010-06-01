<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class TimelineController extends Controller
{

    public function indexAction()
    {
        $timeline = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\TimelineEntry')
        ->findLatest();

        return $this->render('MiamBundle:Timeline:index', array(
            'timeline' => $timeline,
        ));
    }

}
