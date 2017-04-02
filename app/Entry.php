<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage App
 */
abstract class Entry
{
    use Locator\Support;

    /**
     * @var App
     */
    protected $app;

    /**
     *  Instance constructor.
     *
     *  @param App $app
     */
    public function __construct(App $app)
    {
        /**
         *  @var \Frame\App
         */
        $this->app      = $app;

        /**
         *  @var \Frame\Locator
         */
        $this->locator  = $app->locator();
    }

    /**
     * @return App
     */
    final public function app()
    {
        return $this->app;
    }
}