<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame\Http
 *  @author   Eugen Melnychenko
 */
namespace Frame\Daemon;

use Frame\Daemon;
use Frame\App;

/**
 *  @subpackage Daemon
 */
trait Support
{
    /**
     *  @param null $name
     *  @param int $time
     *  @return Daemon
     *
     *  @throws Exception
     */
    public function daemon($name = null, $time = 1)
    {
        /**
         *  @var boolean
         */
        if (property_exists($this, 'locator') === false)
            /**
             *  @thrown Exception
             */
            throw new Exception(
                'Locator instance is missed.'
            );

        return $this->locator(
            App::class
        )->daemon(
            $name, $time
        );
    }
}
