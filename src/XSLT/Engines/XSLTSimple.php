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
            // clean key names
            $key = preg_replace('/[\W]|_/', '', $key);
            if (empty($key))
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
