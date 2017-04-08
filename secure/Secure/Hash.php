<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Secure;

class Hash
{
    /**
     *  @param string $secret
     */
    public static function make($secret)
    {
        return password_hash(
            $secret, PASSWORD_BCRYPT, [
                'cost' => 12,
            ]
        );
    }

    /**
     *  Alias for dectypt().
     *
     *  @param  string $data
     *
     *  @return mixed
     */
    public static function check($secret, $hash)
    {
        return password_verify(
            $secret, $hash
        );
    }
}
