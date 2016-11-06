<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Essence
 */
class Essence implements EssenceInterface
{
    /**
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Readable
     */
    public static function readable($data = null)
    {
        return new \Blu\Essence\Readable($data);
    }

    /**
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Writeable
     */
    public static function writeable($data = null)
    {
        return new \Blu\Essence\Writeable($data);
    }
}
