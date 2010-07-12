<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;

class MiamController extends Controller
{

    public function indexAction()
    {
        $stories = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->findBacklog();

        $timeline = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\TimelineEntry')
        ->findLatest();

        return $this->render('MiamBundle:Miam:index', array(
            'stories' => $stories,
            'timeline' => $timeline 
        ));
    }

    public function fastLoginAction($username)
    {
        if($username) {
            $user = $this->getEntityManager()
                ->getRepository('Bundle\DoctrineUserBundle\Entities\User')
                ->findOneByUsername($username);
            if(!$user) {
                throw new NotFoundHttpException('There is no user '.$username);
            }
            $this->getUser()->setAttribute('identity', $user);
            return $this->redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->generateUrl('homepage'));
        }
        $users = $this->getEntityManager()
            ->getRepository('Bundle\DoctrineUserBundle\Entities\User')
            ->findByIsActive(true);
        return $this->render('MiamBundle:Miam:fastLogin', array(
            'users' => $users
        ));
    }
        
}
