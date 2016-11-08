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
     * @return void
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
            array_replace(
                [
                    'SERVER_NAME'           => 'localhost',
                    'SERVER_PORT'           => '80',
                    'HTTP_HOST'             => 'localhost',
                    'HTTP_USER_AGENT'       => 'Blu/1.x',
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
         *  Prepare input stream buffer
         *
         *  If request type 'json', than inject body
         */
        if ($body === null && $this->is('json')) {
            $buff = file_get_contents('php://input');
            $json = json_decode($buff, true);

            if (json_last_error() === 0)
                $body = $json;
        }

        /**
         *  @param \Blu\Http\Request\Body
         */
        $this->body = new \Blu\Http\Request\Body(
            $body !== null ? $body : $_POST
        );

        /**
         *  @param \Blu\Essence\Readable
         */
        parent::__construct(
            $this->{
                $this->method('is', 'get') ?
                    'query' : 'body'
            }->data()
        );
    }

    /**
     *  Isolate data container to new instance.
     *
     *  @return \Blu\Essence\ReadableAbstract
     */
    public function isolate()
    {
        return new Blu\Essence\ReadableAbstract(
            $this->data()
        );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Http\Request\Query query()
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
            return $this->query;

        if (is_array($input))
            return $this->query
                ->only(
                    $input,
                    $alternate
                );

        return $this->query
            ->get(
                $input,
                $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Http\Request\Body body()
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
            return $this->body;

        if (is_array($input))
            return $this->body
                ->only(
                    $input,
                    $alternate
                );

        return $this->body
            ->get(
                $input,
                $alternate
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
        return $this->method('is', 'POST') ?
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
        return $this->method('is', 'PUT') ?
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
        return $this->method('is', 'DELETE') ?
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
        return $this->delete(
            $input, $alternate
        );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Http\Request\Files files()
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
            return $this->files;

        if (is_array($input))
            return $this->files
                ->only(
                    $input,
                    $alternate
                );

        return $this->files
            ->get(
                $input,
                $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Http\Request\Cookie cookie()
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
            return $this->cookie;

        if (is_array($input))
            return $this->cookie
                ->only(
                    $input,
                    $alternate
                );

        return $this->cookie
            ->get(
                $input,
                $alternate
            );
    }

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Http\Request\Server server()
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
            return $this->server;

        if (is_array($input))
            return $this->server
                ->only(
                    $input,
                    $alternate
                );

        return $this->server
            ->get(
                $input,
                $alternate
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
     *  @param  scalar $comparison
     *
     *  @return mixed
     */
    public function schema($prop = null, $comparison = null)
    {
        if ($prop !== null) {
            return call_user_func([
                $this, sprintf(
                    'schema_%s', $prop
                )
            ], $comparison);
        }

        return $this->server('HTTPS', 'off') !== 'off' ?
            'https' : 'http';
    }

    /**
     *  Compare request method, use schema('is', $schema) instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function schema_is($comparison)
    {
        return strtolower(
            $comparison
        ) === $this->schema();
    }

    /**
     *  Compare request method, use schema('in', [$schema_a, $schema_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function schema_in(array $comparison)
    {
        $comparison = array_map(
            'strtolower', $comparison
        );

        return in_array(
            $this->schema(),
            $comparison,
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
    public function host()
    {
        return $this->server(
            'HTTP_HOST', '127.0.0.1'
        );
    }

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port()
    {
        return $this->server(
            'SERVER_PORT', '80'
        );
    }

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri()
    {
        return $this->server(
            'REQUEST_URI', '/'
        );
    }

    /**
     *  Get path.
     *
     *  @return string
     */
    public function path()
    {
        return strtok(
            $this->uri(), '?'
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
            "%s://%s:%s%s",
            $this->schema(),
            $this->host(),
            $this->port(),
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
     *  @param  scalar $comparison
     *
     *  @return mixed
     */
    public function method($prop = null, $comparison = null)
    {
        if ($prop !== null) {
            return call_user_func([
                $this, sprintf(
                    'method_%s', $prop
                )
            ], $comparison);
        }

        return $this->server(
            'REQUEST_METHOD', 'GET'
        );
    }

    /**
     *  Compare request method, use method('is', $method) instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function method_is($comparison)
    {
        return $this->server(
            'REQUEST_METHOD', 'GET'
        ) === strtoupper($comparison);
    }

    /**
     *  Compare request method, use method('in', [$method_a, $method_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function method_in(array $comparison)
    {
        $comparison = array_map(
            'strtoupper', $comparison
        );

        return in_array(
            $this->server(
                'REQUEST_METHOD', 'GET'
            ), $comparison, true
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
     *  @param  scalar $comparison
     *
     *  @return mixed
     */
    public function ip($prop = null, $comparison = null)
    {

        if ($prop !== null) {
            return call_user_func([
                $this, sprintf(
                    'ip_%s', $prop
                )
            ], $comparison);
        }

        return $this->server(
            'REMOTE_ADDR', '127.0.0.1'
        );
    }

    /**
     *  Compare client ip, use ip('is', $ip | 'local') instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function ip_is($comparison)
    {
        if ($comparison !== 'local')
            return $this->server(
                'REMOTE_ADDR', '127.0.0.1'
            ) === $comparison;

        return preg_match(
            '/(127\.0\.0\.1|192\.168\.[0-9]{1,3}\.[0-9]{1,3})/',
            $this->server('REMOTE_ADDR', '127.0.0.1')
        );
    }

    /**
     *  Compare client ip, use ip('in', [$ip_a, $ip_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function ip_in(array $comparison)
    {
        if (in_array('local', $comparison, true))
            if ($this->ip('is', 'local') === true)
                return true;

        return in_array(
            $this->server(
                'REMOTE_ADDR', '127.0.0.1'
            ), $comparison, true
        );
    }

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent()
    {
        return $this->server('HTTP_USER_AGENT');
    }

    /**
     *  General comparison mehtod with modulation.
     *
     *  Usage: bool is('console'|'cli'|'ajax'|'xhr'|'json')
     *
     *  @param  scalar $prop
     *  @param  scalar $comparison
     *
     *  @return mixed
     */
    public function is($prop, $comparison = null)
    {
        return call_user_func([
            $this, sprintf('is_%s', $prop)
        ], $comparison);
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
            '/\/json$/i',
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
            $this->server('HTTP_X_REQUESTED_WITH', '')
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
        return 'xmlhttprequest' == strtolower(
            $this->server('HTTP_X_REQUESTED_WITH')
        );
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
     *  Alias for 'base'.
     *
     *  @return string
     */
    public function root($merge = null)
    {
        return $this->base($merge);
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
    public function locale($locale = 'en')
    {
        if (
            preg_match_all(
                '/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/',
                strtolower(
                    $this->server('HTTP_ACCEPT_LANGUAGE')
                ),
                $matches
            )
        ) {
            $language = array();

            foreach (array_combine($matches[1], $matches[2]) as $key => $value) {
                $language[$key] = empty($value) ? 1 : (float) $value;
            }

            arsort($language, SORT_NUMERIC);

            $language   = array_keys($language);
            $primary    = array_shift(
                $language
            );

            $locale = strtok($primary, '-');
        }

        return $locale;
    }
}
