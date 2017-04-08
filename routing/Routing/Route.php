<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Routing;

use Frame\Data\Writable;
use Frame\Routing;

/**
 * @subpackage Routing
 */
class Route
{
    /**
     *  @var string
     */
    protected $type = 'http';

    /**
     *  @var string
     */
    protected $path;

    /**
     *  @var string|callable
     */
    protected $call;

    /**
     *  @var array
     */
    protected $params   = [];

    /**
     *  @var array
     */
    protected $aspects  = [];

    /**
     * @var int
     */
    protected $priority = 50;

    /**
     *  @param $path
     *  @param $call
     *  @param Group|null $group
     */
    public function __construct($type, $path, $call, Group $group = null)
    {
        /**
         *
         */
        $this->type = $type;

        /**
         *
         */
        $this->path = $path;

        /**
         *
         */
        $this->call = $call;

        if ($group === null)
            return;

        $namespace = $group->get(
            'namespace', null
        );

        if ($namespace !== null && gettype($call) === 'string')
            $this->call = substr(
                $namespace,
                -1
            ) !== '\\' && substr(
                $call,
                0,
                1
            ) !== '\\' ? sprintf(
                '%s\\%s',
                $namespace,
                $call
            ) : $namespace . $call;

        $prefix = $group->get(
            'prefix', null
        );

        if ($type === 'http' && $prefix !== null)
            $this->path = substr(
                $prefix,
                -1
            ) !== '/' && substr(
                $path,
                0,
                1
            ) !== '/' ? sprintf(
                '%s/%s',
                $prefix,
                $path
            ) : $prefix . $path;

        $params = $group->get(
            'params', null
        );

        if ($params !== null)
            $this->params($params);

        $priority = $group->get(
            'priority', null
        );

        if ($priority !== null)
            $this->priority($priority);

        $aspects = $group->get(
            'aspects', null
        );

        if ($aspects !== null)
            $this->aspects($aspects);
    }

    public function aspect($aspect)
    {
        if (in_array($aspect, $this->aspects, true) === false)
            $this->aspects[] = $aspect;

        return $this;
    }

    public function aspects(array $aspects = null)
    {
        if ($aspects === null)
            return $this->aspects;

        foreach ($aspects as $aspect)
            if (in_array($aspect, $this->aspects, true) === false)
                $this->aspects[] = $aspect;

        return $this;
    }

    public function param($key, $val = null)
    {
        if ($val === null)
            return array_key_exists(
                $key, $this->params
            ) ? $this->params[$key] : null;

        $this->params[$key] = $val;

        return $this;
    }

    public function params(array $keys = null)
    {
        if ($keys === null)
            return $this->params;

        $this->params = array_replace(
            $this->params, $keys
        );

        return $this;
    }

    public function path($path = null)
    {
        if ($path === null)
            return $this->path;

        $this->path = $path;

        return $this;
    }

    public function call($call = null)
    {
        if ($call === null)
            return $this->call;

        $this->call = $call;

        return $this;
    }

    public function priority($priority = null)
    {
        if ($priority === null)
            return $this->priority;

        $this->priority = $priority;

        return $this;
    }

    public function match($url, &$params = [])
    {
        return $this->type === 'console' ? $this->matchConsole(
            $url, $params
        ) : $this->matchHttp(
            $url, $params
        );
    }

    public function matchConsole($command, &$params = [])
    {
//        $src = preg_replace([
////
//        ], [
////
//        ], $command);

        $src = $this->path;

        $xor = preg_replace(
            [
                '/\{[a-zA-Z0-9\_\-]+\}/', '/\s\:[a-zA-Z0-9\_\-]+/',
            ], [
                sprintf(
                    '(%s)', Routing::CAPTURE
                ), sprintf(
                    ' (%s)', Routing::CAPTURE
                ),
            ],
            $src
        );

        $success = (bool) preg_match(
            sprintf('/^%s$/', $xor), $command, $matches
        );

        if ($success === false)
            return false;

        $keys = [];

        if (
            preg_match_all(
                '/\{([a-zA-Z0-9\_\-]+)\}/', $src, $match_a
            )
            |
            preg_match_all(
                '/\s\:([a-zA-Z0-9\_\-])+/', $src, $match_b
            )
        ) {
            foreach([$match_a, $match_b] as &$match) {
                if ($match !== null) {
                    array_shift($match);

                    $match = current($match);

                    if (sizeof($match) > 0)
                        $keys = $match;
                }
            }
        }

        /**
         *  @var void
         */
        array_shift($matches);

        foreach ($matches as &$match)
            if (is_numeric($match) === true)
                $match = $match + 0;

        $params = array_combine(
            $keys, $matches
        );

        return true;
    }

    public function matchHttp($url, &$params = [])
    {
        $path = substr(
            $this->path, 0, 1
        ) !== '/' ? sprintf(
            '/%s', $this->path
        ) : $this->path;

        $src = preg_replace([
            '/\//',
            '/\(/',
            '/\[/',
            '/\]/',
            '/\*/',
        ], [
            '\/',
            '(?:',
            '(?:|',
            ')',
            '.*?'
        ], $path);

        foreach ($this->params as $name => $regexp) {
            $src = preg_replace(
                [
                    sprintf(
                        '/(\{\?%s\|%s\?\})/',
                        $name,
                        $name
                    )
                ], sprintf(
                '%s', $regexp
            ),
                $src
            );

            $src = preg_replace(
                sprintf(
                    '/([^\?])\:(\?%s|%s\?)/',
                    $name,
                    $name
                ), sprintf(
                    '$1%s', $regexp
                ),
                $src
            );
        }


        $src = $xor = preg_replace(
            [
                '/\{(?:\?|\?[a-zA-Z0-9\_\-]+|[a-zA-Z0-9\_\-]+\?)\}/',
                '/\:(?:\?|\?[a-zA-Z0-9\-\_]+|[a-zA-Z0-9\-\_]+\?)/',
            ],
            Routing::CAPTURE,
            $src
        );

        foreach ($this->params as $name => $regexp) {
            $xor = preg_replace(

                    sprintf(
                        '/\{%s\}/',
                        $name
                    )
                , sprintf(
                '(%s)', $regexp
            ),
                $xor
            );

            $xor = preg_replace(
                 sprintf(
                    '/([^\?])\:%s/',
                    $name
                ), sprintf(
                '$1(%s)', $regexp
            ),
                $xor
            );
        }


        $xor = preg_replace(
            '/\{[a-zA-Z0-9\_\-]+\}/',
            sprintf(
                '(%s)', Routing::CAPTURE
            ),
            $xor
        );

        $xor = preg_replace(
            '/([^\?])\:[a-zA-Z0-9\_\-]+/',
            sprintf(
                '$1(%s)', Routing::CAPTURE
            ),
            $xor
        );

        $success = (bool) preg_match(
            sprintf('/^%s(?:|\/)$/', $xor), $url, $matches
        );

        if ($success === false)
            return false;

        $keys = [];

        if (
            preg_match_all(
                '/\{([a-zA-Z0-9\_\-]+)\}/', $src, $match_a
            )
            |
            preg_match_all(
                '/[^\?]\:([a-zA-Z0-9\_\-])+/', $src, $match_b
            )
        ) {
            foreach([$match_a, $match_b] as &$match) {
                if ($match !== null) {
                    array_shift($match);

                    $match = current($match);

                    if (sizeof($match) > 0)
                        $keys = $match;
                }
            }
        }

        /**
         *  @var void
         */
        array_shift($matches);

        foreach ($matches as &$match)
            if (is_numeric($match) === true)
                $match = $match + 0;

        $params = array_combine(
            $keys, $matches
        );

        return true;
    }
}
