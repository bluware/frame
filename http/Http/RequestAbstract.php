<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

/**
 * @subpackage Http
 */
abstract class RequestAbstract extends \Blu\Essence\ReadableAbstract
{
    /**
     *  @var \Blu\Http\Request\Query
     */
    protected $query;

    /**
     *  @var \Blu\Http\Request\Body
     */
    protected $body;

    /**
     *  @var \Blu\Http\Request\Files
     */
    protected $files;

    /**
     *  @var \Blu\Http\Request\Cookie
     */
    protected $cookie;

    /**
     *  @var \Blu\Http\Request\Server
     */
    protected $server;

    /**
     * [__construct description]
     */
    public function __construct(
        array $query    = null,
        array $body     = null,
        array $files    = null,
        array $cookie   = null,
        array $server   = null
    ) {
        /**
         *  @param \Blu\Http\Request\Query
         */
        $this->query = new \Blu\Http\Request\Query(
            $query !== null ? $query : $_GET
        );

        /**
         *  @param \Blu\Http\Request\Files
         */
        $this->files = new \Blu\Http\Request\Files(
            $files !== null ? $files : $_FILES
        );

        /**
         *  @param \Blu\Http\Request\Cookie
         */
        $this->cookie = new \Blu\Http\Request\Cookie(
            $cookie !== null ? $cookie : $_COOKIE
        );

        /**
         *  @param \Blu\Http\Request\Cookie
         */
        $this->server = new \Blu\Http\Request\Server(
            $server !== null ? $server : $_SERVER
        );

        /**
         *  @param \Blu\Http\Request\Body
         */
        $this->body = new \Blu\Http\Request\Body(
            $body !== null ? $body : $_POST
        );
    }

    /**
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function query($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->query;

        return $this->query->get(
            $input, $alternate
        );
    }

    /**
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function body($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->body;

        return $this->body->get(
            $input, $alternate
        );
    }

    /**
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function files($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->files;

        return $this->files->get(
            $input, $alternate
        );
    }

    /**
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function cookie($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->cookie;

        return $this->cookie->get(
            $input, $alternate
        );
    }

    /**
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function server($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->server;

        return $this->server->get(
            $input, $alternate
        );
    }
}
