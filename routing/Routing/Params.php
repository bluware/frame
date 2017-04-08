<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Routing;

use Frame\Data\Writable;

class Params extends Writable
{
    public function reset(array $params)
    {
        $this->data = $params;
    }
}
