<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

interface IBit
{
    /**
     *  @return mixed
     */
    public function __construct($mask, array $maps = null);

    public function get($bit);

    public function mask($mask = null);

    /**
     *  @param int $bit
     *  @param int $value
     */
    public function set($bit, $value);

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __get($bit);

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __set($bit, $value);

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __isset($bit);
}
