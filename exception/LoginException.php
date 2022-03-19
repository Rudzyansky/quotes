<?php

namespace Exception;

class LoginException extends EngineException
{
    protected $code = 400;
    protected string $localized = "Login Error";

    public static function logged(): LoginException
    {
        return new LoginException("You already Logged In", 403);
    }

    public static function notLogged(): LoginException
    {
        return new LoginException("You are not Logged In", 401);
    }

    public static function wrong(): LoginException
    {
        return new LoginException("Wrong Username or Password");
    }
}