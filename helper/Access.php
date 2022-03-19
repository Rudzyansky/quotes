<?php

namespace Helper;

use Database\UserInfo;
use Exception\AccessDeniedException;
use Exception\LoginException;

class Access
{
    public static function isLogged(): bool
    {
        return isset($_SESSION['username']);
    }

    public static function logged()
    {
        if (!isset($_SESSION['username'])) throw LoginException::notLogged();
    }

    public static function unLogged()
    {
        if (isset($_SESSION['username'])) throw LoginException::logged();
    }

    public static function requireLevelGreaterEquals($level)
    {
        $accessLevel = UserInfo::getAccessLevel($_SESSION['username']);
        if ($accessLevel < $level) throw AccessDeniedException::level($level);
    }

    public static function requireLevelEquals($level)
    {
        $accessLevel = UserInfo::getAccessLevel($_SESSION['username']);
        if ($accessLevel != $level) throw AccessDeniedException::level($level);
    }

    public static function requireLevelLowerEquals($level)
    {
        $accessLevel = UserInfo::getAccessLevel($_SESSION['username']);
        if ($accessLevel > $level) throw AccessDeniedException::level($level);
    }

    public static function levelGreaterEquals($level): bool
    {
        return UserInfo::getAccessLevel($_SESSION['username']) >= $level;
    }

    public static function levelEquals($level): bool
    {
        return UserInfo::getAccessLevel($_SESSION['username']) == $level;
    }

    public static function levelLowerEquals($level): bool
    {
        return UserInfo::getAccessLevel($_SESSION['username']) <= $level;
    }
}