<?php

namespace Bundle\MiamBundle\Validator;

use Symfony\Components\Validator\MessageInterpolator\XliffMessageInterpolator; 

class NoValidationXliffMessageInterpolator extends XliffMessageInterpolator 
{
  /**
   * Parses the given file into a SimpleXMLElement
   * Does NOT validate the file (much faster)
   *
   * @param  string $file
   * @return SimpleXMLElement
   */
  protected function parseFile($file)
  {
    $dom = new \DOMDocument();
    libxml_use_internal_errors(true);
    if (!$dom->load($file, LIBXML_COMPACT))
    {
      throw new \Exception(implode("\n", $this->getXmlErrors()));
    }
    $dom->validateOnParse = true;
    $dom->normalizeDocument();
    libxml_use_internal_errors(false);

    return simplexml_import_dom($dom);
  }

  /**
   * Returns the XML errors of the internal XML parser
   *
   * @return array  An array of errors
   */
  protected function getXmlErrors()
  {
    $errors = array();
    foreach (libxml_get_errors() as $error)
    {
      $errors[] = sprintf('[%s %s] %s (in %s - line %d, column %d)',
        LIBXML_ERR_WARNING == $error->level ? 'WARNING' : 'ERROR',
        $error->code,
        trim($error->message),
        $error->file ? $error->file : 'n/a',
        $error->line,
        $error->column
      );
    }

    libxml_clear_errors();
    libxml_use_internal_errors(false);

    return $errors;
  }
}
