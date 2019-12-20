<?php
declare(strict_types=1);

namespace Krowinski\LaravelXSLT\Events;

use Illuminate\Queue\SerializesModels;
use Krowinski\LaravelXSLT\Engines\ExtendedSimpleXMLElement;

class XSLTEngineEvent
{
    use SerializesModels;

    private $extendedSimpleXMLElement;
    private $data;

    public function __construct(
        ExtendedSimpleXMLElement $extendedSimpleXMLElement,
        array $data
    ) {

        $this->extendedSimpleXMLElement = $extendedSimpleXMLElement;
        $this->data = $data;
    }

    public function getExtendedSimpleXMLElement(): ExtendedSimpleXMLElement
    {
        return $this->extendedSimpleXMLElement;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
