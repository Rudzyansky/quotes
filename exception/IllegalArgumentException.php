<?php

namespace Exception;

class IllegalArgumentException extends EngineException
{
    protected $code = 400;
    protected string $localized = "Illegal Argument";
}