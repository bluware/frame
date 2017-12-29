<?php

namespace Frame;

/**
 * Class HttpLogMessage
 * @package Frame
 * https://en.wikipedia.org/wiki/Common_Log_Format
 */
class HttpLogMessage
{
    /**
     * @var IHttpLogRequest
     */
    private $_httpLogRequest;

    /**
     * @var IHttpLogRequest
     */
    private $_httpLogClient;

    /**
     * @param IHttpLogRequest $httpLogRequest
     * @param IHttpLogClient $httpLogClient
     */
    public function constructor(
        IHttpLogRequest $httpLogRequest,
        IHttpLogClient $httpLogClient
    ) {
        $this->_httpLogRequest = $httpLogRequest;
        $this->_httpLogClient = $httpLogClient;
    }

    /**
     * @return IHttpLogRequest
     */
    public function getHttpLogRequest()
    {
        return $this->_httpLogRequest;
    }

    /**
     * @return IHttpLogRequest
     */
    public function getHttLogClient()
    {
        return $this->_httpLogClient;
    }
}