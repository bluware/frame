<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

/**
 * @subpackage Http
 */
class Server extends \Blu\Data\Readable
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
