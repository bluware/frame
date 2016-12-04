<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http;

use Frame\Http\Request\Body;
use Frame\Http\Request\Cookies;
use Frame\Http\Request\Files;
use Frame\Http\Request\Query;
use Frame\Http\Request\Server;
use Frame\Data\Readable;
use Frame\Json;

/**
 * @subpackage Request
 */
class Request extends Readable implements RequestInterface
{
    /**
     *  @var \Frame\Request\Query
     */
    protected $query;

    /**
     *  @var \Frame\Request\Body
     */
    protected $body;

    /**
     *  @var \Frame\Request\Files
     */
    protected $files;

    /**
     *  @var \Frame\Request\Cookies
     */
    protected $cookies;

    /**
     *  @var \Frame\Request\Server
     */
    protected $server;

    /**
     * @return void
     */
    public function __construct(
        array $query    = null,
        array $body     = null,
        array $files    = null,
        array $cookies  = null,
        array $server   = null
    ) {
        /**
         *  @param \Frame\Request\Query
         */
        $this->query = new Query(
            $query !== null ? $query : $_GET
        );

        /**
         *  @param \Frame\Request\Files
         */
        $this->files = new Files(
            $files !== null ? $files : $_FILES
        );

        /**
         *  @param \Frame\Request\Cookie
         */
        $this->server = new Server(
            array_replace(
                [
                    'SERVER_NAME'           => 'localhost',
                    'SERVER_PORT'           => 80,
                    'HTTP_HOST'             => 'localhost',
                    'HTTP_USER_AGENT'       => 'Frame/1.x',
                    'HTTP_ACCEPT'           => '*/*',
                    'HTTP_ACCEPT_LANGUAGE'  => 'en-us,en;q=0.5',
                    'HTTP_ACCEPT_CHARSET'   => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                    'REMOTE_ADDR'           => '127.0.0.1',
                    'SCRIPT_NAME'           => '',
                    'SCRIPT_FILENAME'       => '',
                    'SERVER_PROTOCOL'       => 'HTTP/1.1',
                    'REQUEST_TIME'          => time(),
                    'REQUEST_URI'           => '/',
                ], $server !== null ? $server : $_SERVER
            )
        );

        /**
         *  @param \Frame\Request\Cookie
         */
        $this->cookies = new Cookies(
            $cookies !== null ? $cookies : $_COOKIE, $this->secure()
        );

        /**
         *  Prepare input stream buffer
         *
         *  If request type 'json', than inject body
         */
        if ($this->is('json') && $body === null)
            $body = Json::from('php://input');

        /**
         *  @param \Frame\Request\Body
         */
        $this->body = new Body(
            $body !== null ? $body : $_POST
        );

        /**
         *  @param \Frame\Data
         */
        $this->data = $this->{
            $this->method('is', 'GET') ?
                'query' : 'body'
        }->data();
    }

    /**
     *  @param scalar $key
     *
     *  @return boolean
     */
    public function has($instance, $key = null)
    {
        if ($key === null)
            /**
             *  @var boolean
             */
            return parent::has($instance);

        /**
         *  @var boolean
         */
        return $this->{$instance}->has(
            $key
        );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Query query()
     *      mixed query($input)
     *      array query([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function query($input = null, $alternate = null)
    {
        if ($input === null)
            /**
             *  @var Frame\Request\Query
             */
            return $this->query;

        /**
         *  @var mixed
         */
        return $this->query
            ->get(
                $input, $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Body body()
     *      mixed body($input)
     *      array body([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function body($input = null, $alternate = null)
    {
        if ($input === null)
            /**
             *  @var Frame\Request\Body
             */
            return $this->body;

        /**
         *  @var mixed
         */
        return $this->body
            ->get(
                $input, $alternate
            );
    }

    /**
     *  Compare and get '$_POST' params.
     *
     *  Usage:
     *      mixed post()
     *      mixed post($input)
     *      array post([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function post($input = null, $alternate = null)
    {
        /**
         *  @var mixed
         */
        return $this->method('is', 'post') ?
            $this->body($input, $alternate) : null;
    }

    /**
     *  Compare and get '$_PUT' params.
     *
     *  Usage:
     *      mixed put()
     *      mixed put($input)
     *      array put([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function put($input = null, $alternate = null)
    {
        /**
         *  @var mixed
         */
        return $this->method('is', 'put') ?
            $this->body($input, $alternate) : null;
    }

    /**
     *  Compare and get '$_DELETE' params.
     *
     *  Usage:
     *      mixed delete()
     *      mixed delete($input)
     *      array delete([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function delete($input = null, $alternate = null)
    {
        /**
         *  @var mixed
         */
        return $this->method('is', 'delete') ?
            $this->body($input, $alternate) : null;
    }

    /**
     *  Alias for delete() method.
     *
     *  Usage:
     *      mixed del()
     *      mixed del($input)
     *      array del([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function del($input = null, $alternate = null)
    {
        /**
         *  @var mixed
         */
        return $this->delete(
            $input, $alternate
        );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Files files()
     *      mixed files($input)
     *      array files([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function files($input = null, $alternate = null)
    {
        if ($input === null)
            /**
             *  @var Frame\Request\Files
             */
            return $this->files;

        /**
         *  @var array|null
         */
        return $this->files
            ->get(
                $input, $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Cookie cookie()
     *      mixed cookie($input)
     *      array cookie([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function cookie($input = null, $alternate = null)
    {
        if ($input === null)
            /**
             *  @var Frame\Request\Cookies
             */
            return $this->cookies;

        /**
         *  @var Frame\Cookie
         */
        return $this->cookies
            ->get(
                $input, $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Server server()
     *      mixed server($input)
     *      array server([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function server($input = null, $alternate = null)
    {
        if ($input === null)
            /**
             *  @var Frame\Request\Server
             */
            return $this->server;

        /**
         *  @var string|null
         */
        return $this->server
            ->get(
                $input, $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Server server()
     *      mixed server($input)
     *      array server([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function header($input, $alternate = null)
    {
        /**
         *  @var string|null
         */
        return $this->server(
            sprintf('HTTP_%s', $input)
        );
    }

    /**
     *  Get method or use comparison methods
     *
     *  Usage:
     *      string schema()
     *      bool   schema('is', $schema)
     *      bool   schema('in', [$schema_a, $schema_b])
     *
     *  @param  scalar $prop
     *  @param  scalar $compare
     *
     *  @return mixed
     */
    public function schema($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('schema_%s', $prop)
            }($compare);

        return $this->server('HTTPS', 'off') !== 'off'
            || $this->port() === 443 ? 'https' : 'http';
    }

    /**
     *  Compare request method, use schema('is', $schema) instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function schema_is($compare)
    {
        return strtolower(
            $compare
        ) === $this->schema();
    }

    /**
     *  Compare request method, use schema('in', [$schema_a, $schema_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function schema_in(array $compare)
    {
        $compare = array_map(
            'strtolower', $compare
        );

        return in_array(
            $this->schema(),
            $compare,
            true
        );
    }

    /**
     *  Get requested schema
     *
     *  @return bool
     */
    public function secure()
    {
        return $this->schema('is', 'https');
    }

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('host_%s', $prop)
            }($compare);

        return $this->header(
            'HOST', '127.0.0.1'
        );
    }

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host_is($compare)
    {
        return $this->host() === $compare;
    }

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host_in(array $compare)
    {
        return in_array(
            $this->host(), $compare, true
        );
    }

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('port_%s', $prop)
            }($compare);

        return intval(
            $this->server(
                'SERVER_PORT', 80
            )
        );
    }

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port_is($compare)
    {
        return $this->port() === intval(
            $compare
        );
    }

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port_in(array $compare)
    {
        $compare = array_map(
            'intval', $compare
        );

        return in_array(
            $this->port(), $compare, true
        );
    }

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('uri_%s', $prop)
            }($compare);

        return $this->server(
            'REQUEST_URI', '/'
        );
    }

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri_is($compare)
    {
        return $this->uri() === intval(
            $compare
        );
    }

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri_in(array $compare)
    {
        return in_array(
            $this->uri(), $compare, true
        );
    }

    /**
     *  Get path.
     *
     *  @return string
     */
    public function path($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('path_%s', $prop)
            }($compare);

        return strtok(
            $this->uri(), '?'
        );
    }

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function path_is($compare)
    {
        return $this->path() === intval(
            $compare
        );
    }

    /**
     *  Get server path.
     *
     *  @return string
     */
    public function path_in(array $compare)
    {
        return in_array(
            $this->path(), $compare, true
        );
    }

    /**
     *  Get url address with possible replacement path.
     *
     *  @return string
     */
    public function url($path = null)
    {
        if ($path !== null)
            $path = $path[0] !== '/' ?
                sprintf('/%s', $path) : $path;

        return sprintf(
            "%s://%s%s%s",
            $this->schema(),
            $this->host(),
            $this->port('in', [80, 443]) ? '' : sprintf(
                ':%s', $this->port()
            ),
            $path !== null ?
                $path : $this->path()
        );
    }

    /**
     *  Get method or use comparison methods
     *
     *  Usage:
     *      string method()
     *      bool   method('is', $method)
     *      bool   method('in', [$method_a, $method_b])
     *
     *  @param  scalar $prop
     *  @param  scalar $compare
     *
     *  @return mixed
     */
    public function method($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('method_%s', $prop)
            }($compare);

        return $this->server(
            'REQUEST_METHOD', 'GET'
        );
    }

    /**
     *  Compare request method, use method('is', $method) instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function method_is($compare)
    {
        return $this->method() === strtoupper($compare);
    }

    /**
     *  Compare request method, use method('in', [$method_a, $method_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function method_in(array $compare)
    {
        $compare = array_map(
            'strtoupper', $compare
        );

        return in_array(
            $this->method(), $compare, true
        );
    }

    /**
     *  Get client ip or use middleware methods
     *
     *  Usage:
     *      string ip()
     *      bool   ip('is', $address)
     *      bool   ip('is', 'local') # local network client
     *      bool   ip('in', [$address_a, $address_b])
     *      bool   ip('in', [$address_a, 'local']) # local network client
     *
     *  @param  scalar $prop
     *  @param  scalar $compare
     *
     *  @return mixed
     */
    public function ip($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('ip_%s', $prop)
            }($compare);

        return $this->server(
            'REMOTE_ADDR', '127.0.0.1'
        );
    }

    /**
     *  Compare client ip, use ip('is', $ip | 'local') instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function ip_is($compare)
    {
        if ($compare !== 'local')
            return $this->ip() === $compare;

        return preg_match(
            '/(127\.0\.0\.1|192\.168\.[0-9]{1,3}\.[0-9]{1,3})/',
            $this->ip()
        );
    }

    /**
     *  Compare client ip, use ip('in', [$ip_a, $ip_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function ip_in(array $compare)
    {
        if (in_array('local', $compare, true))
            if ($this->ip('is', 'local') === true)
                return true;

        return in_array(
            $this->ip(), $compare, true
        );
    }

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent($prop = null, $compare = null)
    {
        if ($prop !== null)
            return $this->{
                sprintf('agent_%s', $prop)
            }($compare);

        return $this->header('USER_AGENT');
    }

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent_is($compare)
    {
        return $this->agent() === $compare;
    }

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent_in(array $compare)
    {
        return in_array(
            $this->agent(), $compare, true
        );
    }

    /**
     *  General comparison mehtod with modulation.
     *
     *  Usage: bool is('console'|'cli'|'ajax'|'xhr'|'json')
     *
     *  @param  scalar $prop
     *  @param  scalar $compare
     *
     *  @return mixed
     */
    public function is($prop, $compare = null)
    {
        return $this->{
            sprintf(
                'is_%s', $prop
            )
        }($compare);
    }

    /**
     *  Compare if request maked with 'cli' sapi.
     *
     *  Usage: bool is_console() || bool is('console')
     *
     *  @return boolean
     */
    public function is_console()
    {
        return php_sapi_name() === 'cli';
    }

    /**
     *  Alias of 'is_console' method.
     *
     *  Usage: bool is_cli() || bool is('cli')
     *
     *  @return boolean
     */
    public function is_cli()
    {
        return php_sapi_name() === 'cli';
    }

    /**
     *  Compare request header for 'json' type request.
     *
     *  Usage: bool is_json() || bool is('json')
     *
     *  @return boolean
     */
    public function is_json()
    {
        return (bool) preg_match(
            '/(\/json$|\/json\;)/i',
            $this->server('CONTENT_TYPE')
        );
    }

    /**
     *  Compare request header for 'ajax' type request.
     *
     *  Usage: bool is_xhr() || bool is('xhr')
     *
     *  @return boolean
     */
    public function is_xhr()
    {
        return 'xmlhttprequest' == strtolower(
            $this->header('X_REQUESTED_WITH', '')
        );
    }

    /**
     *  Alias for 'is_xhr' method
     *
     *  Usage: bool is_ajax() || bool is('ajax')
     *
     *  @return boolean
     */
    public function is_ajax()
    {
        return $this->is_xhr();
    }

    /**
     *  Get document root.
     *
     *  @return string
     */
    public function base($merge = null)
    {
        if ($merge !== null) {
            $merge = $merge[0] !== '/' ?
                sprintf('/%', $merge) : $merge;

            return $this->server(
                'DOCUMENT_ROOT'
            ) . $merge;
        }

        return $this->server(
            'DOCUMENT_ROOT'
        );
    }

    /**
     *  Exctract client best matches locale.
     *
     *  Usage: string locale() || string locale('en')
     *
     *  @var string $locale
     *
     *  @return string
     */
    public function locales()
    {
        if (
            preg_match_all(
                '/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/',
                strtolower(
                    $this->header('ACCEPT_LANGUAGE')
                ),
                $matches
            )
        ) {
            $language = array();

            foreach (array_combine($matches[1], $matches[2]) as $key => $value) {
                $language[$key] = empty($value) ? 1 : (float) $value;
            }

            arsort($language, SORT_NUMERIC);

            $language = array_keys($language);

            return $language;
        }

        return ['en'];
    }

    /**
     *  Exctract client best matches locale.
     *
     *  Usage: string locale() || string locale('en')
     *
     *  @var string $locale
     *
     *  @return string
     */
    public function locale()
    {
        /**
         *  @var string
         */
        $locales = $this->locales();

        /**
         *  @var string
         */
        $suggest = array_shift(
            $locales
        );

        /**
         *  @var string
         */
        return strtok($suggest, '-');
    }
}
