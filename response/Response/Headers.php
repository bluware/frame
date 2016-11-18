<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Response;

/**
 * @subpackage Response
 */
class Headers extends \Blu\Data\WriteableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @return void
     */
    public function __invoke()
    {
        foreach ($this->to('array') as $header)
            header($header);
    }

    /**
     *  Convert to type
     *
     *  Usage:
     *      array   to('array');
     *      string  to('string');
     *      string  to('json');
     *
     *  @param string $type
     *
     *  @return mixed
     */
    public function to($type = 'string')
    {
        if ($type === 'array') {
            $data = [];

            foreach ($this as $key => $val) {
                array_push(
                    $data,
                    sprintf(
                        '%s: %s',
                        $key,
                        $val
                    )
                );
            }

            return $data;
        }

        if ($type === 'string')
            return join(
                "\n\r", $this->to('array')
            );

        return null;
    }
}
