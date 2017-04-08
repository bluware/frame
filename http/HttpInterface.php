<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

interface HttpInterface
{
    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public static function request($method = null);

    /**
     *  @param  mixed $data
     *
     *  @return Frame\Essence\Response
     */
    public static function response(
        $body, $code = 200, $headers = []
    );
}
