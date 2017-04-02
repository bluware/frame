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
class Params extends Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null)
            /**
             *  @var array
             */
            $this->data = $data;
    }

    /**
     * @param $input
     * @param null $alt
     * @return mixed|null
     */
    public function get($input, $alt = null)
    {
        if ($this->has($input) === true)
            /**
             *  @var mixed
             */
            return parent::get(
                $input, $alt
            );

        /**
         *  @var mixed
         */
        return parent::get(
            str_replace(
                '-', '_', strtoupper($input)
            ), $alt
        );
    }
}
