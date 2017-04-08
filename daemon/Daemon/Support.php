<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Daemon;

use Frame\App;
use Frame\Daemon;

trait Support
{
    /**
     *  @param null $name
     *  @param int $time
     *
     *  @throws Exception
     *
     *  @return Daemon
     */
    public function daemon($name = null, $time = 1)
    {
        /*
         *  @var boolean
         */
        if (property_exists($this, 'locator') === false) {
            /*
             *  @thrown Exception
             */
            throw new Exception(
                'Locator instance is missed.'
            );
        }

        return $this->locator(
            App::class
        )->daemon(
            $name, $time
        );
    }
}
