<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\ActiveRecord;

use Frame\Database;
use Frame\Data\Writable;

/**
 * @subpackage Active
 */
abstract class Query extends Writable
{
    /**
     *  @var string
     */
    protected $driver       = 'default';

    /**
     *  @var string
     */
    protected $table;

    /**
     *  @var string|array
     */
    protected $primary      = 'id';

    /**
     *  @var string
     */
    protected $increment    = true;

    /**
     *  @var array
     */
    protected $columns      = [];

    /**
     *  @var array
     */
    protected $origin       = [];

    /**
     *  @var boolean
     */
    protected $isset        = false;

    /**
     *  @param  array  $data
     *  @return mixed
     */
    public function insert(array $data)
    {
        /**
         *  @var boolean
         */
        if ($this->isset === true)
            return $this;

        /**
         *  @var void
         */
        $this->query(function($q) use ($data) {
            /**
             *  @var boolean
             */
            if ($this->increment === true)
                /**
                 *  @var void
                 */
                $this->primary('filter', $data);

            $q->insert(
                $this->table
            )->values(
                $data
            );
        });

        /**
         *  @var boolean
         */
        if ($this->increment === true)
            /**
             *  @var integer
             */
            $data[$this->primary] = $this->driver('id');

        /**
         *  @var boolean
         */
        $this->isset = true;

        /**
         *  @var void
         */
        $this->data($data);

        /**
         *  @var array
         */
        $this->origin = $data;

        /**
         *  @var static
         */
        return $this;
    }

    /**
     *  @param  array  $data
     *  @return mixed
     */
    public function select($state, callable $call = null)
    {
        /**
         *  @var void
         */
        $data = $this->query(function(
            $q
        ) use (
            $state,
            $call
        ) {
            $q->select(
                $this->columns
            )->from(
                $this->table
            );

            /**
             *  @var boolean
             */
            if ($call !== null)
                /**
                 *  @var boolean
                 */
                call_user_func(
                    $call,
                    $q,
                    $this
                );

            /**
             *  @var boolean
             */
            if ($state === 'one')
                /**
                 *  @var void
                 */
                $q->limit(1);
        })->{$state}();

        /**
         *  @var boolean
         */
        if (sizeof($data) === 0)
            return null;

        /**
         * @var boolean
         */
        $this->isset = true;

        /**
         *  @var boolean
         */
        if ($state === 'one') {
            /**
             *  @var array
             */
            $this->data     = $data;

            /**
             *  @var array
             */
            $this->origin   = $data;

            /**
             *  @var static
             */
            return $this;
        }

        foreach ($data as $key => $item) {
            /**
             *  @var array
             */
            $this->data     = $item;

            /**
             *  @var array
             */
            $this->origin   = $item;

            /**
             *  @var static
             */
            $data[$key] = clone $this;
        }

        /**
         *  @var array
         */
        $this->data     = $this->origin = [];

        /**
         *  @var boolean
         */
        $this->isset    = false;

        /**
         *  @var array
         */
        return $data;
    }

    public function update(array $data = null)
    {
        /**
         *  @var boolean
         */
        if ($this->isset === false)
            return $this;

        /**
         *  @var void
         */
        $this->data($data);

        /**
         *  @var void
         */
        $data = $this->diff(
            $this->origin
        );

        /**
         *  @var static
         */
        if (sizeof($data) === 0)
            return $this;

        /**
         *  @var void
         */
        $this->query(function($q) use ($data) {
            $q->update(
                $this->table
            )->set(
                $this->primary(
                    'filter', $data
                )
            )->where(
                $this->primary(
                    'pull', $this->origin
                )
            );
        });

        /**
         *  @var array
         */
        $this->data($data);

        /**
         *  @var array
         */
        $this->origin = $this->data();

        /**
         *  @var static
         */
        return $this;
    }

    public function delete()
    {
        /**
         *  @var boolean
         */
        if ($this->isset === false)
            return null;

        /**
         *  @var void
         */
        $this->query(function($q) {
            $q->delete(
                //
            )->from(
                $this->table
            )->where(
                $this->primary(
                    'pull', $this->origin
                )
            );
        });

        /**
         *  @var array
         */
        $this->data = $this->origin = [];

        /**
         *  @var boolean
         */
        $this->isset = false;

        /**
         *  @var null
         */
        return null;
    }

    public function primary($method, array &$data)
    {
        /**
         *  @var mixed
         */
        $primaries = $this->primary;

        /**
         *  @var boolean
         */
        if (gettype($primaries) !== 'array')
            /**
             *  @var array
             */
            $primaries = [$primaries];

        /**
         *  @var mixed
         */
        switch ($method) {
            case 'pull':
                /**
                 *  @var array
                 */
                $values     = [];

                /**
                 *  @var mixed
                 */
                foreach ($primaries as $key) {
                    /**
                     *  @var boolean
                     */
                    if (array_key_exists($key, $data) === false)
                        throw new \Exception("Primary key missed");

                    /**
                     *  @var mixed
                     */
                    $values[$key] = $data[$key];
                }

                /**
                 *  @var array
                 */
                return $values;

                break;

            case 'filter':
                /**
                 *  @var mixed
                 */
                foreach ($primaries as $key)
                    /**
                     *  @var boolean
                     */
                    if (array_key_exists($key, $data) === true)
                        /**
                         *  @var void
                         */
                        unset($data[$key]);

                /**
                 *  @var array
                 */
                return $data;

                break;
        }
    }

    /**
     *  @param  mixed $state
     *  @param  mixed $query
     *
     *  @return mixed
     */
    public function query($pull, $query = null)
    {
        if ($query === null)
            /**
             *  @var \Frame\Database\State
             */
            return $this->driver(
                'query', $pull
            );

        /**
         *  @var mixed
         */
        return $this->driver(
            'query', $query
        )->{$pull}();
    }

    /**
     *  @param  mixed $state
     *  @param  mixed $query
     *
     *  @return mixed
     */
    public function transaction($call, &$error = null)
    {
        /**
         *  @var mixed
         */
        return $this->driver(
            'transaction', $query, $error
        );
    }

    /**
     *  @return mixed
     */
    public function driver($method = null)
    {
        /**
         *  @var \Frame\Database\Drive
         */
        $driver = Database::driver(
            $this->driver
        );

        /**
         * @var boolean
         */
        if ($driver === null)
            /**
             * @var \Exception
             */
            throw new \Exception(
                "Driver does not exist " . $this->driver
            );

        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \Frame\Database\Drive
             */
            return $driver;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $driver,
            array_shift($params)
        ], $params);
    }

    /**
     *  @return void
     */
    public function __destruct()
    {
        //
    }
}
