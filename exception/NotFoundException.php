<?php

namespace Exception;

class NotFoundException extends EngineException
{
    protected $code = 404;
    protected string $localized = "Not Found";

    static function default(): NotFoundException
    {
        return new NotFoundException();
    }

    static function quote($id): NotFoundException
    {
        return new NotFoundException("Quote with id $id does not exist");
    }

    static function path($path): NotFoundException
    {
        return new NotFoundException("Route '$path' does not exist");
    }

    static function recover(): NotFoundException
    {
        return new NotFoundException("Wrong recover code");
    }
}