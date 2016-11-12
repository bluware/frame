<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Secure;

use Blu\Essence\Writeable           as Writeable;
use Blu\Essence\ReadableAbstract    as Readable;

/**
 * @subpackage Secure
 */
class Keychain extends Writeable
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
    public function __construct($data = null)
    {
        parent::__construct([
            'default' => \Blu\Secure::random(32)
        ]);
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
        $secret = $this->get($key, null);

        if ($secret === null)
            throw new \Exception(
                "No key found in chain"
            );

        if (is_object($input) === true) {
            $input = is_subclass_of($input, Readable::class) ?
                $input->to('json') : $input;
        }

        if (is_array($input) === true) {
            $input = json_encode($input);
        }

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
        $secret = $this->get($key, null);

        if ($secret === null)
            throw new \Exception(
                "No key found in chain"
            );

        $decrypt = openssl_decrypt(
            $input, static::CHIPER, $secret
        );

        $json = json_decode($decrypt, true);

        if (json_last_error() === JSON_ERROR_NONE)
            return new Writeable($json);

        return $decrypt === false ?
            null : $decrypt;
    }
}
