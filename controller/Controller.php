<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\Http;
use Blu\Response;

/**
 * @subpackage Controller
 */
abstract class Controller implements ControllerInterface
{
    /**
     *  @var boolean
     */
    protected $pass = false;

    /**
     *  @return void
     */
    protected function pass()
    {
        $this->pass = true;

        return $this;
    }

    /**
     *  @return void
     */
    protected function next()
    {
        return $this->pass();
    }

    /**
     *  @return boolean
     */
    protected function passed()
    {
        return $this->pass;
    }

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    function request($input = null)
    {
        if ($input === null)
            return Http::request();

        $params = func_get_args();

        return call_user_func_array([
            Http::request(),
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function response($body, $code = 200, $headers = []) {
        if (
            in_array($body, [
                'text',
                'html',
                'json',
                'redirect',
                'goto'
            ], true)
        ) {
            $params = func_get_args();

            return forward_static_call_array([
                Response::class,
                array_shift($params)
            ], $params);
        }

        return Http::response(
            $body, $code, $headers
        );
    }
}
