<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Hook;

use Frame\App;

/**
 * @subpackage Controller
 */
abstract class Controller extends \Frame\Controller
{
    /**
     *  @var array
     */
    protected $events   = [];

    /**
     *  @var array
     */
    protected $priority = [];

    /**
     *  @param App $app
     */
    public function __construct(App $app)
    {
        /**
         *  @var void
         */
        parent::__construct($app);

        /**
         *  @var iterable
         */
        foreach ($this->events as $event => $method)
            /**
             *  @var void
             */
            $this->hook('event', $event, [
                    $this, $method
                ], isset(
                    $this->priority[$event]
                ) ? $this->priority[$event] : 50
            );
    }
}
