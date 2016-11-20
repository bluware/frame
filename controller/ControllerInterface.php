<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Controller
 */
interface ControllerInterface
{
    /**
     *  @return void
     */
    public function next();

    /**
     *  @return boolean
     */
    public function prevent();
}
