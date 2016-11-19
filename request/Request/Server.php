<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

use Frame\Data\Readable;

/**
 * @subpackage Request
 */
class Server extends Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        if (php_sapi_name() === 'cli')
            $data['REQUEST_METHOD'] = 'CLI';

        $this->data = $data;
    }

    /**
     *  @param  scalar $input
     *  @param  mixed $alternate
     *
     *  @return mixed
     */
    public function get($input, $alternate = null)
    {
        if ($this->has($input) === true)
            /**
             *  @var mixed
             */
            return parent::get(
                $input, $alternate
            );

        /**
         *  @var mixed
         */
        return parent::get(
            str_replace(
                '-', '_', strtoupper($input)
            ), $alternate
        );
    }
}
