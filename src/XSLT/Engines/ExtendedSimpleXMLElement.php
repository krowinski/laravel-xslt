<?php
declare(strict_types=1);

namespace Krowinski\LaravelXSLT\Engines;

use Krowinski\LaravelXSLT\Exception\IncorrectDataTypeException;
use SimpleXMLElement;

class ExtendedSimpleXMLElement extends SimpleXMLElement
{
    /**
     * @throws IncorrectDataTypeException
     */
    public function addArrayToXmlByChild(
        array $data,
        string $childName,
        bool $asAttributes = true
    ): ExtendedSimpleXMLElement {
        return $this->addChild($childName)->addArrayToXml($data, $asAttributes);
    }

    /**
     * @throws IncorrectDataTypeException
     */
    public function addArrayToXml(
        array $data,
        bool $asAttributes = true,
        string $namespace = null
    ): ExtendedSimpleXMLElement {
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

    public function addChild($name, $value = null, $namespace = null): ExtendedSimpleXMLElement
    {
        parent::addChild($name, $value, $namespace);

        return $this;
    }
}