<?php
namespace Krowinski\LaravelXSLT;

use Illuminate\Support\ServiceProvider;
use Krowinski\LaravelXSLT\Engines\XSLTSimple;

/**
 * Class XSLTServiceProvider
 * @package Krowinski\LaravelXSLT
 */
class XSLTServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->app['view'] = $this->app->share(function ($app)
        {
            $factory = new XSLTFactory($app['view.engine.resolver'], $app['view.finder'], $app['events'], $this->app['config'], new XSLTSimple('<App/>'));
            $factory->setContainer($app);
            return $factory;
        });

        $this->app['view']->addExtension('xsl', 'xslt', function ()
        {
            return new Engines\XSLTEngine($this->app['view']->getXSLTSimple());
        });
    }
}
