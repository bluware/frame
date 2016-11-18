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
function package($method)
{
    $arguments = func_get_args();

    return forward_static_call_array([
        'Blu\Package', array_shift(
            $arguments
        )
    ], $arguments);
}
