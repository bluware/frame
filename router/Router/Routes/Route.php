<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router\Routes;

use Blu\Router\Aspects;

/**
 * @subpackage Http
 */
class Route
{
    /**
     *  @const CAPTURE
     */
    const CAPTURE       = '[a-zA-Z0-9\$\-\_\.\+\!\*\'\(\)]+';

    /**
     *  @var string
     */
    protected $pattern;

    /**
     *  @var mixed
     */
    protected $call;

    /**
     *  @var array
     */
    protected $aspects;

    /**
     *  @var string
     */
    protected $prefix;

    /**
     * [__construct description]
     * @param [type] $state   [description]
     * @param [type] $handler [description]
     * @param array  $aspects [description]
     */
    public function __construct(
        $pattern,
        $handler,
        array $aspects,
        $prefix = null
    ) {
        /**
         *  @var string
         */
        $this->pattern      = $pattern;

        /**
         *  @var mixed
         */
        $this->call         = $handler;

        /**
         *  @var array
         */
        $this->aspects      = $aspects;

        /**
         *  @var string
         */
        $this->prefix       = $prefix;
    }

    /**
     *  @param  [type] $pattern [description]
     *  @param  [type] $matches [description]
     *
     *  @return bool
     */
    public function match($pattern, &$matches = [])
    {
        $matched = boolval(
            preg_match(
                $this->to('regexp'),
                $pattern,
                $matches
            )
        );

        if ($matched === false)
            return false;

        /**
         *  @var array
         */
        $matches = $this->filter(
            $matches
        );

        return true;
    }

    public function filter($matches)
    {
        array_shift($matches);

        foreach ($matches as $key => &$param) {
            /**
             *  unset empty
             */
            if ($param === null || $param === "")
                unset($matches[$key]);

            /**
             *  Prepare integer
             */
            if (is_numeric($param) === true)
                $param = intval($param);
        }

        return $matches;
    }

    /**
     * [run description]
     * @param  Aspects $aspects [description]
     * @param  [type]  $params  [description]
     * @param  [type]  $pass    [description]
     * @return [type]           [description]
     */
    public function eval(
        Aspects $aspects,
        $separator,
        $params, &$pass
    ) {
        $pass = false;

        foreach ($this->aspects as $aspect) {
            $aspect = $aspects->aspect(
                $aspect
            );

            $response = call_user_func_array(
                [
                    $aspect, 'handle'
                ], $params
            );

            $pass = $aspect->pass;

            if ($pass === false)
                return $response;
        }

        if (is_callable($this->call)) {
            return call_user_func_array(
                $this->call, $params
            );
        }

        list($class, $method) = explode(
            $separator, $this->call
        );

        $class = $this->prefix !== null ?
            sprintf(
                '%s\\%s', $this->prefix, $class
            ) : $class;

        $class = new $class();

        $response = call_user_func_array(
            [
                $class, $method
            ], $params
        );

        $pass = $class->pass;

        if ($pass === false)
            return $response;
    }

    /**
     *  @param  [type] $type [description]
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'regexp':
                $xor = str_replace([
                    '/',  '[',  ']', '*'
                ], [
                    '\/', '(|', ')', '.*?'
                ], $this->pattern);

                $all = preg_replace(
                    '/\:[a-zA-Z0-9\_\-]+/',
                    sprintf(
                        '(%s)', static::CAPTURE
                    ),
                    $xor
                );

                return sprintf('/^%s$/', $all);
                break;
        }
    }
}
