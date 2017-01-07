<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Http\Response;

/**
 * @subpackage View
 */
trait ViewTrait
{
    /**
     *  @param  string      $path
     *  @param  array       $data
     *  @param  boolean     $prevent
     *  @param  integer     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function view(
        $path, array $data = [], $prevent = false, $code = 200, $headers = []
    ) {
        /**
         *  @var mixed
         */
        $page = $this->locator('get', 'view')->make(
            $path, $data, $prevent
        );

        /**
         *  @var \Frame\Response
         */
        return Response::html(
            $page, $code, $headers
        );
    }
}
