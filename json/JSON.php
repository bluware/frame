<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Secure
 */
class JSON
{
    /**
     *  @param  string $input
     *  @param  mixed $error
     *
     *  @return mixed
     */
    public static function decode($input, &$error = null)
    {
        $decode = json_decode($input, true);
        $error  = json_last_error();

        if ($error === JSON_ERROR_NONE)
            return $decode;

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
            return $input->to('json');
            
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

            default:
                # code...
                break;
        }
    }
}
