<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database\Query;

use Frame\Database\Query;

/**
 * @subpackage Database
 */
class Where
{
    /**
     *  @var array
     */
    protected $data = [];

    /**
     *  @param string $column
     *  @param string $operator
     *  @param mixed  $value
     *  @param string $paste
     *
     *  @return void
     */
    public function set($column, $operator = '=', $value, $paste = 'and')
    {
        /**
         *  @var string
         */
        $operator = strtoupper($operator);

        switch ($operator) {
            case 'IN': case 'NOT IN':
                /**
                 *  @var array
                 */
                $values = gettype($value) === 'array' ?
                    $value : [$value];

                /**
                 *  @var string
                 */
                $value = sprintf(
                    '(%s)', join(', ', $values)
                );
                break;

            case 'BETWEEN': case 'NOT BETWEEN':
                /**
                 *  @var string
                 */
                if (gettype($value) !== 'array')
                    return $this;

                /**
                 *  @var array
                 */
                 $value = join(' AND ', $value);
                break;
        }

        /**
         *  @var static
         */
        return $this->push(
            sprintf(
                '%s %s %s',
                $column,
                $operator,
                $value
            ), $paste
        );
    }

    /**
     *  @return void
     */
    public function and()
    {
        /**
         *  @var void
         */
        return $this->paste('and');
    }

    /**
     *  @return void
     */
    public function or()
    {
        /**
         *  @var void
         */
        return $this->paste('or');
    }

    /**
     *  @param  string $query
     *  @param  string $paste
     *
     *  @return static
     */
    public function push($partial, $paste = 'and')
    {
        /**
         *  @var void
         */
        $this->paste($paste);

        /**
         * @var void
         */
        array_push($this->data, $partial);

        /**
         *  @var static
         */
        return $this;
    }

    /**
     *  @param  Query    $q
     *  @param  callable $callback
     *
     *  @return void
     */
    public function separate(Query $q, callable $call)
    {
        /**
         *  @var void
         */
        array_push($this->data, "(");

        /**
         *  @var void
         */
        call_user_func($call, $q);

        /**
         *  @var void
         */
        array_push($this->data, ")");

        /**
         *  @var static
         */
        return $q;
    }

    /**
     *  @param  string $type
     *
     *  @return void
     */
    public function paste($type)
    {
        if (sizeof($this->data) === 0)
            return $this;

        /**
         *  @var boolean
         */
        $cant = in_array(
            end($this->data), [
                '(', 'OR', 'AND'
            ], true
        );

        if ($cant === true)
            /**
             *  @var static
             */
            return $this;

        /**
         *  @var void
         */
        array_push(
            $this->data, strtoupper($type)
        );

        /**
         *  @var static
         */
        return $this;
    }

    /**
     *  @param  string $type
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'string': case 'str':
                /**
                 *  @var string
                 */
                return join(' ', $this->data);
                break;
        }
    }
}
