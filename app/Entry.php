<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

abstract class Entry
{
    use TServiceProvider;

    /**
     * @var App
     */
    protected $app;

    /**
     *  Instance constructor.
     *
     *  @param App $app
     */
    public function __construct(App $app)
    {
        /*
         *  @var \Frame\App
         */
        $this->app = $app;

        /*
         *  @var \Frame\Locator
         */
        $this->setServiceLocator(
            $app->getServiceLocator()
        );
    }

    /**
     * @return App
     */
    final public function app()
    {
        return $this->app;
    }
}
