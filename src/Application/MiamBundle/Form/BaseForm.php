<?php

namespace Bundle\MiamBundle\Form;

use Bundle\DoctrineFormBundle\Form\DoctrineForm;
use Doctrine\ORM\EntityManager;

abstract class BaseForm extends \sfForm
{

    protected $object;
    protected $isNew = false;

    public function __construct($object, $options = array(), $CSRFSecret = null)
    {
        $class = $this->getModelName();
        if (!$object) {
            $this->object = new $class();
            $this->isNew = true;

        } else {
            if (!$object instanceof $class) {
                throw new \Exception(sprintf('The "%s" form only accepts a "%s" object.', get_class($this), $class));
            }

            $this->object = $object;
            // $this->isNew = !$this->getObject()->exists();
        }

        parent::__construct(array(), $options, $CSRFSecret);

        $this->updateDefaultsFromObject();
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
    
    abstract protected function doUpdateObject(array $values);

    /**
     * Updates the default values of the form with the current values of the current object.
     */
    protected function updateDefaultsFromObject()
    {
        $defaults = $this->getDefaults();

        if($this->isNew) {
            $defaults = $defaults + $this->getObject()->toArray();
        } else {
            $defaults = $this->getObject()->toArray() + $defaults;
        }

        $this->setDefaults($defaults);
    }

    public function getObject()
    {
        return $this->object;
    }

}

