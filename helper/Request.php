<?php

namespace Helper;

use Exception\IllegalArgumentException;

class Request
{
    public static function get(...$required)
    {
        $request = json_decode(file_get_contents("php://input"), true);
        $error = [];
        foreach ($required as $field) if (!isset($request[$field])) $error[] = "'$field'";
        if (!empty($error)) throw new IllegalArgumentException(implode(", ", $error) . " must be set");
        return $request;
    }
}