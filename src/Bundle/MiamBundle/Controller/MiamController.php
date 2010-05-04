<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;

class MiamController extends Controller
{
  public function indexAction()
  {
    $em = $this->getEntityManager();
    $qb = $em->createQueryBuilder()
      ->select('s')
      ->from('MiamBundle:Story', 's');

    $query = $qb->getQuery();
    $stories = $query->execute();

    return $this->render('MiamBundle:Miam:index', array(
      'stories' => $stories,
    ));
  }
}