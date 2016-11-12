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
interface SecureInterface
{
    /**
     *  Singleton Blu\Secure\Keychain instanse.
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
     *  Short call Blu\Secure\Keychain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key);

    /**
     *  Short call Blu\Secure\Keychain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key);
}
