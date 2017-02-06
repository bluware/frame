<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Secure;

use Frame\Secure;
use Frame\Json;
use Frame\Data;
use Frame\Data\Writable;
use Frame\Data\Readable;

/**
 * @subpackage Secure
 */
class Chain extends Writable
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
                'default'
                    => Secure::random(32)
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
    public function encrypt($input, $key = 'default', $type = 'private')
    {
        /**
         *  @var mixed
         */
        $secret = $this->get($key, null);

        if (gettype($secret) === 'object')
            return $secret->encrypt(
                $type, $input
            );

        /**
         *  @var bool
         */
        if ($secret === null)
            throw new \Exception(
                'No key found in chain'
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
            $input = Json::encode(
                $input
            );
        }

        /**
         *  @var mixed
         */
        return @openssl_encrypt(
            $input,
            static::CHIPER,
            $secret
        );
    }

    public function set($name, $data)
    {
        if (gettype($data) !== 'array')
            return parent::set(
                $name, $data
            );

        return parent::set(
            $name, new Rsa(
                $data['private'],
                $data['public']
            )
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
    public function decrypt($input, $key = 'default', $type = 'public')
    {
        /**
         *  @var mixed
         */
        $secret = $this->get($key, null);

        if (gettype($secret) === 'object')
            return $secret->decrypt(
                $type, $input
            );

        /**
         *  @var bool
         */
        if ($secret === null)
            throw new \Exception(
                'No key found in chain'
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
