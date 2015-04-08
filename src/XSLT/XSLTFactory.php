<?php
namespace Krowinski\LaravelXSLT;

use ReflectionClass;
use Illuminate\View\Factory;
use Illuminate\View\ViewFinderInterface;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;


class XSLTFactory extends Factory
{

    /**
     * @var string  version
     */
    const VERSION = '2.0.0-dev';

    /** @var Smarty $smarty */
    protected $smarty;

    /** @var ConfigContract $config */
    protected $config;

    /**
     * @param EngineResolver $engines
     * @param ViewFinderInterface $finder
     * @param DispatcherContract $events
     * @param Smarty $smarty
     * @param ConfigContract $config
     */
    public function __construct(EngineResolver $engines, ViewFinderInterface $finder, DispatcherContract $events, Smarty $smarty, ConfigContract $config)
    {
        parent::__construct($engines, $finder, $events);
        $this->smarty = $smarty;
        $this->config = $config;
        $this->setConfigure();
    }

    /**
     * @return \Smarty
     */
    public function getSmarty()
    {
        return $this->xslt;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * smarty configure
     * @access private
     * @return void
     */
    private function setConfigure()
    {

    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws MethodNotFoundException
     */
    public function __call($name, $arguments)
    {
        $reflectionClass = new ReflectionClass($this->smarty);
        if (!$reflectionClass->hasMethod($name))
        {
            throw new MethodNotFoundException("{$name} : Method Not Found");
        }
        return call_user_func_array([$this->smarty, $name], $arguments);
    }
}
