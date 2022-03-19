<?php

namespace Exception;

class SignupException extends EngineException
{
    protected $code = 400;
    protected string $localized = "Registration Error";

    public static function nameExist(): SignupException
    {
        return new SignupException("Name already exist");
    }

    public static function usernameExist(): SignupException
    {
        return new SignupException("Username already exist");
    }

    public static function emailExist(): SignupException
    {
        return new SignupException("E-mail already exist");
    }

    public static function wrongEmail(): SignupException
    {
        return new SignupException("Wrong e-mail");
    }
}