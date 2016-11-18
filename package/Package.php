<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\Package\Dispatcher;

/**
 * @subpackage Package
 */
abstract class Package implements PackageInterface
{
    /**
     *  @var array
     */
    protected $methods = array(
        'config',
        'autoload',
        'router'
    );

    /**
     *  @return void
     */
    final public function __construct()
    {
        foreach ($this->methods as $method)
            method_exists($this, $method) ?
                $this->{$method}() : null;
    }

    /**
     *  @param  array $packages
     *  @param  array $directories
     *
     *  @return \Blu\Package\Dispatcher
     */
    public static function dispatcher(
        array $packages     = null,
        array $directories  = null
    ) {
        return new Dispatcher(
            $packages, $directories
        );
    }
}
