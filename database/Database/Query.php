<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Database;

use Frame\Database\Query\Where;

class Query
{
    /**
     *  @const SELECT
     */
    const SELECT = 0x1;

    /**
     *  @const INSERT
     */
    const INSERT = 0x2;

    /**
     *  @const UPDATE
     */
    const UPDATE = 0x3;

    /**
     *  @const DELETE
     */
    const DELETE = 0x4;

    /**
     *  @var string
     */
    protected $state = 0x1;

    /**
     *  @var string
     */
    protected $table;

    /**
     *  @var array
     */
    protected $values = [];

    /**
     *  @var array
     */
    protected $columns = [];

    /**
     *  @var array
     */
    protected $join = [];

    /**
     *  @var \Frame\Database\Query\Where
     */
    protected $where;

    /**
     *  @var array
     */
    protected $group = [];

    /**
     *  @var \Frame\Database\Query\Where
     */
    protected $having;

    /**
     *  @var array
     */
    protected $order = [];

    /**
     *  @var string
     */
    protected $limit;

    /**
     *  @var string
     */
    protected $offset;

    /**
     *  @var array
     */
    protected $bind = [];

    /**
     *  @param null $column
     *
     *  @return $this|string
     */
    public function select($column = null)
    {
        /*
         *  @var string
         */
        $this->state = static::SELECT;

        /*
         *  @var array
         */
        $this->columns = [];

        /*
         *  @var boolean
         */
        if (
               $column === null
            || empty($column)
        ) {
            /*
             *  @var array
             */
            $this->columns = ['*'];

            /*
             *  @var static
             */
            return $this;
        }

        /**
         *  @var array
         */
        $columns = is_array($column) === true ?
            $column : func_get_args();

        /*
         *  @var void
         */
        return $this->column($columns);
    }

    /**
     * @param $table
     * @param null $alias
     *
     * @return Query
     */
    public function insert($table, $alias = null)
    {
        /*
         *  @var string
         */
        $this->state = static::INSERT;

        /*
         *  @var void
         */
        return $this->table(
            $table, $alias
        );
    }

    /**
     * @param $table
     * @param null $alias
     *
     * @return Query
     */
    public function update($table, $alias = null)
    {
        /*
         *  @var string
         */
        $this->state = static::UPDATE;

        /*
         *  @var void
         */
        return $this->table(
            $table, $alias
        );
    }

    /**
     * @return $this
     */
    public function delete()
    {
        /*
         *  @var string
         */
        $this->state = static::DELETE;

        /*
         *  @var void
         */
        return $this;
    }

    /**
     * @param $column
     *
     * @return $this
     */
    public function column($column)
    {
        /**
         *  @var array
         */
        $columns = is_array($column) === true ?
            $column : func_get_args();

        foreach ($columns as $column => $alias) {
            /*
             *  @var void
             */
            array_push(
                /*
                 *  @var string
                 */
                $this->columns, is_numeric(
                    $column
                ) ? $this->separate(
                    $alias
                ) : $this->as(
                    $column, $alias
                )
            );
        }

        /*
         *  @var void
         */
        return $this;
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function columns($column)
    {
        /**
         *  @var array
         */
        $columns = is_array($column) === true ?
            $column : func_get_args();

        /*
         *  @var void
         */
        return $this->column($columns);
    }

    /**
     *  @param $column
     *  @param null $value
     *
     *  @return $this
     */
    public function values($column, $value = null)
    {
        /**
         *  @var array
         */
        $values = is_array($column) ?
             $column : [$column => $value];

        foreach ($values as $column => $value) {
            /*
             *  @var void
             */
            $this->values[
                $this->separate($column)
            ] = $this->bind($value);
        }

        /*
         *  @var static
         */
        return $this;
    }

    /**
     *  @param $column
     *  @param null $value
     *
     *  @return Query
     */
    public function set($column, $value = null)
    {
        /*
         *  @var static
         */
        return $this->values(
            $column, $value
        );
    }

    /**
     *  @param $table
     *  @param null $alias
     *
     *  @return $this
     */
    public function table($table, $alias = null)
    {
        /*
         *  @var string
         */
        $this->table = $alias === null ?
            $this->separate($table) : $this->as(
                $table, $alias
            );

        return $this;
    }

    /**
     *  @param $table
     *  @param null $alias
     *
     *  @return Query
     */
    public function from($table, $alias = null)
    {
        return $this->table($table, $alias);
    }

    /**
     *  @param $table
     *  @param $alias
     *  @param array $expression
     *  @param string $paste
     *
     *  @return $this
     */
    public function join($table, $alias, array $expression, $paste = 'inner')
    {
        /**
         *  @var string
         */
        $table = $alias === null ?
            $this->separate($table) : $this->as(
                $table, $alias
            );

        foreach ($expression as $column => &$value) {
            /**
             *  @var string
             */
            $value = sprintf(
                '%s = %s',
                $this->separate($column),
                $this->separate($value)
            );
        }

        /*
         *  @var void
         */
        array_push(
            $this->join, sprintf(
                '%s JOIN %s ON %s',
                strtoupper($paste),
                $table,
                implode(' AND ', $expression)
            )
        );

        return $this;
    }

    /**
     *  @param $clause
     *  @param $table
     *  @param $alias
     *  @param array $expression
     *
     *  @return mixed
     */
    public function inner($clause, $table, $alias, array $expression)
    {
        /*
         *  @var static
         */
        return $this->{$clause}($table, $alias, $expression, 'inner');
    }

    /**
     *  @param $clause
     *  @param $table
     *  @param $alias
     *  @param array $expression
     *
     *  @return mixed
     */
    public function left($clause, $table, $alias, array $expression)
    {
        /*
         *  @var static
         */
        return $this->{$clause}($table, $alias, $expression, 'left');
    }

    /**
     *  @param $clause
     *  @param $table
     *  @param $alias
     *  @param array $expression
     *
     *  @return mixed
     */
    public function right($clause, $table, $alias, array $expression)
    {
        /*
         *  @var static
         */
        return $this->{$clause}($table, $alias, $expression, 'right');
    }

    /**
     *  @param $column
     *  @param null $value
     *  @param string $operator
     *  @param string $paste
     *
     *  @return $this
     */
    public function where(
        $column,
        $value = null,
        $operator = '=',
        $paste = 'and'
    ) {
        /*
         *  @var boolean
         */
        if (empty($column) === true) {
            /*
             *  @var static
             */
            return $this;
        }

        /*
         *  @var boolean
         */
        if ($this->where === null) {
            /*
             *  @var Frame\Database\Query\Where
             */
            $this->where = new Where();
        }

        /**
         *  @var array
         */
        $params = func_get_args();

        /*
         *  @var void
         */
        array_unshift($params, 'where');

        /*
         *  @var static
         */
        call_user_func_array(
            [
                $this, '__where',
            ], $params
        );

        /*
         *  @var static
         */
        return $this;
    }

    /**
     *  @param $column
     *  @param null $value
     *  @param string $operator
     *  @param string $paste
     *
     *  @return $this
     */
    public function having(
        $column,
        $value = null,
        $operator = '=',
        $paste = 'and'
    ) {
        /*
         *  @var boolean
         */
        if (empty($column) === true) {
            /*
             *  @var static
             */
            return $this;
        }

        /*
         *  @var boolean
         */
        if ($this->having === null) {
            /*
             *  @var Frame\Database\Query\Where
             */
            $this->having = new Where();
        }

        /**
         *  @var array
         */
        $params = func_get_args();

        /*
         *  @var void
         */
        array_unshift($params, 'having');

        /*
         *  @var static
         */
        call_user_func_array(
            [
                $this, '__where',
            ], $params
        );

        /*
         *  @var static
         */
        return $this;
    }

    /**
     *  @param  string $clause
     *  @param  mixed  $column
     *  @param  string $value
     *  @param  string $operator
     *  @param  string $paste
     *
     *  @return static
     */
    protected function __where(
        $clause,
        $column,
        $value = null,
        $operator = '=',
        $paste = 'and'
    ) {
        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var array
         */
        $clause = array_shift(
            $params
        );

        /*
         *  @var boolean
         */
        if (count($params) === 1) {
            /*
             *  @var boolean
             */
            if (gettype($column) === 'string') {
                /*
                 *  @var \Frame\Database\Query\Where
                 */
                $this->{$clause}->push($column);
            }

            if (is_callable($column) === true) {
                /*
                 *  @var \Frame\Database\Query\Where
                 */
                $this->{$clause}->separate(
                    $this, $column, $paste
                );
            }

            if (gettype($column) === 'array') {
                /*
                 *  @var \Frame\Database\Query\Where
                 */
                foreach ($column as $_column => $_value) {
                    is_numeric(
                        $_column
                    ) ? $this->{$clause}->push(
                        $_value
                    ) : $this->{$clause}->set(
                            $this->separate(
                                $_column
                            ),
                            '=',
                            $this->bind(
                                $_value
                            )
                        );
                }
            }

            /*
             *  @var static
             */
            return $this;
        }

        /*
         *  @var boolean
         */
        if (count($params) === 2) {
            /*
             *  @var array
             */
            list(
                $column,
                $value
            ) = $params;
        }

        /*
         *  @var boolean
         */
        if (count($params) === 3) {
            /*
             *  @var array
             */
            list(
                $column,
                $operator,
                $value
            ) = $params;
        }

        /*
         *  @var boolean
         */
        if (count($params) === 4) {
            /*
             *  @var array
             */
            list(
                $column,
                $operator,
                $value,
                $paste
            ) = $params;
        }

        /*
         *  @var \Frame\Database\Query\Where
         */
        $this->{$clause}->set(
            $this->separate(
                $column
            ),
            $operator,
            $this->bind(
                $value
            ),
            $paste
        );

        /*
         *  @var static
         */
        return $this;
    }

    /**
     *  @param $column
     *
     *  @return $this
     */
    public function group($column)
    {
        /**
         *  @var array
         */
        $columns = gettype($column) === 'array' ?
            $column : func_get_args();

        foreach ($columns as $column) {
            /*
             *  @var void
             */
            array_push(
                $this->group, $this->separate($column)
            );
        }

        /*
         *  @var void
         */
        return $this;
    }

    /**
     *  @param $column
     *  @param string $sort
     *
     *  @return $this
     */
    public function order($column, $sort = 'ASC')
    {
        /*
         *  @var boolean
         */
        if ($column === null) {
            /*
             *  @var static
             */
            return $this;
        }

        /**
         *  @var array
         */
        $columns = gettype($column) === 'array' ?
            $column : [$column => $sort];

        foreach ($columns as $column => $sort) {
            /*
             *  @var void
             */
            array_push(
                $this->order,
                is_numeric($column) ? sprintf(
                    '%s ASC',
                    $this->separate($sort)
                ) : sprintf(
                    '%s %s',
                    $this->separate($column),
                    strtoupper($sort)
                )
            );
        }

        /*
         *  @var void
         */
        return $this;
    }

    /**
     *  @param $number
     *  @param null $offset
     *
     *  @return Query
     */
    public function limit($number, $offset = null)
    {
        if (is_numeric($number) === true) {
            /*
             *  @var integer
             */
            $this->limit = $number;
        }

        /*
         *  @var void
         */
        return $this->offset(
            $offset
        );
    }

    /**
     *  @param $number
     *
     *  @return $this
     */
    public function offset($number)
    {
        if (is_numeric($number) === true) {
            /*
             *  @var integer
             */
            $this->offset = $number;
        }

        /*
         *  @var void
         */
        return $this;
    }

    /**
     *  @param $clause
     *
     *  @return $this|mixed
     */
    public function and($clause)
    {
        /*
         *  @var void
         */
        $this->{$clause}->and();

        /**
         *  @var array
         */
        $params = func_get_args();

        /*
         *  @var boolean
         */
        if (count($params) === 1) {
            /*
             *  @var static
             */
            return $this;
        }

        /*
         *  @var static
         */
        return call_user_func_array([
            $this, array_shift($params),
        ], $params);
    }

    /**
     *  @param $clause
     *
     *  @return $this|mixed
     */
    public function or($clause)
    {
        /*
         *  @var void
         */
        $this->{$clause}->or();

        /**
         *  @var array
         */
        $params = func_get_args();

        /*
         *  @var boolean
         */
        if (count($params) === 1) {
            /*
             *  @var static
             */
            return $this;
        }

        /*
         *  @var static
         */
        return call_user_func_array([
            $this, array_shift($params),
        ], $params);
    }

    /**
     *  @param $column
     *  @param $alias
     *
     *  @return string
     */
    public function as($column, $alias)
    {
        /*
         *  @var string
         */
        return sprintf(
            '%s AS %s',
            $this->separate($column),
            $this->separate($alias)
        );
    }

    /**
     *  @param $value
     *
     *  @return string
     */
    public function bit($value)
    {
        /*
         *  @var string
         */
        return sprintf(
            'b\'%d\'', boolval($value)
        );
    }

    /**
     *  @param $value
     *
     *  @return string
     */
    public function bind($value)
    {
        static $increment = null;

        if ($increment === null) {
            $increment = -1;
        }

        /*
         *  @var boolean
         */
        if (gettype($value) === 'array') {
            foreach ($value as &$subvalue) {
                /**
                 *  @var string
                 */
                $subvalue = $this->bind(
                    $subvalue
                );
            }

            /*
             *  @var array
             */
            return $value;
        }

        /*
         *  @var boolean
         */
        if ($value === 'b\'1\'' || $value === 'b\'0\'') {
            /*
           *  @var string
           */
          return $value;
        }

        /*
         *  @var boolean
         */
        if ($value === null) {
            /*
             *  @var string
             */
            return 'NULL';
        }

        /**
         *  @var string
         */
        $key = sprintf(
            ':%d', ++$increment
        );

        /*
         *  @var void
         */
        $this->bind[$key] = $value;

        /*
         *  @var string
         */
        return $key;
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function date($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'DATE(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function sum($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'SUM(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function count($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'COUNT(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function max($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'MAX(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function year($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'YEAR(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function week($column)
    {
        /*
         *  @return string
         */
        return sprintf(
            'WEEK(%s)', $this->separate($column)
        );
    }

    /**
     *  @param $column
     *
     *  @return string
     */
    public function separate($column)
    {
        if (strpos($column, '`') !== false || strpos($column, '*') !== false || strpos($column, '(') !== false || strpos($column, '\'') !== false) {
            return $column;
        }

        /*
         *  @var string
         */
        return sprintf(
            '`%s`', str_replace('.', '`.`', $column)
        );
    }

    /**
     *  @param  string $prop
     *
     *  @return mixed
     */
    public function get($prop)
    {
        /*
         *  @var array
         */
        switch ($prop) {
            case 'bind':
                /*
                 *  @var array
                 */
                return $this->bind;
                break;
        }
    }

    /**
     *  @param $type
     *
     *  @return null|string
     */
    public function to($type)
    {
        /*
         *  @var array
         */
        switch ($type) {
            case 'string': case 'str':
                /**
                 *  @var string
                 */
                $column = implode(', ', $this->columns);

                /**
                 *  @var array
                 */
                $values = $this->values;

                /**
                 *  @var string
                 */
                $join = implode(' ', $this->join);

                /**
                 *  @var string
                 */
                $where = $this->where !== null ?
                    sprintf(
                        'WHERE %s',
                        $this->where->to('string')
                    ) : null;

                /**
                 *  @var string
                 */
                $having = $this->having !== null ?
                    sprintf(
                        'HAVING %s',
                        $this->having->to('string')
                    ) : null;

                /**
                 *  @var string
                 */
                $group = count($this->group) > 0 ?
                    sprintf(
                        'GROUP BY %s',
                        implode(', ', $this->group)
                    ) : null;

                /**
                 *  @var string
                 */
                $order = count($this->order) > 0 ?
                    sprintf(
                        'ORDER BY %s',
                        implode(', ', $this->order)
                    ) : null;

                /**
                 *  @var string
                 */
                $limit = is_numeric($this->limit) && $this->limit > 0 ?
                    sprintf(
                        'LIMIT %s',
                        $this->limit
                    ) : null;

                /**
                 *  @var string
                 */
                $offset = is_numeric($this->offset) && $this->offset > 0 ?
                    sprintf(
                        'OFFSET %s',
                        $this->offset
                    ) : null;

                if ($this->state === static::SELECT) {
                    $builder = [
                        'SELECT',
                        $column,
                        'FROM',
                        $this->table,
                        $join,
                        $where,
                        $group,
                        $having,
                        $order,
                        $limit,
                        $offset,
                    ];
                }

                if ($this->state === static::INSERT) {
                    /**
                     *  @var string
                     */
                    $column = sprintf(
                        '(%s)', implode(
                            ', ', array_keys($values)
                        )
                    );

                    /**
                     *  @var string
                     */
                    $values = sprintf(
                        '(%s)', implode(
                            ', ', array_values($values)
                        )
                    );

                    $builder = [
                        'INSERT INTO',
                        $this->table,
                        $column,
                        'VALUES',
                        $values,
                    ];
                }

                if ($this->state === static::UPDATE) {
                    foreach ($values as $column => &$value) {
                        $value = sprintf(
                            '%s = %s',
                            $column,
                            $value
                        );
                    }

                    $builder = [
                        'UPDATE',
                        $this->table,
                        $join,
                        'SET',
                        implode(', ', $values),
                        $where,
                        $group,
                        $having,
                        $order,
                        $limit,
                        $offset,
                    ];
                }

                if ($this->state === static::DELETE) {
                    $builder = [
                        'DELETE',
                        'FROM',
                        $this->table,
                        $join,
                        $where,
                        $group,
                        $having,
                        $order,
                        $limit,
                        $offset,
                    ];
                }

                /*
                 * @var string
                 */
                return implode(
                    ' ', array_filter($builder)
                );

                break;
        }
    }
}
