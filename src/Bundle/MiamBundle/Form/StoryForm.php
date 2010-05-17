<?php

namespace Bundle\MiamBundle\Form;

use Bundle\DoctrineFormBundle\Form\DoctrineForm,
 \Doctrine\ORM\EntityManager;

class StoryForm extends \sfForm
{

    protected $object;

    public function __construct($object, $options = array(), $CSRFSecret = null)
    {
        $class = $this->getModelName();
        if (!$object)
        {
            $this->object = new $class();
        }
        else
        {
            if (!$object instanceof $class)
            {
                throw new sfException(sprintf('The "%s" form only accepts a "%s" object.', get_class($this), $class));
            }

            $this->object = $object;
            //$this->isNew = !$this->getObject()->exists();
        }

        parent::__construct(array(), $options, $CSRFSecret);

        $this->updateDefaultsFromObject();
    }

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

    public function processValues($values)
    {
        return $values;
    }

    /**
     * Updates the values of the object with the cleaned up values.
     *
     * @param  array $values An array of values
     *
     * @return mixed The current updated object
     */
    public function updateObject($values = null)
    {
        if (null === $values)
        {
            $values = $this->values;
        }

        $values = $this->processValues($values);

        $this->doUpdateObject($values);

        return $this->getObject();
    }

    protected function doUpdateObject($values)
    {
        $this->getObject()->setName($values['name']);
        $this->getObject()->setBody($values['body']);
        $this->getObject()->setPoints($values['points']);
    }

    /**
     * Updates the default values of the form with the current values of the current object.
     */
    protected function updateDefaultsFromObject()
    {
        $defaults = $this->getDefaults();

        $defaults = $this->getObject()->toArray() + $defaults;

        $this->setDefaults($defaults);
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getModelName()
    {
        return 'Bundle\MiamBundle\Entities\Story';
    }

}

