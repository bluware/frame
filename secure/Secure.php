<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Secure\Keychain;

/**
 * @subpackage Secure
 */
class Secure implements SecureInterface
{
    /**
     *  Singleton Frame\Secure\Keychain instanse.
     *
     *  @param  mixed  $method
     *
     *  @return mixed
     */
    public static function keychain($method = null)
    {
        /**
         *  @var mixed
         */
        static $keychain = null;

        /**
         *  @var boolean
         */
        if ($keychain === null)
            /**
             *  @var \Frame\Secure\Keychain
             */
            $keychain = new Keychain();

        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \Frame\Secure\Keychain
             */
            return $keychain;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $keychain,
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
     *  Short call Frame\Secure\Keychain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key)
    {
        /**
         *  @var mixed
         */
        return static::keychain(
            'encrypt', $input, $key
        );
    }

    /**
     *  Short call Frame\Secure\Keychain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key)
    {
        /**
         *  @var mixed
         */
        return static::keychain(
            'decrypt', $input, $key
        );
    }
}
