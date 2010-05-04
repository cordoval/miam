<?php

namespace Application\MiamBundle\Controller;

use Symfony\Framework\WebBundle\Controller;

class MiamController extends Controller
{
  public function indexAction()
  {
    return $this->render('MiamBundle:Miam:index');
  }
}