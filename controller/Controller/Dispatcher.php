<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Controller;

use Blu\Router\Routes\Route;

/**
 * @subpackage Controller
 */
class Dispatcher implements DispatcherInterface
{
    public function dispatch(Route $route)
    {

    }
}

// Aspects $aspects,
// $separator,
// $params, &$pass
// ) {
// $pass = false;
//
// foreach ($this->aspects as $aspect) {
//     $aspect = $aspects->aspect(
//         $aspect
//     );
//
//     $response = call_user_func_array(
//         [
//             $aspect, 'handle'
//         ], $params
//     );
//
//     $pass = $aspect->pass;
//
//     if ($pass === false)
//         return $response;
// }
//
// if (is_callable($this->call)) {
//     return call_user_func_array(
//         $this->call, $params
//     );
// }
//
// list($class, $method) = explode(
//     $separator, $this->call
// );
//
// $class = $this->prefix !== null ?
//     sprintf(
//         '%s\\%s', $this->prefix, $class
//     ) : $class;
//
// $class = new $class();
//
// $response = call_user_func_array(
//     [
//         $class, $method
//     ], $params
// );
//
// $pass = $class->pass;
//
// if ($pass === false)
//     return $response;
