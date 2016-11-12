<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Package
 */
abstract class Package implements PackageInterface
{
    /**
     *  @return void
     */
    public function __construct()
    {
        /**
         *
         */
        $this->autoload();

        /**
         *
         */
        $this->service();

        /**
         *
         */
        $this->router();
    }

    /**
     *  @return void
     */
    abstract public function autoload();

    /**
     *  @return void
     */
    abstract public function router();

    /**
     *  @return void
     */
    abstract public function service();
}
