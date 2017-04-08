<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Routing;

use Frame\Data\Writable;
use Frame\Routing;

/**
 * @subpackage Routing
 */
class Cache extends Writable
{
    public function instance($classname, $inject)
    {
        if ($this->has($classname) === true)
            return $this->get($classname);

        $class = new $classname($inject);

        $this->set($classname, $class);

        return $class;
    }
}
