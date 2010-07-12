<?php

namespace Bundle\MiamBundle\DoctrineForm;

use Symfony\Components\Form\Renderer\SelectRenderer;
use Symfony\Components\Form\ChoiceField;
use Symfony\Components\Form\Renderer\InputRadioRenderer;
use Symfony\Components\Form\Renderer\InputCheckboxRenderer;
use Symfony\Components\Form\ValueTransformer\ValueTransformerInterface;
use Symfony\Components\Form\ValueTransformer\BooleanToStringTransformer;

/**
 * Lets the user select between different Doctrine entities
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class DoctrineChoiceField extends ChoiceField 
{
  protected function transform($value)
  {
    $value = parent::transform($value);

    if(is_object($value))
    {
      $value = $value->getId();
    }

    return $value;
  }

  /**
   * Transforms a checkbox/radio button array to a single choice or an array
   * of choices.
   *
   * The input value is an array with the choices as keys and true/false as
   * values, depending on whether a given choice is selected. The output
   * is an array with the selected choices or a single selected choice.
   *
   * @param  mixed $value  An array if "expanded" or "multiple" is set to true,
   *                       a scalar value otherwise.
   * @return mixed $value  An array if "multiple" is set to true, a scalar
   *                       value otherwise.
   */
  protected function reverseTransform($value)
  {
    if ($this->getOption('expanded'))
    {
      $choices = array();

      foreach ($value as $choice => $selected)
      {
        if ($selected)
        {
          $choices[] = $choice;
        }
      }

      if ($this->getOption('multiple'))
      {
        return $choices;
      }
      else
      {
        return count($choices) > 0 ? current($choices) : null;
      }
    }
    else
    {
      return $value;
    }
  }
}
