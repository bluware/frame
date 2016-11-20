<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Package
 */
abstract class Package implements PackageInterface
{
    /**
     *  @var array
     */
    protected $methods = array(
        'bootstrap',
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
}
