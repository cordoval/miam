<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class MiamController extends Controller
{

    public function indexAction()
    {
        $stories = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entity\Story')
        ->findBacklog();

        $timeline = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entity\TimelineEntry')
        ->findLatest();

        return $this->render('MiamBundle:Miam:index', array(
            'stories' => $stories,
            'timeline' => $timeline 
        ));
    }

    public function fastLoginAction($username)
    {
        if($username) {
            $user = $this->getEntityManager()->getRepository('Bundle\DoctrineUserBundle\Entity\User')->findOneByUsername($username);
            if(!$user) {
                throw new NotFoundHttpException('There is no user '.$username);
            }
            $this->container->getSessionService()->start();
            $this->container->getSessionService()->setAttribute('identity', $user);
            return $this->redirect($this->generateUrl('homepage'));
        }
        $users = $this->getEntityManager()->getRepository('Bundle\DoctrineUserBundle\Entity\User')->findByIsActive(true);
        $response = $this->render('MiamBundle:Miam:fastLogin', array('users' => $users, 'emails' => $this->container->getParameter('miam.user.emails')));
        $response->setStatusCode(401);
        return $response;
    }

    protected function getEntityManager()
    {
        return $this->container->getDoctrine_ORM_EntityManagerService();
    }
        
}
