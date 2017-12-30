<?php


namespace Krowinski\LaravelXSLT\Events;

use Illuminate\Queue\SerializesModels;
use Krowinski\LaravelXSLT\Engines\ExtendedSimpleXMLElement;

/**
 * Class XSLTEngineEvent
 * @package Krowinski\LaravelXSLT\Events
 */
class XSLTEngineEvent
{
    use SerializesModels;
    /**
     * @var ExtendedSimpleXMLElement
     */
    private $extendedSimpleXMLElement;
    /**
     * @var array
     */
    private $data;

    /**
     * XSLTEngineEvent constructor.
     * @param ExtendedSimpleXMLElement $extendedSimpleXMLElement
     * @param array $data
     */
    public function __construct(
        ExtendedSimpleXMLElement $extendedSimpleXMLElement,
        array $data
    ) {

        $this->extendedSimpleXMLElement = $extendedSimpleXMLElement;
        $this->data = $data;
    }

    /**
     * @return ExtendedSimpleXMLElement
     */
    public function getExtendedSimpleXMLElement() : ExtendedSimpleXMLElement
    {
        return $this->extendedSimpleXMLElement;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }
}
