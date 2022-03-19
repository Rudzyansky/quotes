<?php

namespace Helper;

use Exception;

class Random
{
    /**
     * @throws Exception
     */
    public static function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}