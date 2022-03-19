<?php

namespace Exception;

class NotImplementedException extends EngineException
{
    protected $code = 501;
    protected string $localized = "Not Implemented";

    static function default(): NotImplementedException
    {
        return new NotImplementedException();
    }
}