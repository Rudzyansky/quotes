<?php

namespace Exception;

use JsonSerializable;
use RuntimeException;

class EngineException extends RuntimeException implements JsonSerializable
{
    protected $code = 500;
    protected string $localized = "Internal Engine Error";

    /**
     * @return string
     */
    public function getLocalized(): string
    {
        return $this->localized;
    }

    public function jsonSerialize(): array
    {
//        $class = explode('\\', get_class($this));
//        $type = $class[sizeof($class) - 1];
        return [
            'code' => $this->code,
//            'type' => $type,
            'localized' => $this->localized,
            'message' => $this->message
        ];
    }
}