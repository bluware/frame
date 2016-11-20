<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Secure;

use Frame\Json;
use Frame\Data;
use Frame\Data\Writable;
use Frame\Data\Readable;

/**
 * @subpackage Secure
 */
class Keychain extends Writable
{
    /**
     *  @const CHIPER
     */
    const CHIPER    = 'AES-256-CBC';

    /**
     *  On create generate custom default.
     *
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        /**
         *  @var boolean
         */
        if ($data === null)
            /**
             *  @var array
             */
            $data = [];

        /**
         *  @var array
         */
        $this->data = array_replace(
            [
                'default' => \Frame\Secure::random(32)
            ], $data
        );
    }

    /**
     *  Encypt $input using secret key
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return mixed
     */
    public function encrypt($input, $key = 'default')
    {
        /**
         *  @var mixed
         */
        $secret = $this->get($key, null);

        /**
         *  @var boolean
         */
        if ($secret === null)
            throw new \Exception(
                "No key found in chain"
            );

        /**
         *  @var mixed
         */
        if (is_object($input) === true) {
            /**
             *  @var mixed
             */
            $input = is_subclass_of(
                $input, Readable::class
            ) ? $input->to('json') : $input;
        }

        /**
         *  @var mixed
         */
        if (is_array($input) === true) {
            /**
             *  @var string
             */
            $input = Json::encode($input);
        }

        /**
         *  @var mixed
         */
        return @openssl_encrypt(
            $input, static::CHIPER, $secret
        );
    }

    /**
     *  Dectypt $input using secret key
     *
     *  @param  mixed  $input
     *  @param  string $key
     *
     *  @return mixed
     */
    public function decrypt($input, $key = 'default')
    {
        /**
         *  @var mixed
         */
        $secret = $this->get($key, null);

        /**
         *  @var boolean
         */
        if ($secret === null)
            throw new \Exception(
                "No key found in chain"
            );

        /**
         *  @var mixed
         */
        $decrypt = openssl_decrypt(
            $input, static::CHIPER, $secret
        );

        /**
         *  @var boolean
         */
        $data = Json::decode(
            $decrypt, $error
        );

        /**
         *  @var boolean
         */
        if ($data !== null)
            /**
             *  @var \Frame\Data
             */
            return new Data($data);

        /**
         *  @var mixed
         */
        return $decrypt === false ?
            null : $decrypt;
    }
}
