<?php

namespace Exception;

use Throwable;

class UnexpectedException extends EngineException
{
    protected string $localized = "Unexpected Error";

    /**
     * @param $e Throwable
     * @return UnexpectedException
     */
    static function from(Throwable $e): UnexpectedException
    {
        return new UnexpectedException($e->getMessage());
    }
}