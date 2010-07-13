<?php

namespace Application\MiamBundle\DoctrineForm;

use Symfony\Components\Form\Form;
use Symfony\Components\Validator\ValidatorInterface;
use Symfony\Components\Validator\ConstraintViolation;
use Symfony\Components\I18N\TranslatorInterface;
use Symfony\Components\File\UploadedFile;
use Application\MiamBundle\Entities\Story;

class DoctrineForm extends Form
{

  public function __construct($name, $object, ValidatorInterface $validator, array $options = array())
  {
    $this->addOption('em');
    return parent::__construct($name, $object, $validator, $options);
  }

  protected function updateElement(&$data, $element, $value)
  {
    // what an ugly hack.
    if($data instanceof Story && 'project' == $element)
    {
      $value = $this->getOption('em')
        ->getRepository('Application\MiamBundle\Entities\Project')
        ->find($value);
    }

    return parent::updateElement($data, $element, $value);  
  }
}
