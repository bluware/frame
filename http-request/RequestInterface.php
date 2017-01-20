<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http;

/**
 * @subpackage Request
 */
interface RequestInterface
{
    /**
     * @return void
     */
    public function __construct(
        array $query    = null,
        array $body     = null,
        array $files    = null,
        array $cookies  = null,
        array $server   = null
    );

    /**
     *  @param scalar $key
     *
     *  @return boolean
     */
    public function has($instance, $key = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Query query()
     *      mixed query($input)
     *      array query([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function query($input = null, $alt = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Body body()
     *      mixed body($input)
     *      array body([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function body($input = null, $alt = null);

    /**
     *  Compare and get '$_POST' params.
     *
     *  Usage:
     *      mixed post()
     *      mixed post($input)
     *      array post([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function post($input = null, $alt = null);

    /**
     *  Compare and get '$_PUT' params.
     *
     *  Usage:
     *      mixed put()
     *      mixed put($input)
     *      array put([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function put($input = null, $alt = null);

    /**
     *  Compare and get '$_DELETE' params.
     *
     *  Usage:
     *      mixed delete()
     *      mixed delete($input)
     *      array delete([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function delete($input = null, $alt = null);

    /**
     *  Alias for delete() method.
     *
     *  Usage:
     *      mixed del()
     *      mixed del($input)
     *      array del([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function del($input = null, $alt = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Files files()
     *      mixed files($input)
     *      array files([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function files($input = null, $alt = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Cookie cookie()
     *      mixed cookie($input)
     *      array cookie([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function cookie($input = null, $alt = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Server server()
     *      mixed server($input)
     *      array server([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function server($input = null, $alt = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Frame\Request\Server server()
     *      mixed server($input)
     *      array server([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alt
     *
     *  @return mixed
     */
    public function header($input, $alt = null);

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
    public function schema($prop = null, $compare = null);

    /**
     *  Compare request method, use schema('is', $schema) instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function schema_is($compare);

    /**
     *  Compare request method, use schema('in', [$schema_a, $schema_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function schema_in(array $compare);

    /**
     *  Get requested schema
     *
     *  @return bool
     */
    public function secure();

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host($prop = null, $compare = null);

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host_is($compare);

    /**
     *  Get server hostname.
     *
     *  @return string
     */
    public function host_in(array $compare);

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port($prop = null, $compare = null);

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port_is($compare);

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port_in(array $compare);

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri($prop = null, $compare = null);

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri_is($compare);

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri_in(array $compare);

    /**
     *  Get path.
     *
     *  @return string
     */
    public function path($prop = null, $compare = null);

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function path_is($compare);

    /**
     *  Get server path.
     *
     *  @return string
     */
    public function path_in(array $compare);

    /**
     *  Get url address with possible replacement path.
     *
     *  @return string
     */
    public function url($path = null);

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
    public function method($prop = null, $compare = null);

    /**
     *  Compare request method, use method('is', $method) instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function method_is($compare);

    /**
     *  Compare request method, use method('in', [$method_a, $method_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function method_in(array $compare);

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
    public function ip($prop = null, $compare = null);

    /**
     *  Compare client ip, use ip('is', $ip | 'local') instead.
     *
     *  @param  string $compare
     *
     *  @return boolean
     */
    public function ip_is($compare);

    /**
     *  Compare client ip, use ip('in', [$ip_a, $ip_b]) instead.
     *
     *  @param  array $compare
     *
     *  @return boolean
     */
    public function ip_in(array $compare);

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent($prop = null, $compare = null);

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent_is($compare);

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent_in(array $compare);

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
    public function is($prop, $compare = null);

    /**
     *  Compare if request maked with 'cli' sapi.
     *
     *  Usage: bool is_console() || bool is('console')
     *
     *  @return boolean
     */
    public function is_console();

    /**
     *  Alias of 'is_console' method.
     *
     *  Usage: bool is_cli() || bool is('cli')
     *
     *  @return boolean
     */
    public function is_cli();

    /**
     *  Compare request header for 'json' type request.
     *
     *  Usage: bool is_json() || bool is('json')
     *
     *  @return boolean
     */
    public function is_json();

    /**
     *  Compare request header for 'ajax' type request.
     *
     *  Usage: bool is_xhr() || bool is('xhr')
     *
     *  @return boolean
     */
    public function is_xhr();

    /**
     *  Alias for 'is_xhr' method
     *
     *  Usage: bool is_ajax() || bool is('ajax')
     *
     *  @return boolean
     */
    public function is_ajax();

    /**
     *  Get document root.
     *
     *  @return string
     */
    public function base($merge = null);

    /**
     *  Exctract client best matches locale.
     *
     *  Usage: string locale() || string locale('en')
     *
     *  @var string $locale
     *
     *  @return string
     */
    public function locales();

    /**
     *  Exctract client best matches locale.
     *
     *  Usage: string locale() || string locale('en')
     *
     *  @var string $locale
     *
     *  @return string
     */
    public function locale();
}
