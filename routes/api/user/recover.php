<?php

use Database\UserInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Request;

Access::unLogged();

$request = Request::get('random', 'password');
if (!UserInfo::checkRandom($request['random'])) throw NotFoundException::default();
UserInfo::updateRandomPassword($request['random'], password_hash($request['password'], PASSWORD_DEFAULT));
