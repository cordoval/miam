<?php

namespace Bundle\MiamBundle\Form;

use Bundle\MiamBundle\Form\BaseForm;
use Doctrine\ORM\EntityManager;

class ProjectForm extends BaseForm
{

    public function configure()
    {
        $this->widgetSchema['name'] = new \sfWidgetFormInputText(array(
        ));
        $this->widgetSchema['color'] = new \sfWidgetFormInputText(array(
        ));


        $this->validatorSchema['name'] = new \sfValidatorString(array(
              'max_length' => 255,
        ));
        $this->validatorSchema['color'] = new \sfValidatorString(array(
              'max_length' => 7,
        ));
        $this->widgetSchema->setNameFormat('project[%s]');
    }

    protected function doUpdateObject(array $values)
    {
        $this->getObject()->setName($values['name']);
        $this->getObject()->setColor($values['color']);
    }

    public function getModelName()
    {
        return 'Bundle\MiamBundle\Entities\Project';
    }

}

