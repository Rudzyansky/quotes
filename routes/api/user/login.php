<?php

use Database\UserInfo;
use Exception\LoginException;
use Helper\Access;
use Helper\Request;

Access::unLogged();

$request = Request::get('username', 'password');

$username = $request['username'];

if (!password_verify($request['password'], UserInfo::getPasswordHash($username)))
    throw LoginException::wrong();

UserInfo::updateLastLogin($username);

$_SESSION['username'] = $username;
