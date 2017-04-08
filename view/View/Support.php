<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\View;

use Frame\Response;

trait Support
{
    /**
     *  @param  string      $path
     *  @param  array       $data
     *  @param  bool     $prevent
     *  @param  int     $code
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
        $page = $this->locator('view')->make(
            $path, $data, $prevent
        );

        /*
         *  @var \Frame\Response
         */
        return Response::html(
            $page, $code, $headers
        );
    }
}
