<?php

namespace Bundle\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\DateField;
use Symfony\Components\Form\ValueTransformer\DateTimeToArrayTransformer;
use Bundle\MiamBundle\Entities\Sprint;

class SprintForm extends Form
{
    protected $projects;
    
    public function configure()
    {
        $this->add(new DateField('startsAt', array('widget' => 'select')))->setValueTransformer(new DateTimeToArrayTransformer());
        $this->add(new DateField('endsAt', array('widget' => 'select')))->setValueTransformer(new DateTimeToArrayTransformer());
        
        // WidgetSchema
        //$dateFormat = '%day%/%month%/%year%';
        
        //$this->widgetSchema['starts_at'] = new \sfWidgetFormDate(array(
            //'format' => $dateFormat
        //));

        //$this->widgetSchema['ends_at'] = new \sfWidgetFormDate(array(
            //'format' => $dateFormat
        //));

        //$this->widgetSchema->setLabels(array(
           //'starts_at' => "Début du sprint", 
           //'ends_at' => "Fin du sprint",
        //));
        //$this->widgetSchema->setNameFormat('sprint[%s]');

        //// ValidatorSchema
        //$this->validatorSchema['starts_at'] = new \sfValidatorDate(array(
        //));
        
        //$this->validatorSchema['ends_at'] = new \sfValidatorDate(array(
        //));
        
        //// Default
        //$this->setDefault('starts_at', time());
        //$this->setDefault('ends_at', time() + 4*60*60*24);
        
    }
}
