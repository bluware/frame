<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Dir
 */
class Dir
{
    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function exists($path)
    {
        return is_dir($path);
    }

    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function is($path)
    {
        return is_dir($path);
    }

    /**
     *  @param  [type] $path [description]
     *  @return [type]       [description]
     */
    public static function name($path)
    {
        return dirname($path);
    }

    /**
     *  @param  string  $path
     *  @param  integer $mode
     *  @param  bool    $recursive
     *
     *  @return bool
     */
    public static function make(
        $path, $mode = 0755, $recursive = true
    ) {
        if (is_dir($path) === false)
            return mkdir(
                $path, $mode, $recursive
            );

        return true;
    }

    /**
     *  @param  string  $path
     *  @param  integer $mode
     *  @param  bool    $recursive
     *
     *  @return bool
     */
    public static function mk(
        $path, $mode = 0755, $recursive = true
    ) {
        if (is_dir($path) === false)
            return mkdir(
                $path, $mode, $recursive
            );

        return true;
    }

    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function remove($path)
    {
        return rmdir($path);
    }

    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function rm($path)
    {
        return rmdir($path);
    }
}
