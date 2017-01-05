<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\File;

use Frame\Data;

/**
 *  @subpackage File
 */
class Util
{
    public static function remote($url, $input = null)
    {
        $data = new Data;

        $curl = curl_init( $url );

        curl_setopt_array($curl, [
            CURLOPT_NOBODY          => true,
            CURLOPT_HEADER          => true,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_FOLLOWLOCATION  => true
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response === false)
            throw new Exception("Bad crawl response.");

        if (preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $response, $match ) )
            $code = intval($match[1]);

        if (preg_match( "/Content-Length: (\d+)/", $response, $match ) )
            $data->size = intval($match[1]);

        if (preg_match( "/Content-Type\: ([\w\.\/\+\-]+)/i", $response, $match ) )
            $data->type = $match[1];

        $codes = $code == 200 || ($code > 300 && $code <= 308);

        if ($codes === false)
            throw new Exception("Bad remote file " . $url);

        return $input !== null ? $data->get($input) : $data;
    }
}
