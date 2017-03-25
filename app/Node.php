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
abstract class Node
{
    /**
     * @var App
     */
    protected $app;

    /**
     *  Instance constructor.
     *
     *  @param App $app
     */
    final public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @return App
     */
    final public function app()
    {
        return $this->app;
    }
}