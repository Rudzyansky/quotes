<?php

namespace Exception;

class ConfirmException extends EngineException
{
    protected string $localized = "Confirmation Error";

    public static function wrongRandom(): ConfirmException
    {
        return new ConfirmException("Wrong random string", 400);
    }
}