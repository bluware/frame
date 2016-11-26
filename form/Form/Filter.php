<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Form;

use DateTime;

/**
 * @subpackage Form
 */
class Filter
{
    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function null($value)
    {
        return $value === null;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function boolean($value)
    {
        return gettype($value) === 'boolean';
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function bool($value)
    {
        return static::boolean($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function integer($value)
    {
        return boolval(
            filter_var(
                $value, FILTER_VALIDATE_INT
            )
        );
    }

    /**
     *  Alias for `integer`
     *
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function int($value)
    {
        return static::integer($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function float($value)
    {
        return boolval(
            filter_var(
                $value, FILTER_VALIDATE_FLOAT
            )
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function numeric($value)
    {
        return is_numeric($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function num($value)
    {
        return static::numeric($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function string($value)
    {
        return gettype($value) === 'string';
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function str($value)
    {
        return static::string($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function ip($value)
    {
        return boolval(
            filter_var(
                $value, FILTER_VALIDATE_IP
            )
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function alpha($value)
    {
        return (bool) preg_replace('/^[a-zA-Z]+$/i', '', $value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function al($value)
    {
        return static::alpha($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function scalar($value)
    {
        return is_scalar($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function sca($value)
    {
        return static::scalar($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function array($value)
    {
        return gettype($value) === 'array';
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function arr($value)
    {
        return static::array($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function alphanumeric($value)
    {
        return boolval(
            preg_replace(
                '/^[a-zA-Z0-9]+$/i', '', $value
            )
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function alhanum($value)
    {
        return static::alphanumeric($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function alnumeric($value)
    {
        return static::alphanumeric($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function alnum($value)
    {
        return static::alphanumeric($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function email($value)
    {
        return boolval(
            filter_var(
                $value, FILTER_VALIDATE_EMAIL
            )
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function mail($value)
    {
        return static::email($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function url($value)
    {
        return boolval(
            filter_var(
                $value, FILTER_VALIDATE_URL
            )
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function regexp($value, $pattern)
    {
        return boolval(
            preg_match($pattern, $value)
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function html($value)
    {
        return static::regexp($value, '/(\/[a-z0-9]*>|<.*?\=\".*?>)/i');
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function text($value)
    {
        return static::html($value) === false;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function datetime($value, $format = 'Y-m-d H:i:s')
    {
        if ($format === 'c' || strtoupper($format) === 'ISO8601')
            $format = 'Y-m-d\TH:i:sO';

        return DateTime::createFromFormat(
            $format, $value
        ) !== false;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function date($value, $format = 'Y-m-d')
    {
        return static::datetime($value, $format);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function time($value, $format = 'H:i:s')
    {
        return static::datetime($value, $format);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function minimum($value, $size)
    {
        return strlen($value) >= $size;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function min($value, $size)
    {
        return static::minimum($value, $size);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function maximum($value, $size)
    {
        return strlen($value) <= $size;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function max($value, $size)
    {
        return static::maximum($value, $size);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function between($value, $min, $max)
    {
        $length = strlen($value);
        return $length >= $min && $length <= $max;
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function enum($value, $data)
    {
        /**
         *  @var boolean
         */
        if (gettype($data) !== 'array') {
            /**
             *  @var boolean
             */
            $data = func_get_args();

            /**
             *  @var boolean
             */
            array_shift($data);
        }

        /**
         *  @var boolean
         */
        return in_array(
            $value, $data, true
        );
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function required($value)
    {
        return !empty($value);
    }

    /**
     *  @param  mixed $value
     *
     *  @return bool
     */
    public static function require($value)
    {
        return static::required($value);
    }
}
