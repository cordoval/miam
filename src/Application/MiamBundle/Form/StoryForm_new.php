<?php

namespace Application\MiamBundle\Form;

use Bundle\DoctrineFormBundle\Form\DoctrineForm;
use Doctrine\ORM\EntityManager;
use Symfony\Components\Form as Form;
use Symfony\Components\Validator as Validator;

class StoryForm_new extends Form\Form
{
    public function __construct($name, $object, ValidatorInterface $validator = null, array $options = array())
    {
        if(null === $validator)
        {
            $loader = new Validator\Mapping\Loader\LoaderChain(array());
            $metadataFactory = new Validator\Mapping\ClassMetadataFactory($loader);

            $constraintValidatorFactory = new Validator\ConstraintValidatorFactory();
            
            $validator = new Validator\Validator($metadataFactory, $constraintValidatorFactory);
        }

        parent::__construct($name, $object, $validator);
    }

    public function configure()
    {
        $this->add(new Form\Field\TextField('name'));
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
        $this->getObject()->setPriority(10000);
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
        return 'Application\MiamBundle\Entity\Story';
    }

}

