<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Controller;

/**
 * @subpackage Aspect
 */
abstract class Aspect extends Controller
{
    /**
     *  @return mixed
     */
    abstract public function handle();
}
