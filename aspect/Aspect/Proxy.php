<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Aspect;

use Blu\Aspect;

/**
 * @subpackage Aspect
 */
abstract class Proxy
{
    /**
     *  @param  string $method
     *  @param  array  $params
     *
     *  @return mixed
     */
    final public function __call($method, $params)
    {
        Aspect::before(
            get_called_class(), $method, $params
        );

        $return = call_user_func_array([
            $this, $method
        ], $params);

        Aspect::after(
            get_called_class(), $method, $params
        );

        return $return;
    }
}
