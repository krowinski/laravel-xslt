<?php
declare(strict_types=1);

namespace Krowinski\LaravelXSLT;

use Illuminate\Support\ServiceProvider;
use Krowinski\LaravelXSLT\Engines\ExtendedSimpleXMLElement;
use Krowinski\LaravelXSLT\Engines\XSLTEngine;
use XSLTProcessor;

class XSLTServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            'view', static function ($app) {
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
                static function () use ($xsltProcessor, $extendedSimpleXMLElement, $app) {
                    return new XSLTEngine($xsltProcessor, $extendedSimpleXMLElement, $app['events']);
                }
            );

            return $factory;
        }
        );
    }
}