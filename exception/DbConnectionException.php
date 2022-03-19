<?php

namespace Exception;

class DbConnectionException extends EngineException
{
    protected string $localized = "Database Connection Error";
}