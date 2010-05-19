<?php

namespace Bundle\MiamBundle\Form;

use Bundle\MiamBundle\Form\BaseForm;
use Doctrine\ORM\EntityManager;
use Bundle\MiamBundle\Entities\Project;

class StoryForm extends BaseForm
{
    protected $projects;
    
    public function configure()
    {
        $this->projects = $this->getOption('projects', array());
        
        $this->widgetSchema['name'] = new \sfWidgetFormInputText(array(
        ));

        $this->widgetSchema['body'] = new \sfWidgetFormTextarea(array(
        ));

        $this->widgetSchema['points'] = new \sfWidgetFormInputText(array(
        ));

        $this->widgetSchema['project'] = new \sfWidgetFormChoice(array(
            'choices' => $this->projects,
        ));

        $this->validatorSchema['name'] = new \sfValidatorString(array(
            'max_length' => 255,
        ));

        $this->validatorSchema['body'] = new \sfValidatorString(array(
             'max_length' => 50000,
             'required' => false
        ));

        $this->validatorSchema['points'] = new \sfValidatorInteger(array(
            'min' => 1,
            'required' => false
        ));

        $this->validatorSchema['project'] = new \sfValidatorChoice(array(
            'choices' => array_keys($this->projects)
        ));
        
        $this->widgetSchema->setNameFormat('story[%s]');
    }

    protected function doUpdateObject($values)
    {
        $this->getObject()->setName($values['name']);
        $this->getObject()->setBody($values['body']);
        $this->getObject()->setPoints($values['points']);
        
        $projectId = $values['project'];
        $project = $this->projects[$projectId];
        
        $this->getObject()->setProject($project);
    }

    public function getModelName()
    {
        return 'Bundle\MiamBundle\Entities\Story';
    }

}
