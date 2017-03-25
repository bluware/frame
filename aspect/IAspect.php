<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Aspect
 */
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
