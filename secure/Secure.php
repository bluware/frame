<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\Secure\Keychain;

/**
 * @subpackage Secure
 */
class Secure implements SecureInterface
{
    /**
     *  Singleton Blu\Secure\Keychain instanse.
     *
     *  @param  mixed  $method
     *
     *  @return mixed
     */
    public static function keychain($method = null)
    {
        static $keychain = null;

        if ($keychain === null)
            $keychain = new Keychain();

        if ($method === null)
            return $keychain;

        $params = func_get_args();

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
     *  Short call Blu\Secure\Keychain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key)
    {
        return static::keychain(
            'encrypt', $input, $key
        );
    }

    /**
     *  Short call Blu\Secure\Keychain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key)
    {
        return static::keychain(
            'decrypt', $input, $key
        );
    }
}
