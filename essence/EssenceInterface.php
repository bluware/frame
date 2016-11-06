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
interface EssenceInterface
{
    /**
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Readable
     */
    public static function readable($data = null);

    /**
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Writeable
     */
    public static function writeable($data = null);
}
