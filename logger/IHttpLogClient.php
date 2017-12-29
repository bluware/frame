<?php

namespace Frame;

interface IHttpLogClient
{
    public function getClientIdentity(): integer;
    public function getClientName(): integer;
}