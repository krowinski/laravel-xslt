<?php
namespace Krowinski\LaravelXSLT\Engines;

use Illuminate\View\Engines\EngineInterface;

class XSLTEngine implements EngineInterface
{

    /** @var Smarty $smarty */
    protected $smarty;

    /**
     * @param Smarty $smarty
     */
    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Get the evaluated contents of the view.
     * @param  string $path
     * @param  array $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return $this->evaluatePath($path, $data);
    }

    /**
     * Get the evaluated contents of the view at the given path.
     *
     * @param string $path
     * @param array $data
     * @return string
     */
    protected function evaluatePath($path, array $data = [])
    {
        ob_start();
        try
        {
            unset($data['__env']);
            if (!$this->smarty->isCached($path))
            {
                foreach ($data as $var => $val)
                {
                    $this->smarty->assign($var, $val);
                }
            }
            // render
            $cacheId = isset($data['smarty.cache_id']) ? $data['smarty.cache_id'] : null;
            $compileId = isset($data['smarty.compile_id']) ? $data['smarty.compile_id'] : null;
            $this->smarty->display($path, $cacheId, $compileId);

        }
        catch (\Exception $e)
        {
            $this->handleViewException($e);
        }
        return ob_get_clean();
    }

    /**
     * @param \Exception $e
     * @throws \Exception
     */
    protected function handleViewException(\Exception $e)
    {
        ob_get_clean();
        throw $e;
    }

}
