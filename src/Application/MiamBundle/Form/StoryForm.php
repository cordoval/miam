<?php

namespace Application\MiamBundle\Form;

use Application\MiamBundle\DoctrineForm\DoctrineChoiceField;
use Symfony\Components\Form\Form;
use Symfony\Components\Form\TextField;
use Symfony\Components\Form\TextareaField;
use Symfony\Components\Form\NumberField;
use Symfony\Components\Form\PropertyPath;

class StoryForm extends Form
{
    protected $projects;

    public function configure()
    {
        $this->addOption('projects');
        $this->add(new TextField('name'));
        $this->add(new TextAreaField('body'));
        $this->add(new TextField('points'));
        $this->add(new DoctrineChoiceField('project', array(
            'choices' => $this->getOption('projects')
        )));
    }

    protected function doBind(array $data)
    {
        $projects = $this->getOption('projects');
        $data['project'] = $projects[$data['project']];

        return parent::doBind($data);
    }
}
