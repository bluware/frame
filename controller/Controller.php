<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;


/**
 * @subpackage Controller
 */
abstract class Controller extends Node
{
    use Hook\Support;
    use Http\Response\Support;
    use Http\Request\Support;
    use View\Support;

    /**
     *  Instance constructor.
     *
     *  @param App $app
     */
    public function __construct(App $app)
    {
        /**
         *
         */
        parent::__construct($app);

        /**
         *  @var \Frame\Hook
         */
        $this->hook     = $this->locator('hook');

        /**
         *  @var \Frame\Http\Request
         */
        $this->request  = $this->locator('request');
    }
}
