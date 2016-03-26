<?php


namespace Krowinski\LaravelXSLT;

use Illuminate\Support\ServiceProvider;
use Krowinski\LaravelXSLT\Engines\ExtendedSimpleXMLElement;
use Krowinski\LaravelXSLT\Engines\XSLTEngine;
use XSLTProcessor;

/**
 * Class XSLTServiceProvider
 * @package Krowinski\LaravelXSLT
 */
class XSLTServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('view', function ($app) {
            $xsltProcessor = new XsltProcessor();
            $xsltProcessor->registerPHPFunctions();
            $extendedSimpleXMLElement = new ExtendedSimpleXMLElement('<App/>');

            $factory = new XSLTFactory(
                $app['view.engine.resolver'],
                $app['view.finder'],
                $app['events'],
                $extendedSimpleXMLElement
            );
            $factory->setContainer($app);
            $factory->addExtension(
                'xsl',
                'xslt',
                function () use ($xsltProcessor, $extendedSimpleXMLElement, $app) {
                    return new XSLTEngine($xsltProcessor, $extendedSimpleXMLElement, $app['events']);
                }
            );

            return $factory;
        });
    }
}