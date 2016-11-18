<?php

include __DIR__ . '/../autoload.php';

spl_autoload_register(function($class) {
    static $classmap = null;

    if ($classmap === null)
        $classmap = include __DIR__ . '/classmap.php';

    if (array_key_exists($class, $classmap) === true)
        include $classmap[$class];
});
