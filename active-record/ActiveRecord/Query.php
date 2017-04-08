<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\ActiveRecord;

use Frame\Data\Writable;
use Frame\Database\Adapter;
use Frame\Database\Manager;
use Frame\Database\Query as Q;

abstract class Query extends Writable
{
    /**
     *  @const ONE
     */
    const ONE = 'one';

    /**
     *  @const ALL
     */
    const ALL = 'all';

    /**
     *  @var string
     */
    protected static $adapter = 'default';

    /**
     *  @var string
     */
    protected $table;

    /**
     *  @var string|array
     */
    protected $primary = 'id';

    /**
     *  @var string
     */
    protected $increment = true;

    /**
     *  @var array
     */
    protected $columns = [];

    /**
     *  @var array
     */
    protected $origin = [];

    /**
     *  @var bool
     */
    protected $isset = false;

    /**
     *  @param array|null $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }
    }

    /**
     *  @param  array  $data
     *
     *  @return mixed
     */
    public function insert(array $data)
    {
        /*
         *  @var boolean
         */
        if ($this->isset === true) {
            return $this;
        }

        /**
         *  @var void
         */
        static::query(function (Q $q) use ($data) {
            /*
             *  @var boolean
             */
            if ($this->increment === true) {
                /*
                 *  @var void
                 */
                $this->primary('filter', $data);
            }

            $q->insert(
                $this->table
            )->values(
                $data
            );
        });

        /*
         *  @var boolean
         */
        if ($this->increment === true) {
            /*
             *  @var integer
             */
            $data[$this->primary] = static::adapter('id');
        }

        /*
         *  @var boolean
         */
        $this->isset = true;

        /*
         *  @var void
         */
        $this->data($data);

        /*
         *  @var array
         */
        $this->origin = $data;

        /*
         *  @var static
         */
        return $this;
    }

    /**
     *  @param  array  $data
     *
     *  @return mixed
     */
    public function select($fetch, callable $call = null)
    {
        /**
         *  @var void
         */
        $data = static::query($fetch, function (Q $q) use ($fetch, $call) {
            $q->select(
                $this->columns
            )->from(
                $this->table
            );

            /*
             *  @var boolean
             */
            if ($call !== null) {
                /*
                 *  @var boolean
                 */
                call_user_func(
                    $call,
                    $q,
                    $this
                );
            }

            /*
             *  @var boolean
             */
            if ($fetch === static::ONE) {
                /*
                 *  @var void
                 */
                $q->limit(1, 0);
            }
        });

        /*
         *  @var boolean
         */
        if (count($data) === 0) {
            return;
        }

        /*
         * @var boolean
         */
        $this->isset = true;

        /*
         *  @var boolean
         */
        if ($fetch === static::ONE) {
            /*
             *  @var array
             */
            $this->data = $data;

            /*
             *  @var array
             */
            $this->origin = $data;

            /*
             *  @var static
             */
            return $this;
        }

        foreach ($data as $key => $item) {
            /*
             *  @var array
             */
            $this->data = $item;

            /*
             *  @var array
             */
            $this->origin = $item;

            /*
             *  @var static
             */
            $data[$key] = clone $this;
        }

        /*
         *  @var array
         */
        $this->data = $this->origin = [];

        /*
         *  @var boolean
         */
        $this->isset = false;

        /*
         *  @var array
         */
        return $data;
    }

    public function update(array $data = null)
    {
        /*
         *  @var boolean
         */
        if ($this->isset === false) {
            return $this;
        }

        /*
         *  @var void
         */
        $this->data($data);

        /**
         *  @var void
         */
        $data = array_diff_assoc(
            $this->data, $this->origin
        );

        /*
         *  @var static
         */
        if (count($data) === 0) {
            return $this;
        }

        /**
         *  @var void
         */
        static::query(function (Q $q) use ($data) {
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

        /*
         *  @var array
         */
        $this->data($data);

        /*
         *  @var array
         */
        $this->origin = $this->data();

        /*
         *  @var static
         */
        return $this;
    }

    public function delete()
    {
        /*
         *  @var boolean
         */
        if ($this->isset === false) {
            return;
        }

        /**
         *  @var void
         */
        static::query(function (Q $q) {
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

        /*
         *  @var array
         */
        $this->data = $this->origin = [];

        /*
         *  @var boolean
         */
        $this->isset = false;

        /*
         *  @var null
         */
    }

    public function primary($method, array &$data)
    {
        /**
         *  @var mixed
         */
        $primaries = $this->primary;

        /*
         *  @var boolean
         */
        if (gettype($primaries) !== 'array') {
            /**
             *  @var array
             */
            $primaries = [$primaries];
        }

        /*
         *  @var mixed
         */
        switch ($method) {
            case 'pull':
                /**
                 *  @var array
                 */
                $values = [];

                /*
                 *  @var mixed
                 */
                foreach ($primaries as $key) {
                    /*
                     *  @var boolean
                     */
                    if (array_key_exists($key, $data) === false) {
                        throw new \Exception('Primary key missed');
                    }
                    /*
                     *  @var mixed
                     */
                    $values[$key] = $data[$key];
                }

                /*
                 *  @var array
                 */
                return $values;

                break;

            case 'filter':
                /*
                 *  @var mixed
                 */
                foreach ($primaries as $key) {
                    /*
                     *  @var boolean
                     */
                    if (array_key_exists($key, $data) === true) {
                        /*
                         *  @var void
                         */
                        unset($data[$key]);
                    }
                }

                /*
                 *  @var array
                 */
                return $data;

                break;
        }
    }

    /**
     * @param $fetch
     * @param null $query
     *
     * @return mixed
     */
    protected static function query($fetch, $query = null)
    {
        /**
         *  @var \Frame\Database\Adapter
         */
        $adapter = static::adapter();

        if ($query === null) {
            /*
             *  @var \Frame\Database\Statement
             */
            return $adapter->query($fetch);
        }

        /**
         *  @var \Frame\Database\Statement
         */
        $state = $adapter->query($query);

        /*
         *  @var boolean
         */
        if (strpos($fetch, ':') !== false) {
            /*
             *  @var mixed
             */
            return call_user_func(
                [
                    $state, strtok($fetch, ':'),
                ], strtok(':'), strtok(':')
            );
        }

        /*
         *  @var mixed
         */
        return call_user_func([$state, $fetch]);
    }

    /**
     *  @param callable $calle
     *  @param null $error
     *
     *  @return mixed
     */
    protected static function transaction(callable $calle, &$error = null)
    {
        /*
         *  @var mixed
         */
        return static::adapter()->transaction(
            $calle, $error
        );
    }

    /**
     *  @param null $method
     *
     *  @throws \Exception
     *
     *  @return mixed|null
     */
    protected static function adapter($method = null)
    {
        /**
         *  @var \Frame\Database\Adapter
         */
        $adapter = Manager::singleton()->get(static::$adapter);

        /*
         * @var boolean
         */
        if ($adapter === null) {
            /*
             * @var \Exception
             */
            throw new \Exception(
                'Driver does not exist '.static::$adapter
            );
        }

        /*
         *  @var boolean
         */
        if ($method === null) {
            /*
             *  @var \Frame\Database\Adapter
             */
            return $adapter;
        }

        /**
         *  @var array
         */
        $params = func_get_args();

        /*
         *  @var mixed
         */
        return call_user_func_array([
            $adapter,
            array_shift($params),
        ], $params);
    }
}
