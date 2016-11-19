<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Json
 */
class Json
{
    /**
     *  @param  string $input
     *  @param  mixed $error
     *
     *  @return mixed
     */
    public static function decode($input, &$error = null)
    {
        /**
         *  @var mixed
         */
        $decode = json_decode($input, true);

        /**
         *  @var integer
         */
        $error  = json_last_error();

        if ($error === JSON_ERROR_NONE)
            /**
             * @var mixed
             */
            return $decode;

        /**
         *  @var null
         */
        return null;
    }

    /**
     *  @param  mixed $input
     *
     *  @return string
     */
    public static function encode($input)
    {
        if (is_object($input) === true)
            /**
             *  @var string
             */
            return $input->to('json');

        /**
         *  @var string
         */
        return json_encode($input);
    }

    /**
     *  @param  mixed $input
     *
     *  @return string
     */
    public static function pretty($input)
    {
        return json_encode(
            $input, JSON_PRETTY_PRINT
        );
    }

    /**
     *  @param  mixed $source
     *
     *  @return string
     */
    public static function from($source)
    {
        switch ($source) {
            case 'php://input':
                return static::decode(
                    file_get_contents('php://input')
                );
                break;
        }
    }
}
