<?php

function __($word)
{
    return $word;
}

function route($class, $event, $separator = '@')
{
    return sprintf(
        '%s%s%s', $class, $event, $separator
    );
}

// include 'http/procedures.php';
// include __DIR__ . '/package/procedures.php';
// include __DIR__ . '/service/#procedure.php';
