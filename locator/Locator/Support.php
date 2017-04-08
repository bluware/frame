<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Locator;

trait Support
{
    /**
     *  @var \Frame\Locator
     */
    protected $locator;

    /**
     *  @param null $invokable
     *
     *  @throws Exception
     *
     *  @return mixed
     */
    public function locator($invokable = null)
    {
        /*
         *  @var boolean
         */
        if ($this->locator === null) {
            /*
             *  @var boolean
             */
            if (property_exists($this, 'app') === false) {
                /*
                 *  @thrown Exception
                 */
                throw new Exception(
                    'Locator support require App\Node object'
                );
            }

            /*
             *  @var \Frame\Locator
             */
            $this->locator = $this->app->locator;
        }

        /*
         *  @var boolean
         */
        if ($invokable === null) {
            /*
             *  @var \Frame\Locator
             */
            return $this->locator;
        }

        /*
         *  @mixed
         */
        return $this->locator->get($invokable);
    }
}
