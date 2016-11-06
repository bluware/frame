<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

/**
 * @subpackage Http
 */
abstract class URIAbstract extends \Blu\Essence\ReadableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($url)
    {
        if ($this->validate($url) === false)
            throw new \Exception(
                "Bad url format: " . $url
            );

        parent::__construct(
            parse_url($url)
        );

        /**
         *  @var \Blu\Http\URI\Query
         */
        $this->data['query'] = new \Blu\Http\URI\Query(
            parse_str(
                $this->data('query')
            )
        );
    }

    /**
     *  @param  string $uri
     *
     *  @return boolean
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
        if ($key === null)
            return $this->get('query');

        if ($val === null)
            return $this->get('query')->get(
                $key
            );

        $this->get('query')->set(
            $key, $val
        );

        return $this;
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        $components = [];

        if ($this->has('scheme') === true)
            array_push(
                $components, $this->get('scheme'), '://'
            );

        if ($this->has('user') === true) {
            array_push(
                $components, $this->get('user')
            );

            if ($this->has('pass') === true)
                array_push(
                    $components, ':', $this->get('pass')
                );

            array_push($components, '@');
        }

        if ($this->has('host') === true)
            array_push(
                $components, $this->get('host')
            );

        if ($this->has('port') === true)
            array_push(
                $components, ':', $this->get('port')
            );

        if ($this->has('path') === true)
            array_push(
                $components, $this->get('path')
            );

        if (empty($this->get('query')->data()) === false)
            array_push(
                $components, '?', $this->get('query')->__toString()
            );

        if ($this->has('fragment') === true)
            array_push(
                $components, '#', $this->get('fragment')
            );

        return join('', $components);
    }
}
