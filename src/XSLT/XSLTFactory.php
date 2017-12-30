<?php


namespace Krowinski\LaravelXSLT;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\ViewFinderInterface;
use Krowinski\LaravelXSLT\Engines\ExtendedSimpleXMLElement;
use Krowinski\LaravelXSLT\Exception\MethodNotFoundException;

/**
 * Class XSLTFactory
 * @package Krowinski\LaravelXSLT
 * @method ExtendedSimpleXMLElement addArrayToXmlByChild
 * @method ExtendedSimpleXMLElement addArrayToXml
 * @method ExtendedSimpleXMLElement addChild
 * @method ExtendedSimpleXMLElement addAttribute
 */
class XSLTFactory extends Factory
{
    /**
     * @var ExtendedSimpleXMLElement
     */
    private $extendedSimpleXMLElement;

    /**
     * @param EngineResolver $engines
     * @param ViewFinderInterface $finder
     * @param Dispatcher $events
     * @param ExtendedSimpleXMLElement $extendedSimpleXMLElement
     */
    public function __construct(
        EngineResolver $engines,
        ViewFinderInterface $finder,
        Dispatcher $events,
        ExtendedSimpleXMLElement $extendedSimpleXMLElement
    ) {
        parent::__construct($engines, $finder, $events);
        $this->extendedSimpleXMLElement = $extendedSimpleXMLElement;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws MethodNotFoundException
     */
    public function __call($name, array $arguments)
    {
        if (!method_exists($this->extendedSimpleXMLElement, $name)) {
            throw new MethodNotFoundException($name . ': Method Not Found');
        }

        return call_user_func_array([$this->extendedSimpleXMLElement, $name], $arguments);
    }
}
