<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\RequestHandler\Exception\NotFoundHttpException;

class MiamController extends Controller
{
  public function indexAction()
  {
    $stories = $this->getEntityManager()
      ->getRepository('Bundle\MiamBundle\Entities\Story')
      ->findAllOrderByPriority();

    return $this->render('MiamBundle:Miam:index', array(
      'stories' => $stories,
    ));
  }
  
  public function showAction($id)
  {
    $story = $this->getEntityManager()
      ->getRepository('Bundle\MiamBundle\Entities\Story')
      ->find($id);
    
    if(!$story)
    {
      throw new NotFoundHttpException("Story not found");
    }

    return $this->createResponse(json_encode($story->toArray()));
  }
  
}