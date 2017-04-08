<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Http;

use Frame\Data\Writable;
use Frame\Http\Uri\Query;

class Uri extends Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct($url)
    {
        if ($this->validate($url) === false) {
            throw new \Exception(
                'Bad url format: '.$url
            );
        }

        /*
         *  @var array
         */
        $this->data = parse_url($url);

        /*
         *  @var \Frame\Uri\Query
         */
        $this->data([
            'query' => new Query(
                parse_str(
                    $this->get('query')
                )
            ),
        ]);
    }

    /**
     *  @param  string $uri
     *
     *  @return bool
     */
    public function validate($uri)
    {
        return filter_var(
            $uri, FILTER_VALIDATE_URL
        );
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $val
     *
     *  @return mixed
     */
    public function query($key = null, $val = null)
    {
        if ($key === null) {
            return $this->get('query');
        }

        if ($val === null) {
            return $this->get('query')->get(
                $key
            );
        }

        $this->get('query')->set(
            $key, $val
        );

        return $this;
    }

    public function to($type)
    {
        return $this->__toString();
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        $components = [];

        if ($this->has('scheme') === true) {
            array_push(
                $components, $this->get('scheme'), '://'
            );
        }

        if ($this->has('user') === true) {
            array_push(
                $components, $this->get('user')
            );

            if ($this->has('pass') === true) {
                array_push(
                    $components, ':', $this->get('pass')
                );
            }

            array_push($components, '@');
        }

        if ($this->has('host') === true) {
            array_push(
                $components, $this->get('host')
            );
        }

        if ($this->has('port') === true) {
            array_push(
                $components, ':', $this->get('port')
            );
        }

        if ($this->has('path') === true) {
            array_push(
                $components, $this->get('path')
            );
        }

        if (empty($this->get('query')->data()) === false) {
            array_push(
                $components, '?', $this->get('query')->to('string')
            );
        }

        if ($this->has('fragment') === true) {
            array_push(
                $components, '#', $this->get('fragment')
            );
        }

        return implode('', $components);
    }
}
