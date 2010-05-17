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

        $this->validatorSchema['name'] = new \sfValidatorString(array(
              'max_length' => 255,
        ));
        $this->widgetSchema->setNameFormat('project[%s]');
    }

    protected function doUpdateObject($values)
    {
        $this->getObject()->setName($values['name']);
    }

    public function getModelName()
    {
        return 'Bundle\MiamBundle\Entities\Project';
    }

}

