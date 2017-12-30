<?php


namespace Krowinski\LaravelXSLT\Engines;

use Krowinski\LaravelXSLT\Exception\IncorrectDataTypeException;
use SimpleXMLElement;

/**
 * Class ExtendedSimpleXMLElement
 * @package Krowinski\LaravelXSLT\Engines
 */
class ExtendedSimpleXMLElement extends SimpleXMLElement
{
    /**
     * @param array $data
     * @param string $childName
     * @param bool $asAttributes
     * @return ExtendedSimpleXMLElement
     */
    public function addArrayToXmlByChild(array $data, string $childName, bool $asAttributes = true) : ExtendedSimpleXMLElement
    {
        return $this->addChild($childName)->addArrayToXml($data, $asAttributes);
    }

    /**
     * @param array $data
     * @param bool $asAttributes
     * @param string $namespace
     * @return ExtendedSimpleXMLElement
     * @throws IncorrectDataTypeException
     */
    public function addArrayToXml(array $data, bool $asAttributes = true, string $namespace = null) : ExtendedSimpleXMLElement
    {
        foreach ($data as $key => $value) {
            $key = preg_replace('/[\W]/', '', $key);
            if ('' === $key) {
                $key = 'item';
            } else if (is_numeric($key)) {
                $key = 'item_' . $key;
            }

            if (is_array($value)) {
                $this->addChild($key)->addArrayToXml($value, $asAttributes, $namespace);
            } else if (is_scalar($value)) {
                $value = (string)$value;

                if (true === $asAttributes) {
                    $this->addAttribute($key, $value, $namespace);
                } else {
                    $this->addChild($key, $value, $namespace);
                }
            } else {
                throw new IncorrectDataTypeException(gettype($value) . ' is not supported.');
            }
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return ExtendedSimpleXMLElement
     */
    public function addChild($name, $value = null, $namespace = null) : ExtendedSimpleXMLElement
    {
        parent::addChild($name, $value, $namespace);

        return $this;
    }
}