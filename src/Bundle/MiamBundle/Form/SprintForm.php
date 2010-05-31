<?php

namespace Bundle\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\FieldGroup;
use Symfony\Components\Form\ChoiceField;
use Symfony\Components\Form\TextField;
use Symfony\Components\Form\CheckboxField;
use Symfony\Components\Form\NumberField;
use Symfony\Components\Form\PasswordField;
use Symfony\Components\Form\DoubleTextField;
use Symfony\Components\Validator\Validator;
use Symfony\Components\Validator\ConstraintValidatorFactory;
use Symfony\Components\Validator\Mapping\ClassMetadataFactory;
use Symfony\Components\Validator\Mapping\ClassMetadata;
use Symfony\Components\Validator\Mapping\Loader\LoaderChain;
use Symfony\Components\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Components\Validator\Mapping\Loader\XmlFileLoader;
use Bundle\MiamBundle\Validator\BlackHoleMessageInterpolator;
use Symfony\Foundation\UniversalClassLoader;

class SprintForm extends Form
{
    protected $projects;
    
    public function __construct()
    {
        $this->addOption('validation_file'); 
        $validator = $this->createValidator($options['message_file']);
        parent::__construct('project', $object, $validator, $options);
    }

    public function configure()
    {
        $this->add(new TextField('name'));
        $this->add(new TextField('color'));
        
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
        return 'Bundle\MiamBundle\Entities\Sprint';
    }

    public function createValidator($messageFile)
    {
        $metadataFactory = new ClassMetadataFactory(new LoaderChain(array(
            new StaticMethodLoader('loadValidatorMetadata'),
            new XmlFileLoader($validationFile)
        )));
        $validatorFactory = new ConstraintValidatorFactory();
        $messageInterpolator = new BlackHoleMessageInterpolator();
        $validator = new Validator($metadataFactory, $validatorFactory, $messageInterpolator);

        return $validator;
    }

}
