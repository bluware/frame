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
    public function add($column, $operator = '=', $value, $paste = 'and')
    {
        $operator = strtoupper($operator);

        switch ($operator) {
            case 'IN': case 'NOT IN':
                $this->push(
                    sprintf(
                        '%s %s (%s)',
                        $column,
                        $operator,
                        join(
                            ', ', is_array($value) ?
                                $value : [$value]
                        )
                    ), $paste
                );
                break;

            case 'BETWEEN': case 'NOT BETWEEN':
                if (gettype($value) !== 'array')
                    return $this;

                list($from, $to) = array_values(
                    $value
                );

                $this->push(
                    sprintf(
                        '%s %s %s AND %s',
                        $column,
                        $operator,
                        $from,
                        $to
                    ), $paste
                );
                break;

            case 'LIKE': case 'NOT LIKE':
                if (gettype($value) !== 'array')
                    return $this;

                list($from, $to) = array_values(
                    $value
                );

                $this->push(
                    sprintf(
                        '%s BETWEEN %s AND %s',
                        $column,
                        $from,
                        $to
                    ), $paste
                );
                break;

            default:
                $this->push(
                    sprintf(
                        '%s %s %s',
                        $column,
                        $operator,
                        $value
                    ), $paste
                );
                break;
        }

        return $this;
    }

    /**
     *  @return void
     */
    public function and()
    {
        return $this->paste('and');
    }

    /**
     *  @return void
     */
    public function or()
    {
        return $this->paste('or');
    }

    /**
     *  @param  string $query
     *  @param  string $paste
     *
     *  @return void
     */
    public function push($query, $paste = 'and')
    {
        $this->paste($paste);

        array_push($this->data, $query);

        return $this;
    }

    /**
     *  @param  Query    $q
     *  @param  callable $callback
     *
     *  @return void
     */
    public function detach(Query $q, callable $callback)
    {
        array_push($this->data, "(");

        call_user_func($callback, $q);

        array_push($this->data, ")");

        return $this;
    }

    /**
     *  @param  string $type
     *
     *  @return void
     */
    public function paste($type)
    {
        $type = strtoupper($type);

        if (sizeof($this->data) === 0)
            return $this;

        $end = end($this->data);

        if ($end === "(" || $end === 'OR' || $end === 'AND')
            return $this;

        array_push(
            $this->data, $type
        );

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
            case 'string':
                $data = $this->data;

                return join(' ', $data);
                break;
        }
    }
}
