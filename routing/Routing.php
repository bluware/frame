<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Routing\Aspects;

/**
 * @subpackage Routing
 */
class Routing
{
    /**
     *  @const CAPTURE
     */
    const CAPTURE           = '[a-zA-Z0-9\$\-\_\.\+\!\*\'\(\)\@]+';

    /**
     *  @var string
     */
    protected $separator    = '@';

    /**
     *  @var array
     */
    protected $method       = 'get';

    /**
     *  @var array
     */
    protected $routes       = [];

    /**
     *  @var array
     */
    protected $group        = [];

    /**
     *  @var array
     */
    protected $aspects      = null;

    /**
     *
     */
    public function __construct()
    {
        /**
         *  @var string
         */
        $method = php_sapi_name() !== 'cli' ? (
            /**
             *  @var boolean
             */
            array_key_exists(
                'REQUEST_METHOD', $_SERVER
            ) ? strtolower(
                $_SERVER['REQUEST_METHOD']
            ) : 'get'
        ) : 'cli';

        /**
         *  @var string
         */
        $this->method = $method;

        /**
         *  @var \Frame\Routing\Aspects
         */
        $this->aspects = new Aspects;
    }

    /**
     *  @return Routing
     */
    public function aspect($aspects, $class = null)
    {
        /**
         *  @var array
         */
        if (gettype($aspects) !== 'array')
            $aspects = [$aspects => $class];

        /**
         *  @var array
         */
        $this->aspects->replace($aspects);

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @return Routing
     */
    public function guard($aspects, $class = null)
    {
        /**
         *  @var $this
         */
        return $this->aspect(
            $aspects, $class
        );
    }

    /**
     *  @return Routing
     */
    public function middleware($aspects, $class = null)
    {
        /**
         *  @var $this
         */
        return $this->aspect(
            $aspects, $class
        );
    }

    /**
     *  @param array $group
     *  @param callable $call
     *
     *  @return Routing
     */
    public function group(array $group, callable $call)
    {
        /**
         *  @var array
         */
        $locks   = $this->group;

        /**
         *  @var boolean
         */
        $nspace = isset($group['namespace'], $locks['namespace']);

        /**
         *  @var boolean
         */
        if ($nspace === true)
            /**
             *  @var boolean
             */
            $group['namespace'] = sprintf(
                '%s\%s',
                $locks['namespace'],
                $group['namespace']
            );

        /**
         *  @var boolean
         */
        $prefix = isset($group['prefix'], $locks['prefix']);

        /**
         *  @var boolean
         */
        if ($prefix === true)
            /**
             *  @var boolean
             */
            $group['prefix'] = $locks['prefix'] . $group['prefix'];

        /**
         *  @var boolean
         */
        $aspect = isset($group['aspect'], $locks['aspect']);

        /**
         *  @var boolean
         */
        if ($prefix === true)
            /**
             *  @var boolean
             */
            $group['aspect'] = array_replace(
                gettype($locks['aspect']) === 'array' ?
                    $locks['aspect'] : [$locks['aspect']],
                gettype($group['aspect']) === 'array' ?
                    $group['aspect'] : [$group['aspect']]
            );

        /**
         *  @var array
         */
        $this->group = $group;

        /**
         *  @var void
         */
        call_user_func($call, $this);

        /**
         *  @var array
         */
        $this->group = $locks;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param array  $methods
     *  @param scalar $patterns
     *  @param mixed  $maker
     *
     *  @return Routing
     */
    public function match($methods, $patterns, $maker = null, $priority = 50)
    {
        /**
         *  @var boolean
         */
        if (gettype($methods) !== 'array')
            /**
             *  @var array
             */
            $methods = array($methods);


        /**
         *  @var boolean
         */
        if ($this->method('in', $methods) === false)
            /**
             *  @var $this
             */
            return $this;

        /**
         *  @var boolean
         */
        if (gettype($patterns) !== 'array')
            /**
             *  @var array
             */
            $patterns = [
                $patterns => $maker
            ];

        /**
         *  @var boolean
         */
        if (is_numeric($maker) === true)
            /**
             *  @var numeric
             */
            $priority = $maker;

        /**
         *  @var void
         */
        foreach ($patterns as $pattern => $maker) {
            /**
             *  @var array
             */
            $data = [
                'route' => $pattern,
                'maker' => $maker,
            ];

            /**
             *  @var boolean
             */
            if (sizeof($this->group) > 0)
                $data['group'] = $this->group;

            /**
             *  @var string
             */
            $key = sprintf(
                ':%s:%s:%s',
                str_pad(
                    $pattern === '*' ?
                        199 : $priority,
                    4, 0,
                    STR_PAD_LEFT
                ), uniqid(), rand(
                    10000000,
                    99999999
                )
            );

            /**
             *  @var array
             */
            $this->routes[$key] = $data;
        }

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $maker
     *
     *  @return Routing
     */
    public function add($methods, $patterns, $maker = null, $priority = 50)
    {
        /**
         *  @var boolean
         */
        return $this->match($methods, $patterns, $maker, $priority);
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function any($pattern, $maker = null, $priority = 50)
    {
        return $this->match(
            [
                'get', 'post', 'put', 'delete'
            ],
            $pattern,
            $maker,
            $priority
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function get($pattern, $maker = null, $priority = 50)
    {
        return $this->match(
            [
                'get'
            ],
            $pattern,
            $maker,
            $priority
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function post($pattern, $maker = null, $priority = 50)
    {
        return $this->match(
            [
                'post'
            ],
            $pattern,
            $maker
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function put($pattern, $maker = null, $priority = 50)
    {
        return $this->match(
            [
                'put'
            ],
            $pattern,
            $maker
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function delete($pattern, $maker = null, $priority = 50)
    {
        return $this->match(
            [
                'delete'
            ], $pattern,
            $maker
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function del($pattern, $maker = null, $priority = 50)
    {
        return $this->delete(
            $pattern,
            $maker
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $maker
     *
     *  @return Routing
     */
    public function cli($pattern, $maker = null, $priority = 50)
    {
        return $this->match([
                'cli'
            ],
            $pattern,
            $maker,
            $priority
        );
    }

    /**
     *  @param array  $methods
     *  @param scalar $pattern
     *  @param mixed  $maker
     *
     *  @return Routing
     */
    public function deny($pattern, $maker = null, $priority = 50)
    {
        return $this->any(
            $pattern,
            $maker,
            $priority + 49
        );
    }

    /**
     *  @return mixed
     */
    public function compile($injection = null)
    {
        /**
         *  @var boolean
         */
        if ($this->method('is', 'cli') === true) {
            /**
             *  @var array
             */
            $argv = $_SERVER['argv'];

            /**
             *  @var void
             */
            array_shift($argv);

            /**
             *  @var string
             */
            $compare = join(' ', $argv);
        } else {
            /**
             *  @var string
             */
            $compare = strtok(
                $_SERVER['REQUEST_URI'], '?'
            );
        }

        ksort($this->routes);

        /**
         *  @var mixed
         */
        foreach ($this->routes as $data) {
            /**
             *  @var boolean
             */
            $prefix = isset($data['group']['prefix']);

            /**
             *  @var boolean
             */
            if ($prefix === true)
                $data['route'] = $data['group']['prefix'] . $data['route'];

            /**
             *  @var boolean
             */
            if (
                preg_match(
                    $this->pattern(
                        $data['route'], $data, $this->method('is', 'cli')
                    ),
                    $compare,
                    $params
                )
            ) {
                /**
                 *  @var array
                 */
                $params = $this->filter($params);

                $injection->locator()->add(
                    new Data(array_combine($data['params'], $params)), 'params'
                );

                /**
                 *  @var null
                 */
                $class  = null;

                /**
                 *  @var boolean
                 */
                $aspects = isset($data['group']['aspect']);

                /**
                 *  @var boolean
                 */
                if ($aspects === true) {
                    /**
                     *  @var mixed
                     */
                    $aspects = $data['group']['aspect'];

                    /**
                     *  @var boolean
                     */
                    if (gettype($aspects) !== 'array')
                        /**
                         *  @var array
                         */
                        $aspects = [$aspects];

                    /**
                     *  @var array
                     */
                    foreach ($aspects as $key => $aspect) {
                        $aspect = $this->aspects->get($aspect);

                        $maked = call_user_func_array([
                            new $aspect($injection), 'before'
                        ], $params);

                        if ($maked !== null)
                            return $maked;
                    }
                }

                /**
                 *  @var array
                 */
                if (gettype($data['maker']) === 'string') {
                    list($class, $method) = explode(
                        $this->separator, $data['maker']
                    );

                    /**
                     *  @var
                     */
                    $nspace = isset($data['group']['namespace']);

                    /**
                     *  @var boolean
                     */
                    if ($nspace === true)
                        $class = sprintf(
                            '%s\\%s',
                            $data['group']['namespace'],
                            $class
                        );

                    /**
                     *  @var array
                     */
                    $data['maker'] = [
                        new $class($injection), $method
                    ];
                }

                $maked = call_user_func_array(
                    $data['maker'], $params
                );

                /**
                 *  @var boolean
                 */
                if ($maked !== null)
                    return $maked;
            }
        }

        return null;
    }

    public function make($injection = null)
    {
        return $this->compile($injection);
    }

    public function run($injection = null)
    {
        return $this->compile($injection);
    }

    /**
     *  @param  mixed $prop
     *  @param  mixed $compare
     *
     *  @return boolean
     */
    public function method($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('method_%s', $prop)
            }($compare);

        return $this->method;
    }

    /**
     *  @param  mixed $prop
     *  @param  mixed $compare
     *
     *  @return boolean
     */
    public function method_is($compare)
    {
        return $this->method === strtolower(
            $compare
        );
    }

    /**
     *  @param  mixed $prop
     *  @param  mixed $compare
     *
     *  @return boolean
     */
    public function method_in(array $compare)
    {
        $compare = array_map(
            'strtolower', $compare
        );

        return in_array(
            $this->method, $compare, true
        );
    }


    /**
     *  @param  [type] $type [description]
     *
     *  @return mixed
     */
    public function pattern($value, &$route, $cli = false)
    {
        $route['params'] = [];

        if ($cli === false && substr($value, 0, 1) !== '/')
            $value = sprintf("/%s", $value);

        $xor = preg_replace([
            '/\//', '/\[/', '/\]/', '/\*/', '/\{\?[a-zA-Z0-9\_\-]+\}/', '/\:\?(?:|[a-zA-Z0-9\-\_])+/',
        ], [
            '\/', '(?:|', ')', '.*?', static::CAPTURE, static::CAPTURE
        ], $value);

        if (preg_match_all('/\{([a-zA-Z0-9\_\-]+)\}/', $xor, $sa) || preg_match_all('/\:([a-zA-Z0-9\_\-])+/', $xor, $sb)) {
            foreach([$sa, $sb] as &$s) {
               if ($s !== null) {
                   array_shift($s);

                   $route['params'] = current($s);
               }
            }
        }

        $all = preg_replace(
            [
                '/\{[a-zA-Z0-9\_\-]+\}/', '/\:[a-zA-Z0-9\_\-]+/',
            ],
            sprintf(
                '(%s)', static::CAPTURE
            ),
            $xor
        );

        return sprintf(
            '/^%s$/', $all
        );
    }

    public function filter($matches)
    {
        /**
         *  @var void
         */
        array_shift($matches);

        /**
         *  @var void
         */
        foreach ($matches as $key => &$param) {
            /**
             *  @var boolean
             */
            if ($param === null || $param === "" || $param === "/")
                unset($matches[$key]);

            /**
             *  @var boolean
             */
            if (is_numeric($param) === true)
                $param = $param + 0;
        }

        /**
         *  @var array
         */
        return $matches;
    }
}
