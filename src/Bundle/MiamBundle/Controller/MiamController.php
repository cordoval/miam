<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;

class MiamController extends Controller
{
  public function indexAction()
  {
    $stories = $this->getEntityManager()
      ->getRepository('Bundle\MiamBundle\Entities\Story')
      ->createQueryBuilder('story')
      ->getQuery()
      ->execute();

    return $this->render('MiamBundle:Miam:index', array(
      'stories' => $stories,
    ));
  }
}