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

    /**
     *  @param  scalar $input     [description]
     *  @param  mixed $alternate [description]
     *
     *  @return mixed
     */
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
}
