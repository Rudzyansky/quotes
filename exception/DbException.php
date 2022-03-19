<?php

namespace Exception;

class DbException extends EngineException
{
    protected string $localized = "Database Error";
}