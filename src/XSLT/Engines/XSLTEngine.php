<?php
declare(strict_types=1);

namespace Krowinski\LaravelXSLT\Engines;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Engine;
use Krowinski\LaravelXSLT\Events\XSLTEngineEvent;
use XsltProcessor;

class XSLTEngine implements Engine
{
    private const EVENT_NAME = XSLTEngineEvent::class;

    protected $xsltProcessor;
    protected $extendedSimpleXMLElement;
    private $dispatcher;

    public function __construct(
        XsltProcessor $xsltProcessor,
        ExtendedSimpleXMLElement $extendedSimpleXMLElement,
        Dispatcher $dispatcher
    ) {
        $this->extendedSimpleXMLElement = $extendedSimpleXMLElement;
        $this->xsltProcessor = $xsltProcessor;
        $this->dispatcher = $dispatcher;
    }

    public function get($path, array $data = [])
    {
        $this->dispatcher->dispatch(self::EVENT_NAME, new XSLTEngineEvent($this->extendedSimpleXMLElement, $data));

        $this->xsltProcessor->importStylesheet(simplexml_load_file($path));

        return $this->xsltProcessor->transformToXml($this->extendedSimpleXMLElement);
    }
}
