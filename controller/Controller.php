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
abstract class Controller extends Entry
{
    use Hook\Support;
    use Daemon\Support;
    use Response\Support;
    use Request\Support;
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
         *  @var Hook
         */
        $this->hook     = $this->locator('hook');

        /**
         *  @var Request
         */
        $this->request  = $this->locator('request');
    }
}
