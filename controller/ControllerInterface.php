<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
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

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    public function request($input = null);

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function response($body, $code = 200, $headers = []);
}
