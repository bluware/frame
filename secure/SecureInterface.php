<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Secure
 */
interface SecureInterface
{
    /**
     *  Singleton Frame\Secure\Keychain instanse.
     *
     *  @param  mixed  $method
     *
     *  @return mixed
     */
    public static function keychain($method = null);

    /**
     *  Alphanum random generator.
     *
     *  @param  integer  $length
     *
     *  @return string
     */
    public static function random($length = 8, $key = null);

    /**
     *  Short call Frame\Secure\Keychain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key);

    /**
     *  Short call Frame\Secure\Keychain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key);
}
