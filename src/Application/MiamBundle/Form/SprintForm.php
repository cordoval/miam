<?php

namespace Application\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\DateField;

class SprintForm extends Form
{
    public function configure()
    {
        $this->add(new DateField('startsAt'));
        $this->add(new DateField('endsAt'));
    } 
}
