<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database;

use Frame\Database\Adapter\MySQL;
use Frame\Database\Adapter\PgSQL;
use Frame\Database\Adapter\SQLite;
use Frame\Data\Readable;

/**
 * @subpackage Database
 */
class Manager extends Readable
{
    protected function __construct()
    {
        //
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Adapter\MySQL
     */
    public function mysql($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Adapter\MySQL
         */
        $drive = new MySQL($config);

        /**
         *  @var \Frame\Database\Adapter\MySQL
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Adapter\MySQL
         */
        return $drive;
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Adapter\PgSQL
     */
    public function pgsql($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Adapter\PgSQL
         */
        $drive = new PgSQL($config);

        /**
         *  @var \Frame\Database\Adapter\PgSQL
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Adapter\PgSQL
         */
        return $drive;
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Adapter\SQLite
     */
    public function sqlite($name = 'default', array $config)
    {
        /**
         *  @var \Frame\Database\Adapter\SQLite
         */
        $drive = new SQLite($config);

        /**
         *  @var \Frame\Database\Adapter\SQLite
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Adapter\SQLite
         */
        return $drive;
    }

    /**
     *  @param string $name
     *  @param array $config
     *
     *  @return mixed
     *
     *  @throws \Exception
     */
    public function add($name = 'default', array $config)
    {
        if (array_key_exists('adapter', $config) === false)
            /**
             *  @var void
             */
            throw new \Exception('Database driver missed');

        /**
         *  @var string
         */
        $driver = $config['adapter'];

        /**
         *  @var \Frame\Database\Drive
         */
        return $this->{$driver}(
            $name, $config
        );
    }

    /**
     * @return null|static
     */
    public static function singleton()
    {
        /**
         *
         */
        static $instance = null;

        if ($instance === null)
            $instance = new static();

        return $instance;
    }
}
