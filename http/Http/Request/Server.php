<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http\Request;

/**
 * @subpackage Http
 */
class Server extends \Blu\Essence\ReadableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    public function get($input, $alternate = null)
    {
        if ($this->has($input) === true)
            return parent::get(
                $input, $alternate
            );

        return parent::get(
            strtoupper($input), $alternate
        );
    }

    /**
     * @param  $prop       [description]
     * @param  $comparison [description]
     *
     * @return boolean             [description]
     */
    public function is($prop, $comparison = null)
    {
        return call_user_func([
            $this, sprintf('is_%s', $prop)
        ], $comparison);
    }

    /**
     *
     */
    public function is_console()
    {
        return php_sapi_name() === 'cli';
    }

    /**
     *
     */
    public function is_local()
    {
        return preg_match(
            '/(127\.0\.0\.1|192\.168\.[0-9]{1,3}\.[0-9]{1,3})/',
            $this->get('remote_addr', '0.0.0.0')
        );
    }

    /**
     *  @return string
     */
    public function protocol()
    {
        return $this->get('https', 'off') !== 'off' ?
            'https' : 'http';
    }
}
