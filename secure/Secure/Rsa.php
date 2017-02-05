<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Secure;

use Frame\Secure;
use Frame\Secure\Except;

use Frame\Json;
use Frame\Data;
use Frame\Data\Writable;
use Frame\Data\Readable;


/**
 *  @subpackage Secure
 */
class Rsa
{
    /**
     *  @var string
     */
    protected $private;

    /**
     *  @var string
     */
    protected $public;

    /**
     *  @param string $secret
     */
    public function __construct($private, $public)
    {
        if ($private !== null && is_file($private) === true)
            /**
             *  @var Except
             */
            $this->private = file_get_contents($private);

        if ($public !== null && is_file($public) === true)
            /**
             *  @var Except
             */
            $this->public = file_get_contents($public);
    }

    /**
     *  Alias for dectypt()
     *
     *  @param  string $data
     *
     *  @return mixed
     */
    public function public($event, $hash = null)
    {
        return $this->{$event}('public', $hash);
    }

    /**
     *  Alias for dectypt()
     *
     *  @param  string $data
     *
     *  @return mixed
     */
    public function private($event, $hash = null)
    {
        return $this->{$event}(
            'private', $hash
        );
    }

    public function decrypt($type, $hash)
    {
        $hash = base64_decode(
            $hash
        );

        if ($hash === false)
            return null;

        switch ($type) {
            case 'public':
                @openssl_public_decrypt(
                    $hash, $data, $this->public
                );
                break;

            case 'private':
                @openssl_private_decrypt(
                    $hash, $data, $this->private
                );
                break;
        }

        if ($data === false)
            return null;

        /**
         *  @var boolean
         */
        $data = Json::decode(
            $data, $error
        );

        /**
         *  @var boolean
         */
        if ($data !== null && gettype($data) === 'array')
            /**
             *  @var \Frame\Data
             */
            return new Data($data);

        /**
         *  @var mixed
         */
        return $data;
    }

    public function encrypt($type, $hash)
    {
        if (gettype($hash) === 'object')
            $hash = $hash->to('json');

        switch ($type) {
            case 'public':
                @openssl_public_encrypt(
                    $hash, $data, $this->public
                );
                break;

            case 'private':
                @openssl_private_encrypt(
                    $hash, $data, $this->private
                );
                break;
        }

        return base64_encode(
            $data
        );
    }
}
