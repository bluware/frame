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

/**
 *  @subpackage Secure
 */
class Secret
{
    /**
     *  @const CHIPER
     */
    const CHIPER    = 'AES-256-CBC';

    /**
     *  @var string
     */
    protected $secret;

    /**
     *  @param string $secret
     */
    public function __construct($secret)
    {
        /**
         *  @var bool
         */
        if (gettype($secret) !== 'string')
            /**
             *  @var Except
             */
            throw new Except(
                'Secret should be a string'
            );

        /**
         *  @var bool
         */
        if (strlen($secret) < 16)
            /**
             *  @var Except
             */
            throw new Except(
                'Secret cannot be less than 16 char'
            );

        /**
         *  @var string
         */
        $this->secret = $secret;
    }

    /**
     *  Alias for dectypt()
     *
     *  @param  string $data
     *
     *  @return mixed
     */
    public function encrypt($data)
    {
        /**
         *  @var mixed
         */
        $encrypt = @openssl_encrypt(
            $data,
            static::CHIPER,
            $this->secret
        );

        return $encrypt !== false ?
            $encrypt : null;
    }

    /**
     *  Alias for dectypt()
     *
     *  @param  string $data
     *
     *  @return mixed
     */
    public function decrypt($data)
    {
        $decrypt = openssl_decrypt(
            $data, static::CHIPER, $this->secret
        );

        return $decrypt !== false ?
            $decrypt : null;
    }
}
