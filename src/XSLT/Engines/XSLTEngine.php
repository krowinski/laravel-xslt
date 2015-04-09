<?php
namespace Krowinski\LaravelXSLT\Engines;

use Illuminate\View\Engines\EngineInterface;

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
        //$this->XSLTSimple->DataToXmlByTag($data, 'Data', false);
        //var_dump($data);
        //echo $this->XSLTSimple->saveXML(); die('zz');

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

        $xsl_load = simplexml_load_file($path);
        $xsl_processor = new \XsltProcessor();
        $xsl_processor->registerPHPFunctions();
        $xsl_processor->importStylesheet($xsl_load);
        return $xsl_processor->transformToXML($this->XSLTSimple);
    }
}
