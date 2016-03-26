<?php


namespace Krowinski\LaravelXSLT\Engines;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\View\Engines\EngineInterface;
use Krowinski\LaravelXSLT\Events\XSLTEngineEvent;
use XsltProcessor;

/**
 * Class XSLTEngine
 * @package Krowinski\LaravelXSLT\Engines
 */
class XSLTEngine implements EngineInterface
{
    const EVENT_NAME = \Krowinski\LaravelXSLT\Events\XSLTEngineEvent::class;

    /**
     * @var XsltProcessor
     */
    protected $xsltProcessor;
    /**
     * @var ExtendedSimpleXMLElement
     */
    protected $extendedSimpleXMLElement;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * XSLTEngine constructor.
     * @param XsltProcessor $xsltProcessor
     * @param ExtendedSimpleXMLElement $extendedSimpleXMLElement
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        XsltProcessor $xsltProcessor,
        ExtendedSimpleXMLElement $extendedSimpleXMLElement,
        Dispatcher $dispatcher
    )
    {
        $this->extendedSimpleXMLElement = $extendedSimpleXMLElement;
        $this->xsltProcessor = $xsltProcessor;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        $this->dispatcher->fire(self::EVENT_NAME, new XSLTEngineEvent($this->extendedSimpleXMLElement, $data));

        $this->xsltProcessor->importStylesheet(simplexml_load_file($path));

        return $this->xsltProcessor->transformToXml($this->extendedSimpleXMLElement);
    }
}
