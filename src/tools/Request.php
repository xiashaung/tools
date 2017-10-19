<?php

namespace Tools\tools;

use \Symfony\Component\HttpFoundation\Request as fromRequest;

class Request  extends  fromRequest
{
    public function instance()
    {
        self::createFromGlobals();

        return $this->query;
    }
}