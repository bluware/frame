<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

use Blu\Secure;

/**
 * @subpackage Http
 */
class Cookie extends CookieAbstract implements CookieInterface
{
    /**
     *  Blu\Secure : for encrypt and set input.
     *
     *  @param  mixed $input
     *  @param  string $key
     *
     *  @return void
     */
    public function encrypt($input, $key = 'default')
    {
        $this->input = Secure::encrypt($input, $key);

        return $this;
    }

    /**
     *  Blu\Secure : for decrypt and return input.
     *
     *  @param  string $key
     *
     *  @return mixed
     */
    public function decrypt($key = 'default')
    {
        return Secure::decrypt($this->input, $key);
    }

    /**
     *  Data transfer.
     *
     *  @param mixed $type
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'string': case 'str':
                return $this->input;
                break;

            case 'integer': case 'int':
                return intval($this->input);
                break;
        }
    }
}
