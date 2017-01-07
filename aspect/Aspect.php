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
abstract class Aspect extends \Frame\Controller
{
    /**
     *  @return mixed
     */
    abstract public function before();


    /**
     *  @return mixed
     */
    abstract public function after();
}
