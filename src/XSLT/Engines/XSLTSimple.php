<?php
namespace Krowinski\LaravelXSLT\Engines;

/**
 * Class XSLTSimple
 * @package Krowinski\LaravelXSLT\Engines
 */
final class XSLTSimple extends \SimpleXMLElement
{
    /**
     * @param $pData
     * @param bool $pAttributes
     * @return $this
     */
    public function DataToXml($pData, $pAttributes = true)
    {
        foreach ($pData as $key => $value)
        {
            $key = (string)$key;
            if (is_numeric($key))
            {
                $key = 'item';
            }

            if (is_array($value) or is_object($value))
            {
                $xml_child = $this->addChild($key);
                $xml_child->DataToXml($value, $pAttributes);
            }
            else
            {
                if (true === $pAttributes)
                {
                    $this->addAttribute($key, $value);
                }
                else
                {
                    $this->addChild($key, $value);
                }
            }
        }
        return $this;
    }

    /**
     * @param $pName
     * @param string $pValue
     * @return \SimpleXMLElement
     */
    public function addTag($pName, $pValue = '')
    {
        return $this->addChild($pName, $pValue);
    }

    /**
     * @param $pName
     * @param $pValue
     */
    public function addAttr($pName, $pValue)
    {
        $this->addAttribute($pName, $pValue);
    }

    /**
     * @param $pData
     * @param $pTagName
     * @param bool $pAttributes
     * @return mixed
     */
    public function DataToXmlByTag($pData, $pTagName, $pAttributes = true)
    {
        $xml_data = $this->addChild($pTagName);
        return $xml_data->DataToXml($pData, $pAttributes);
    }
}