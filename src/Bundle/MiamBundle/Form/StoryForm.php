<?php

namespace Bundle\MiamBundle\Form;

use Bundle\MiamBundle\Form\BaseForm;
use Doctrine\ORM\EntityManager;

class StoryForm extends BaseForm
{

    public function configure()
    {
        $this->widgetSchema['name'] = new \sfWidgetFormInputText(array(
        ));

        $this->widgetSchema['body'] = new \sfWidgetFormTextarea(array(
        ));

        $this->widgetSchema['points'] = new \sfWidgetFormInputText(array(
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

        $this->widgetSchema->setNameFormat('story[%s]');
    }

    protected function doUpdateObject($values)
    {
        $this->getObject()->setName($values['name']);
        $this->getObject()->setBody($values['body']);
        $this->getObject()->setPoints($values['points']);
    }

    public function getModelName()
    {
        return 'Bundle\MiamBundle\Entities\Story';
    }

}
