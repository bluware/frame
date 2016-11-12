<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Request;

/**
 * @subpackage Http
 */
class Server extends \Blu\Data\ReadableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        if (php_sapi_name() === 'cli')
            $data['REQUEST_METHOD'] = 'CLI';

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
            str_replace(
                '-', '_', strtoupper($input)
            ), $alternate
        );
    }
}
