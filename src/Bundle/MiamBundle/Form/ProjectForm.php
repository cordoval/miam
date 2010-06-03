<?php

namespace Bundle\MiamBundle\Form;

use Symfony\Components\Form\Form;
use Symfony\Components\Form\TextField;
use Symfony\Components\Validator\Validator;
use Symfony\Components\Validator\ConstraintValidatorFactory;
use Symfony\Components\Validator\Mapping\ClassMetadataFactory;
use Symfony\Components\Validator\Mapping\ClassMetadata;
use Symfony\Components\Validator\Mapping\Loader\LoaderChain;
use Symfony\Components\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Components\Validator\Mapping\Loader\XmlFileLoader;
use Bundle\MiamBundle\Validator\NoValidationXliffMessageInterpolator;
use Bundle\MiamBundle\Entities\Project;

class ProjectForm extends Form
{
  public function __construct(Project $object, array $options = array())
  {
    $this->addOption('message_file');
    $this->addOption('validation_file'); 
    $validator = $this->createValidator($options['message_file'], $options['validation_file']);
    parent::__construct('project', $object, $validator, $options);

    $this->add(new TextField('name'));
    $this->add(new TextField('color'));
  } 

  public function createValidator($messageFile, $validationFile)
  {
    $metadataFactory = new ClassMetadataFactory(new LoaderChain(array(
      new AnnotationLoader(),
      new XmlFileLoader($validationFile)
    )));
    $validatorFactory = new ConstraintValidatorFactory();
    $messageInterpolator = new NoValidationXliffMessageInterpolator($messageFile);
    $validator = new Validator($metadataFactory, $validatorFactory, $messageInterpolator);

    return $validator;
  }
}
