<?php
namespace Krowinski\LaravelXSLT\Engines;

use Illuminate\View\Engines\EngineInterface;
use Illuminate\Support\Facades\URL;

/**
 * Class XSLTEngine
 * @package Krowinski\LaravelXSLT\Engines
 */
class XSLTEngine implements EngineInterface
{
    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return $this->evaluatePath($path, $data);
    }

    /**
     * @param XSLTSimple $XSLTSimple
     */
    public function __construct(XSLTSimple $XSLTSimple)
    {
        $this->XSLTSimple = $XSLTSimple;
    }

    /**
     * @param $path
     * @param array $data
     * @return string
     */
    protected function evaluatePath($path, array $data = [])
    {

        if (isset($data['form']))
        {
            $this->XSLTSimple->addChild('Form', form($data['form']));
        }

        // adding form errors to xml
        if (isset($data['errors']))
        {
            $this->XSLTSimple->DataToXmlByTag($data['errors']->all(), 'FormErrors', false);
        }

        // useful stuff
        $this->XSLTSimple->addChild('URL')->addAttribute('Main', URL::to('/'));

        // adding XML tab
        if (true === class_exists('Debugbar'))
        {
            // xml formating for Debugbar
            $dom = new \DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->loadXML($this->XSLTSimple->saveXML());
            $dom->formatOutput = true;
            $xml_string = $dom->saveXml();

            // add new tab and append xml to it
            \Debugbar::addCollector(new \DebugBar\DataCollector\MessagesCollector('XML'));
            \Debugbar::getCollector('XML')->addMessage($xml_string, 'info', false);
        }

        $xsl_processor = new \XsltProcessor();
        $xsl_processor->registerPHPFunctions();
        $xsl_processor->importStylesheet(simplexml_load_file($path));
        return $xsl_processor->transformToXML($this->XSLTSimple);
    }
}
