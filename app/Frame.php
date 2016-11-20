<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\Service\Autoload;
use Blu\Service\Locator;

/**
 * @subpackage Core
 */
class Frame implements FrameInterface
{
    /**
     *  @var \Blu\Service\Locator
     */
    protected $locator;

    /**
     *  @return void
     */
    protected function __construct()
    {
        $this->locator = new Locator();
    }

    /**
     *  @param  [type] $method [description]
     *
     *  @return [type]         [description]
     */
    public static function singleton($method = null)
    {
        static $singleton = null;

        /**
         *  @var \Blu\Frame
         */
        if ($singleton === null)
            $singleton = new static();

        /**
         *  @var \Blu\Frame
         */
        if ($method === null)
            return $singleton;

        $params = func_get_args();

        return call_user_func_array([
            $singleton,
            array_shift($params)
        ], $params);
    }

    public function autoload($method = null)
    {
        $instance = $this->locator('get', 'autoload');

        if ($instance === null) {
            $instance = new Autoload();

            $this->locator(
                'add',
                $instance->register(),
                'autoload'
            );
        }

        return $this->facade(
            $instance,
            $method,
            func_get_args()
        );
    }

    public function locator($method = null)
    {
        return $this->facade(
            $this->locator,
            $method,
            func_get_args()
        );
    }

    public function locate($service)
    {
        return $this->locator('get', $service);
    }

    public function package($method = null)
    {

    }

    public function database($method = null)
    {

    }

    public function redis($method = null)
    {

    }

    public function service($method = null)
    {

    }

    public function request($method = null)
    {

    }

    public function cookie($method = null)
    {

    }

    public function client($method = null)
    {

    }

    public function router($method = null)
    {

    }

    public function response($method = null)
    {

    }

    public function keychain($method = null)
    {

    }

    protected function facade(
        $instance,
        $method          = null,
        array $arguments = []
    ) {
        if ($instance === null)
            return null;

        if ($method === null)
            return $instance;

        return call_user_func_array([
            $instance, array_shift(
                $arguments
            )
        ], $arguments);
    }
}
