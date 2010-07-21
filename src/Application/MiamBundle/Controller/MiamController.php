<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class MiamController extends Controller
{

    public function indexAction()
    {
        $stories = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\Story')
        ->findBacklog();

        $timeline = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\TimelineEntry')
        ->findLatest();

        return $this->render('MiamBundle:Miam:index', array(
            'stories' => $stories,
            'timeline' => $timeline 
        ));
    }

    public function fastLoginAction($username)
    {
        if($username) {
            $user = $this->getEntityManager()->getRepository('Bundle\DoctrineUserBundle\Entities\User')->findOneByUsername($username);
            if(!$user) {
                throw new NotFoundHttpException('There is no user '.$username);
            }
            $this->container->getSessionService()->start();
            $this->container->getSessionService()->setAttribute('identity', $user);
            return $this->redirect($this->generateUrl('homepage'));
        }
        $users = $this->getEntityManager()->getRepository('Bundle\DoctrineUserBundle\Entities\User')->findByIsActive(true);
        $response = $this->render('MiamBundle:Miam:fastLogin', array('users' => $users, 'emails' => $this->container->getParameter('miam.user.emails')));
        $response->setStatusCode(401);
        return $response;
    }
        
}
