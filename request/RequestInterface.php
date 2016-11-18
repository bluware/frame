<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

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
        array $cookies   = null,
        array $server   = null
    );
    /**
     *  Isolate data container to new instance.
     *
     *  @return \Blu\Essence\ReadableAbstract
     */
    public function isolate();

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Request\Query query()
     *      mixed query($input)
     *      array query([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function query($input = null, $alternate = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Request\Body body()
     *      mixed body($input)
     *      array body([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function body($input = null, $alternate = null);

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
    public function post($input = null, $alternate = null);

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
    public function put($input = null, $alternate = null);

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
    public function delete($input = null, $alternate = null);

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
    public function del($input = null, $alternate = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Request\Files files()
     *      mixed files($input)
     *      array files([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function files($input = null, $alternate = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Request\Cookie cookie()
     *      mixed cookie($input)
     *      array cookie([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function cookie($input = null, $alternate = null);

    /**
     *  Mixed method with read instance or properties.
     *
     *  Usage:
     *      \Blu\Request\Server server()
     *      mixed server($input)
     *      array server([$input])
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function server($input = null, $alternate = null);

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
    public function schema($prop = null, $comparison = null);

    /**
     *  Compare request method, use schema('is', $schema) instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function schema_is($comparison);

    /**
     *  Compare request method, use schema('in', [$schema_a, $schema_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function schema_in(array $comparison);

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
    public function host();

    /**
     *  Get server port.
     *
     *  @return string
     */
    public function port();

    /**
     *  Get server uri.
     *
     *  @return string
     */
    public function uri();

    /**
     *  Get path.
     *
     *  @return string
     */
    public function path();

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
     *  @param  scalar $comparison
     *
     *  @return mixed
     */
    public function method($prop = null, $comparison = null);

    /**
     *  Compare request method, use method('is', $method) instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function method_is($comparison);

    /**
     *  Compare request method, use method('in', [$method_a, $method_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function method_in(array $comparison);

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
    public function ip($prop = null, $comparison = null);

    /**
     *  Compare client ip, use ip('is', $ip | 'local') instead.
     *
     *  @param  string $comparison
     *
     *  @return boolean
     */
    public function ip_is($comparison);

    /**
     *  Compare client ip, use ip('in', [$ip_a, $ip_b]) instead.
     *
     *  @param  array $comparison
     *
     *  @return boolean
     */
    public function ip_in(array $comparison);

    /**
     *  Get client agent
     *
     *  @return string
     */
    public function agent();

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
    public function is($prop, $comparison = null);

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
     *  Alias for 'base'.
     *
     *  @return string
     */
    public function root($merge = null);

    /**
     *  Exctract client best matches locale.
     *
     *  Usage: string locale() || string locale('en')
     *
     *  @var string $locale
     *
     *  @return string
     */
    public function locale($locale = 'en');
}
