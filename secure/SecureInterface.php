<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

interface SecureInterface
{
    /**
     *  Singleton Frame\Secure\Chain instanse.
     *
     *  @param  mixed  $method
     *
     *  @return mixed
     */
    public static function chain($method = null);

    /**
     *  Alphanum random generator.
     *
     *  @param  int  $length
     *
     *  @return string
     */
    public static function random($length = 8, $key = null);

    /**
     *  Short call Frame\Secure\Chain::encrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function encrypt($input, $key);

    /**
     *  Short call Frame\Secure\Chain::decrypt.
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return string
     */
    public static function decrypt($input, $key);
}
