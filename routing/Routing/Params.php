<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Routing;

use Frame\Data\Writable;

/**
 * @subpackage Routing
 */
class Params extends Writable
{
    public function reset(array $params)
    {
        $this->data = $params;
    }
}
