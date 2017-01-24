<?php

function __($word, $locale = null)
{
    return Frame\App::singleton(
        'locator', 'get', 'translator'
    )->translate(
        $word, $locale
    );
}

function route($class, $event, $separator = '@')
{
    return sprintf(
        '%s%s%s', $class, $event, $separator
    );
}

function base($path = '')
{
    return sprintf(
        '%s%s', $_SERVER['DOCUMENT_ROOT'], $path
    );
}

// include 'http/procedures.php';
// include __DIR__ . '/package/procedures.php';
// include __DIR__ . '/service/#procedure.php';
