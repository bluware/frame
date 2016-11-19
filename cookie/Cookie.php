<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Secure;

/**
 * @subpackage Cookie
 */
class Cookie implements CookieInterface
{
    /**
     *  @var string
     */
    protected $name             = 'blu.cookie';

    /**
     *  @var integer
     */
    protected $expire           = 0;

    /**
     *  @var string
     */
    protected $path             = '/';

    /**
     *  @var string
     */
    protected $domain           = null;

    /**
     *  @var bool
     */
    protected $secure           = false;

    /**
     *  @var bool
     */
    protected $http             = true;

    /**
     *  @var string
     */
    protected $input;

    /**
     *  @param string  $name
     *  @param string  $input
     *  @param integer $expire
     *  @param string  $path
     *  @param string  $domain
     *  @param boolean $secure
     *  @param boolean $http
     *
     *  @return void
     */
    public function __construct(
        $name,
        $input      = null,
        $expire     = 0,
        $path       = '/',
        $domain     = null,
        $secure     = false,
        $http       = true
    ) {
        /**
         *  @var string
         */
        $this->name  = $name;

        /**
         *  @var string
         */
        $this->input = $input;

        /**
         *  @var integer
         */
        $this->expire($expire);

        /**
         *  @var string
         */
        $this->path($path);

        /**
         *  @var string
         */
        $this->domain($domain);

        /**
         *  @var bool
         */
        $this->secure($secure);

        /**
         *  @var bool
         */
        $this->http($http);
    }

    /**
     *  Getter for input property.
     *
     *  @return string
     */
    public function get()
    {
        return $this->input;
    }

    /**
     *  Setter for input property.
     *
     *  @param string $input
     *
     *  @return mixed
     */
    public function set($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     *  Input get|set method .
     *
     *  @param mixed $input
     *
     *  @return mixed
     */
    public function input($input = null)
    {
        if ($input === null)
            return $this->get();

        return $this->set($input);
    }

    /**
     *  Get cookie name prop.
     *
     *  @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     *  Complex expire method. Set 0 for session and grater 0 for expire.
     *
     *  @param mixed $expire
     *
     *  @return mixed
     */
    public function expire($expire = null)
    {
        if ($expire === null)
            return $this->expire;

        $this->expire = $expire === 0 ?
            0 : mktime() + $expire;

        return $this;
    }

    /**
     *  Complex get|set path prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function path($path = null)
    {
        if ($path === null)
            return $this->path;

        $this->path = $path;

        return $this;
    }

    /**
     *  Complex get|set domain prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function domain($domain = null)
    {
        if ($domain === null)
            return $this->domain;

        $this->domain = $domain;

        return $this;
    }

    /**
     *  Complex get|set secure prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function secure($secure = null)
    {
        if ($secure === null)
            return $this->secure;

        $this->secure = $secure;

        return $this;
    }

    /**
     *  Complex get|set httpOnly prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function http($http = null)
    {
        if ($http === null)
            return $this->http;

        $this->http = $http;

        return $this;
    }

    /**
     *  Save cookie with $expire set.
     *
     *  @param mixed $expire
     *  @param mixed $input
     *
     *  @return void
     */
    public function touch($expire = null, $input = null)
    {
        if ($expire !== null)
            $this->expire($expire);

        return $this->save($input);
    }

    /**
     *  Save cookie with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function save($input = null)
    {
        if ($input !== null)
            $this->set($input);

        setcookie(
            $this->name,
            $this->input,
            $this->expire,
            $this->path,
            $this->domain,
            $this->secure,
            $this->http
        );

        return $this;
    }

    /**
     *  Remove cookie.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function forget()
    {
        setcookie($this->name, null, -1, '/');

        return $this;
    }

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
