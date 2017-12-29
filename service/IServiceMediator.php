<?php

/**
 *  Bluware PHP Lite & Scalable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

/**
 * Interface IServiceMediator
 * @package Frame
 */
interface IServiceMediator
{
    /**
     * @param callable $callableInstance
     * @param array $callableParameters
     * @return mixed
     */
    public function invokeCallable(callable $callableInstance, array $callableParameters);
}
