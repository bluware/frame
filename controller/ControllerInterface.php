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
    protected function pass();

    /**
     *  @return void
     */
    protected function next();

    /**
     *  @return boolean
     */
    protected function passed();

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    function request($input = null);

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function response($body, $code = 200, $headers = []);
}
