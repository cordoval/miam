<?php

namespace Application\MiamBundle\Form;

use Application\MiamBundle\Form\BaseForm;
use Doctrine\ORM\EntityManager;
use Application\MiamBundle\Entities\Project;

class SprintForm extends BaseForm
{
    protected $projects;
    
    public function configure()
    {
        $this->projects = $this->getOption('projects', array());
        
        // WidgetSchema
        $dateFormat = '%day%/%month%/%year%';
        
        $this->widgetSchema['starts_at'] = new \sfWidgetFormDate(array(
            'format' => $dateFormat
        ));

        $this->widgetSchema['ends_at'] = new \sfWidgetFormDate(array(
            'format' => $dateFormat
        ));

        $this->widgetSchema->setLabels(array(
           'starts_at' => "Début du sprint", 
           'ends_at' => "Fin du sprint",
        ));
        $this->widgetSchema->setNameFormat('sprint[%s]');

        // ValidatorSchema
        $this->validatorSchema['starts_at'] = new \sfValidatorDate(array(
        ));
        
        $this->validatorSchema['ends_at'] = new \sfValidatorDate(array(
        ));
        
        // Default
        $this->setDefault('starts_at', time());
        $this->setDefault('ends_at', time() + 4*60*60*24);
        
    }

    protected function doUpdateObject(array $values)
    {
        $sprint = $this->getObject();
        $sprint->setStartsAt(new \DateTime($values['starts_at']));
        $sprint->setEndsAt(new \DateTime($values['ends_at']));
    }

    public function getModelName()
    {
        return 'Application\MiamBundle\Entities\Sprint';
    }

}
