<?php

namespace Bundle\MiamBundle\Form;

use Bundle\MiamBundle\DoctrineForm\DoctrineForm;
use Bundle\MiamBundle\DoctrineForm\DoctrineChoiceField;
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
use Bundle\MiamBundle\Validator\BlackHoleMessageInterpolator;
use Symfony\Foundation\UniversalClassLoader;

use Bundle\MiamBundle\Entities\Project;

class StoryForm extends DoctrineForm
{
  protected $projects;

  public function __construct($object, array $options = array())
  {
    $this->addOption('projects');
    $this->addOption('validation_file');
    $validator = $this->createValidator($options['validation_file']);
    parent::__construct('story', $object, $validator, $options, $options);

    $this->add(new TextField('name'));
    $this->add(new TextAreaField('body'));
    $this->add(new TextField('points'));
    $this->add(new DoctrineChoiceField('project', array(
      'choices' => $this->getProjectChoices()
    )));
  }

  public function getProjectChoices()
  {
    return $this->getOption('projects', array());
    $projects = $this->getOption('projects', array());
    $choices = array();
    foreach($projects as $project)
    {
      $choices[$project->getId()] = $project->getName();
    }

    return $choices;
  }

  public function createValidator($validationFile)
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
