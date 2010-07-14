<?php

namespace Application\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\TextField;

class ProjectForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('name'));
        $this->add(new TextField('color'));
    } 
}
