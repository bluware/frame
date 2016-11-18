<?php

/**
 *  Facades call static package method.
 *
 *  Allow:
 *      package('dispatcher')
 *
 *  @param  string $method
 *
 *  @return mixed
 */
function service($method)
{
    $arguments = func_get_args();

    return forward_static_call_array([
        'Blu\Service', array_shift(
            $arguments
        )
    ], $arguments);
}
