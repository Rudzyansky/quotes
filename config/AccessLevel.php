<?php

namespace Config;

class AccessLevel
{
    const BANNED = -2; // banned
    const CORRUPT = -1; // confirmed e-mail, can't write
    const GUEST = 0; // unregistered, guest
    const NOT_CONFIRMED = 1; // not confirmed e-mail
    const USER = 2; // confirmed e-mail, can write
    const MODERATOR = 3; // can edit/delete
    const ADMINISTRATOR = 4; // can everything
}