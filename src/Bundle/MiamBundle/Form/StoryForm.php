<?php

namespace Bundle\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\FieldGroup;
use Symfony\Components\Form\ChoiceField;
use Symfony\Components\Form\TextField;
use Symfony\Components\Form\TextareaField;
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
use Symfony\Components\Validator\MessageInterpolator\XliffMessageInterpolator;
use Symfony\Foundation\UniversalClassLoader;

use Bundle\MiamBundle\Entities\Project;

class StoryForm extends Form
{
  protected $projects;

  public function __construct($object, array $options = array())
  {
    $this->addOption('projects');
    $this->addOption('message_file');
    $this->addOption('validation_file');
    $validator = $this->createValidator($options['message_file'], $options['validation_file']);
    parent::__construct('story', $object, $validator, $options, $options);

    $this->add(new TextField('name'));
    $this->add(new TextAreaField('body'));
    $this->add(new TextField('points'));
    $this->add(new ChoiceField('project', array(
      'choices' => $this->getProjectChoices()
    )));
  }

  public function getProjectChoices()
  {
    $projects = $this->getOption('projects', array());
    $choices = array();
    foreach($projects as $project)
    {
      $choices[$project->getId()] = $project->getName();
    }

    return $choices;
  }

  public function createValidator($messageFile, $validationFile)
  {
    $metadataFactory = new ClassMetadataFactory(new LoaderChain(array(
      new StaticMethodLoader('loadValidatorMetadata'),
      new XmlFileLoader($validationFile)
    )));
    $validatorFactory = new ConstraintValidatorFactory();
    $messageInterpolator = new XliffMessageInterpolator($messageFile);
    $validator = new Validator($metadataFactory, $validatorFactory, $messageInterpolator);

    return $validator;
  }

}
