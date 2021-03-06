<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Routing\Exception;
use Frame\Routing\Aspects;
use Frame\Routing\Cache;
use Frame\Routing\Group;
use Frame\Routing\Params;
use Frame\Routing\Route;
use Frame\Routing\Routes;

class Routing
{
    /**
     *  @const CAPTURE
     */
    const CAPTURE = '[a-zA-Z0-9\$\-\_\.\+\!\*\'\(\)\@]+';

    /**
     *  @var string
     */
    protected $separator = '@';

    /**
     *  @var array
     */
    protected $method = 'get';

    /**
     *  @var \Frame\Request
     */
    protected $request;

    /**
     *  @var array
     */
    protected $routes;

    /**
     *  @var array
     */
    protected $routePaths = [];

    /**
     *  @var array
     */
    protected $group;

    /**
     *  @var array
     */
    protected $aspects;

    /**
     *  @var array
     */
    protected $cache;

    /**
     *  @var array
     */
    protected $route;

    /**
     *  @var array
     */
    protected $params;

    /**
     *  Routing constructor.
     *
     *  @param Request $request
     */
    public function __construct(Request $request)
    {
        /*
         *  @var \Frame\Request
         */
        $this->request = $request;

        /*
         *  @var \Frame\Routing\Aspects
         */
        $this->aspects = new Aspects();

        /*
         *  @var \Frame\Routing\Group
         */
        $this->group = new Group();

        /*
         *  @var \Frame\Routing\Routes
         */
        $this->routes = new Routes();

        /*
         *  @var \Frame\Routing\Routes
         */
        $this->cache = new Cache();

        /*
         *  @var \Frame\Routing\Routes
         */
        $this->params = new Params();

        $this->method = $request->is('cli') ?
            'cli' : strtolower(
                $request->method()
            );
    }

    /**
     * @param $methods
     * @param $paths
     * @param null  $call
     * @param array $options
     *
     * @return $this
     */
    public function match($methods, $paths, $call = null, $options = [])
    {
        /*
         *  @var boolean
         */
        if (gettype($methods) !== 'array') {
            /**
             *  @var array
             */
            $methods = [$methods];
        }

        if (gettype($paths) === 'array') {
            $options = $call;
        }

        /*
         *  @var boolean
         */
        if (gettype($paths) !== 'array') {
            /**
             *  @var array
             */
            $paths = [$paths => $call];
        }

        foreach ($paths as $path => $call) {
            $this->routePaths[] = $path;
        }

        /*
        *  @var boolean
        */
        if (in_array($this->method, $methods, true) === false) {
            /*
            *  @var $this
            */
            return $this;
        }

        /*
         *  @var void
         */
        foreach ($paths as $path => $call) {
            if (is_callable($call) === false && strpos($call, $this->separator) === false)
                throw new Exception(
                    sprintf('Bad routing handler for \'%s\'', $path)
                );

            $this->routes->add(
                $this->method === 'cli' ? 'console' : 'http',
                $path,
                $call,
                $options,
                $this->group
            );
        }

        /*
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param array $options
     *
     *  @return Routing
     */
    public function any($path, $call = null, $options = [])
    {
        return $this->match(
            ['get', 'post', 'put', 'delete', 'patch', 'options'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param array $options
     *
     *  @return Routing
     */
    public function get($path, $call = null, $options = [])
    {
        return $this->match(
            ['get'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param array $options
     *
     *  @return Routing
     */
    public function post($path, $call = null, $options = [])
    {
        return $this->match(
            ['post'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param array $options
     *
     *  @return Routing
     */
    public function put($path, $call = null, $options = [])
    {
        return $this->match(
            ['put'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param array $options
     *
     *  @return Routing
     */
    public function delete($path, $call = null, $options = [])
    {
        return $this->match(
            ['delete'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param mixed $options
     *
     *  @return Routing
     */
    public function del($path, $call = null, $options = [])
    {
        return $this->match(
            ['delete'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param mixed $options
     *
     *  @return Routing
     */
    public function patch($path, $call = null, $options = [])
    {
        return $this->match(
            ['patch'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param mixed $options
     *
     *  @return Routing
     */
    public function options($path, $call = null, $options = [])
    {
        return $this->match(
            ['options'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param mixed $options
     *
     *  @return Routing
     */
    public function cli($path, $call = null, $options = [])
    {
        return $this->match(
            ['cli'], $path, $call, $options
        );
    }

    /**
     *  @param $path
     *  @param null $call
     *  @param mixed $options
     *
     *  @return Routing
     */
    public function deny($paths, $call = null, $options = [])
    {
        if (gettype($paths) === 'array') {
            $options = gettype($call) === 'array' ? $call : [];
        }

        if (gettype($paths) !== 'array') {
            $paths = [$paths => $call];
        }

        foreach ($paths as $path => $call) {
            if ($path === '*') {
                $options['priority'] = array_key_exists('priority', $options) === true ? $options['priority'] + 99 : 149;
            } else {
                $options['priority'] = array_key_exists('priority', $options) === true ? $options['priority'] + 49 : 99;
            }

            $this->any($path, $call, $options);
        }

        return $this;
    }

    /**
     *  @param $key
     *  @param null $val
     *
     *  @throws Exception
     *
     *  @return $this
     */
    public function param($key, $val = null)
    {
        $this->group->param($key, $val);

        return $this;
    }

    /**
     *  @param array|null $keys
     *
     *  @throws Exception
     *
     *  @return $this
     */
    public function params(array $keys = null)
    {
        $this->group->params($keys);

        return $this;
    }

    /**
     *  @param null $prefix
     *
     *  @throws Exception
     *
     *  @return $this
     */
    public function prefix($prefix = null)
    {
        $this->group->prefix($prefix);

        return $this;
    }

    /**
     *  @param null $namespace
     *
     *  @throws Exception
     *
     *  @return $this
     */
    public function namespace($namespace = null)
    {
        $this->group->namespace($namespace);

        return $this;
    }

    public function aspect($name, $call = null)
    {
        if ($call === null) {
            $this->aspects->get($name);
        }

        $this->aspects->set($name, $call);

        return $this;
    }

    public function aspects(array $aspects = null)
    {
        if ($aspects === null) {
            $this->aspects->get($aspects);
        }

        $this->aspects->replace(
            $aspects
        );

        return $this;
    }

    /**
     *  @param array $group
     *  @param callable $call
     *
     *  @return $this
     */
    public function group(array $group, callable $call)
    {
        $snapshot = $this->group->snapshot();

        if (array_key_exists('namespace', $group) === true) {
            $namespace = $this->group->get('namespace');

            $this->group->set(
                'namespace', $namespace === null ? $group['namespace'] : (
                    substr($namespace, -1) !== '\\' && substr($group['namespace'], 0, 1) !== '\\' ?
                        sprintf('%s\\%s', $namespace, $group['namespace']) : $namespace.$group['namespace']
                )
            );
        }

        if (array_key_exists('prefix', $group) === true) {
            $prefix = $this->group->get('prefix');

            $this->group->set(
                'prefix', $prefix === null ? $group['prefix'] : (
                    substr($prefix, -1) !== '\\' && substr($group['prefix'], 0, 1) !== '\\' ?
                        sprintf('%s\\%s', $prefix, $group['prefix']) : $prefix.$group['prefix']
                )
            );
        }

        if (array_key_exists('aspect', $group) === true) {
            $this->group->aspect($group['aspect']);
        }

        if (array_key_exists('aspects', $group) === true) {
            $this->group->aspects($group['aspects']);
        }

        call_user_func($call, $this);

        // configure & call

        $this->group->restore($snapshot);

        return $this;
    }

    protected function screening($path)
    {
        while (strpos($path, '//') !== false) {
            $path = str_replace('//', '/', $path);
        }

        return $path;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dispatch(App $injection = null)
    {
        $injection->getServiceLocator()->addService($this->params, 'params');

        $this->routes->sort();

        /*
         *  @var boolean
         */
        if ($this->method === 'cli') {
            /**
             *  @var array
             */
            $argv = $_SERVER['argv'];

            /*
             *  @var void
             */
            array_shift($argv);

            /**
             *  @var string
             */
            $compare = implode(' ', $argv);

            $routes = $this->routes;
        } else {
            /**
             *  @var string
             */
            $compare = $this->request->path();

            if (strpos($compare, '//') !== false) {
                return Response::redirect(
                    $this->screening($compare)
                );
            }

            if (strlen($compare) > 1) {
                $compare = substr($compare, 1);

                if (substr($compare, -1) === '/') {
                    $compare = substr(
                        $compare, 0, strlen($compare) - 1
                    );
                }
            }

            $routes = $this->getOptimizedRoutes(
                $compare
            );
        }

        $params = [];

        foreach ($routes as $route) {
            if ($route->match($compare, $params) === true) {
                $this->route = $route;

                $this->params->reset($params);

                $aspects = $route->aspects();

                foreach ($aspects as $aspect) {
                    if ($this->aspects->has($aspect) === true) {
                        $aspect = $this->aspects->get($aspect);
                    }

                    if (gettype($aspect) === 'string' && class_exists($aspect) === false) {
                        throw new Exception(
                            sprintf('Aspect \'%s\' missed.', $aspect)
                        );
                    }

                    if (is_callable($aspect) === false) {
                        if (strpos($aspect, $this->separator) === false) {
                            $aspect = sprintf('%s@handle', $aspect);
                        }

                        $class = $this->cache->instance(strtok($aspect, $this->separator), $injection);

                        $aspect = [$class, strtok($this->separator)];
                    }

                    if (is_callable($aspect) === false) {
                        throw new Exception(
                            gettype($aspect) === 'array' ? sprintf(
                                'Aspect \'%s\' has no method \'%s\'.' , get_class($aspect[0]), $aspect[1]
                            ) : 'Aspect is not callable.'
                        );

                    }

                    $success = $injection->getService(
                        'mediator'
                    )->dispatch(
                        $aspect, $params
                    );

                    if ($success !== null) {
                        return $success;
                    }
                }

                $call = $route->call();

                if (is_callable($call) === false) {
                    $class = $this->cache->instance(strtok($call, $this->separator), $injection);

                    $call = [$class, strtok($this->separator)];

                    $route->call($call);
                }

                $success = $injection->getService(
                    'mediator'
                )->dispatch(
                    $call, $params
                );

                if ($success !== null) {
                    return $success;
                }
            }
        }
    }

    protected function getOptimizedRoutes($realPath = '/')
    {
        $exportRoutes = [];
        $isIndexPath  = $realPath === '/';
        $pathSegments = $isIndexPath ? [$realPath] : explode('/', $realPath);

        foreach($this->routes as $route) {
            $routePath = $route->path();

            if ($isIndexPath === true) {
                if ($routePath === '/' || strpos($routePath, '*') !== false) {
                    $exportRoutes[] = $route;
                }
            } else {
                $routeSegments = $routePath === '/' ? [$routePath] : explode('/', $routePath);
                
                if (strpos($routePath, '*') !== false) {
                    $exportRoutes[] = $route;
                } else if (sizeof($pathSegments) === sizeof($routeSegments)) {
                    $pushVerification = $this->routeSegmentsValidation(
                        $pathSegments, $routeSegments
                    );

                    if ($pushVerification === true) {
                        $exportRoutes[] = $route;
                    }
                }
            }
        }

        return $exportRoutes;
    }

    protected function routeSegmentsValidation(array $pathSegments, array $routeSegments)
    {
        $index = -1;

        while (++$index < sizeof($routeSegments)) {
            $routeSegment = $routeSegments[$index];

            if ($this->segmentIsDynamic($routeSegment) === false) {
                $pathSegment = $pathSegments[$index];

                if ($pathSegment !== $routeSegment) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function segmentIsDynamic($routeSegment)
    {
        return strpos(
            $routeSegment, ':'
        ) !== false || strpos(
            $routeSegment, '{'
        ) !== false;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRoutePaths()
    {
        return $this->routePaths;
    }
}
