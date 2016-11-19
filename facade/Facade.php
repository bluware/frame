<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Facade
 */
trait Facade
{
    /**
     *  @return $mixed
     */
    protected function facade($event, $call, array $argv = [])
    {
        switch ($event) {
            /**
             *  @var mixed
             */
            case 'call':
                return call_user_func_array(
                    $call, $argv
                );
                break;

            case 'static':
                /**
                 *  @var mixed
                 */
                return forward_static_call_array(
                    $call, $argv
                );
                break;
        }
    }
}
