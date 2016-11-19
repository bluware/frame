<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database;

use Frame\Database\Drive\MySQL;
use Frame\Database\Drive\PgSQL;
use Frame\Database\Drive\SQLite;
use Frame\Data\Readable;

/**
 * @subpackage Database
 */
class Union extends Readable
{
    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public function connection($name)
    {
        return $this->get($name, null);
    }

    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public function connect($name)
    {
        return $this->connection($name);
    }

    /**
     *  @param  string $name
     *
     *  @return mixed
     */
    public function driver($name)
    {
        return $this->connection($name);
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\MySQL
     */
    public function mysql($name, array $config)
    {
        /**
         *  @var \Frame\Database\Drive\MySQL
         */
        $drive = new MySQL($config);

        /**
         *  @var \Frame\Database\Drive\MySQL
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Drive\MySQL
         */
        return $drive;
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\PgSQL
     */
    public function pgsql($name, array $config)
    {
        /**
         *  @var \Frame\Database\Drive\PgSQL
         */
        $drive = new PgSQL($config);

        /**
         *  @var \Frame\Database\Drive\PgSQL
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Drive\PgSQL
         */
        return $drive;
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive\SQLite
     */
    public function sqlite($name, array $config)
    {
        /**
         *  @var \Frame\Database\Drive\SQLite
         */
        $drive = new SQLite($config);

        /**
         *  @var \Frame\Database\Drive\SQLite
         */
        $this->data[$name] = $drive;

        /**
         *  @var \Frame\Database\Drive\SQLite
         */
        return $drive;
    }

    /**
     *  @param  string $name
     *  @param  array  $config
     *
     *  @return \Frame\Database\Drive
     */
    public function add($name, array $config)
    {
        if (array_key_exists('driver', $config) === false)
            /**
             *  @var void
             */
            throw new \Exception('Database driver missed');

        /**
         *  @var string
         */
        $driver = $config['driver'];

        /**
         *  @var \Frame\Database\Drive
         */
        return $this->{$driver}(
            $name, $config
        );
    }

    /**
     *  @param  string $type
     *  @param  mixed  $names
     *  @param  array  $config
     *
     *  @return mixed
     */
    public function from($type, $names, array $config = null)
    {
        switch ($type) {
            case 'collection':
                foreach ($names as $name => $config)
                    /**
                     *  @var static
                     */
                    $this->add($name, $config);

                break;

            case 'array':
                /**
                 *  @var static
                 */
                $this->add($names, $config);

                break;
        }
    }
}
