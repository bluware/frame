<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Locator;

/**
 * @subpackage Locator
 */
trait Support
{
    /**
     *  @var \Frame\App
     */
    protected $app;

    /**
     *  @var \Frame\Locator
     */
    protected $locator;

    /**
     *  @param null $invokable
     *
     *  @return mixed
     *  @throws Exception
     */
    public function locator($invokable = null)
    {
        /**
         *  @var boolean
         */
        if ($this->locator === null) {
            /**
             *  @var boolean
             */
            if ($this->app === null)
                /**
                 *  @thrown Exception
                 */
                throw new Exception(
                    'Locator support require App\Node object'
                );

            /**
             *  @var \Frame\Locator
             */
            $this->locator = $this->app->locator;
        }

        /**
         *  @var boolean
         */
        if ($invokable === null)
            /**
             *  @var \Frame\Locator
             */
            return $this->locator;

        /**
         *  @mixed
         */
        return $this->locator->get($invokable);
    }
}
