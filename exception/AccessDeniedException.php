<?php

namespace Exception;

class AccessDeniedException extends EngineException
{
    protected $code = 403;
    protected string $localized = "Access Denied";

    static function level($required): AccessDeniedException
    {
        return new AccessDeniedException("Required Access Level $required for this Action");
    }
}