<?php


/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function router()
{
    $params = func_get_args();

    return forward_static_call_array([
        'Blu\Http', 'router'
    ], $params);
}
