<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Database\Union;

/**
 * @subpackage Database
 */
class Database
{
    /**
     *  @const MySQL
     */
    const MySQL     = 'mysql';

    /**
     *  @const PgSQL
     */
    const PgSQL     = 'pgsql';

    /**
     *  @const SQLite
     */
    const SQLite    = 'sqlite';

    /**
     *  @return \Frame\Database\Union
     */
    public static function union($method = null)
    {
        /**
         *  @var mixed
         */
        static $union = null;

        /**
         *  @var boolean
         */
        if ($union === null)
            /**
             *  @var \Frame\Database\Union
             */
            $union = new Union;

        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \Frame\Database\Union
             */
            return $union;

        /**
         *  @var arrau
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $union,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public static function connection($name = 'default')
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('connection', $name, $config);
    }

    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public static function connect($name = 'default')
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('connection', $name);
    }

    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public static function driver($name = 'default')
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('connection', $name);
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\MySQL
     */
    public static function mysql($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('mysql', $name, $config);
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\PgSQL
     */
    public static function pgsql($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('pgsql', $name, $config);
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\SQLite
     */
    public static function sqlite($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('sqlite', $name, $config);
    }

    /**
     *  @param  string $type
     *  @param  mixed  $names
     *  @param  array  $config
     *
     *  @return mixed
     */
    public static function add($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Drive
         */
        return static::union('add', $name, $config);
    }

    /**
     *  @return mixed
     */
    public static function from($type, $names, array $config = null)
    {
        /**
         *  @var mixed
         */
        return static::union('from', $type, $names, $config);
    }
}
