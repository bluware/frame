<?php

namespace Frame;

use Frame\App\Exception;

abstract class LoggerAbstract
{
    private $level = 0;

    const FRAME_LOGGER_NONE = 0;
    const FRAME_LOGGER_DEBUG = 1;
    const FRAME_LOGGER_INFO = 2;
    const FRAME_LOGGER_WARNING = 4;
    const FRAME_LOGGER_ERROR = 8;

    public function __construct(int $level)
    {
        $this->level = $level;
    }

    public function debug($message, $code = 0): void
    {
        $this->createMessage(static::FRAME_LOGGER_DEBUG, $message, $code);
    }

    public function info($message, $code = 0): void
    {
        $this->createMessage(static::FRAME_LOGGER_INFO, $message, $code);
    }

    public function warning($message, $code = 0): void
    {
        $this->createMessage(static::FRAME_LOGGER_WARNING, $message, $code);
    }

    public function error($message, $code = 0): void
    {
        $this->createMessage(static::FRAME_LOGGER_ERROR, $message, $code);
    }

    private function createMessage(int $messageType, $message, $code = 0): void
    {
        if ((bool) ($this->level & $messageType)) {
            switch ($messageType) {
                case static::FRAME_LOGGER_DEBUG:
                    //
                    break;

                case static::FRAME_LOGGER_INFO:
                    //
                    break;

                case static::FRAME_LOGGER_WARNING:
                    //
                    break;

                case static::FRAME_LOGGER_ERROR:
                    //
                    break;

                default:
                    throw new Exception("Log message type have a incorrect format.");
                    break;
            }
        }
    }
}