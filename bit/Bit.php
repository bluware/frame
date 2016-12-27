<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Aspect
 */
class Bit implements BitInterface
{
    /**
     *  @var array
     */
    protected $assoc = [];

    /**
     *  @var array
     */
    protected $mask  = [];

    /**
     *  @var array
     */
    protected $input = 0;

    /**
     *  @return mixed
     */
    public function __construct($input, array $assoc = null)
    {
        /**
         *  @var integer
         */
        $this->input = $input;

        /**
         *  @var integer
         */
        $index = 1;

        /**
         *  @var iterable
         */
        do {
            /**
             *  @var bool
             */
            if ($input & $index) {
                $input -= $index;


            }

            $index += $index;
        } while (
            $input !== 0
        );
    }

    public function get($bit)
    {
        return $this->input & $bit;
    }
}
