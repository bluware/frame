<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Secure\Chain;

/**
 * @subpackage Secure
 */
class Secure implements SecureInterface
{
    /**
     *  Singleton Frame\Secure\Chain instanse.
     *
     *  @param  mixed  $method
     *
     *  @return mixed
     */
    public static function chain($method = null)
    {
        /**
         *  @var mixed
         */
        static $chain = null;

        /**
         *  @var boolean
         */
        if ($chain === null)
            /**
             *  @var \Frame\Secure\Chain
             */
            $chain = new Chain();

        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \Frame\Secure\Chain
             */
            return $chain;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $chain,
            array_shift($params)
        ], $params);
    }

    /**
     *  Alphanum random generator.
     *
     *  @param  integer  $length
     *
     *  @return string
     */
    public static function random($length = 8, $key = null) {
        $pool = array_merge(
            range(0,9), range('a', 'z'),range('A', 'Z')
        );

        for($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }

        return $key;
    }

    /**
     *  Short call Frame\Secure\Chain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key, $type = 'private')
    {
        /**
         *  @var mixed
         */
        return static::chain(
            'encrypt', $input, $key, $type
        );
    }

    /**
     *  Short call Frame\Secure\Chain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key, $type = 'public')
    {
        /**
         *  @var mixed
         */
        return static::chain(
            'decrypt', $input, $key, $type
        );
    }
}
