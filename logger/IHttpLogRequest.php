<?php

namespace Frame;

interface IHttpLogRequest
{
    public function getRequestIpAddress(): integer;
    public function getRequestUserAgent(): integer;
}