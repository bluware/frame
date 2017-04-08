<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

interface IAspect
{
    /**
     * @return mixed
     */
    public function before();

    /**
     * @return mixed
     */
    public function after();
}
