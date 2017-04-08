<?php

/**
 *  @var void
 */
spl_autoload_register(function ($class) {
    /**
     *  @var array
     */
    static $classmap = null;

    /*
     *  @var boolean
     */
    if ($classmap === null) {
        /**
         *  @var array
         */
        $classmap = include __DIR__.'/classmap.php';
    }

    /*
     *  @var boolean
     */
    if (array_key_exists($class, $classmap) === true) {
        /**
         *  @var void
         */
        include $classmap[$class];
    }
});
