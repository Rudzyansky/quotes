<?php

use Config\AccessLevel;
use Database\UserInfo;
use Exception\ConfirmException;
use Helper\Access;
use Helper\Request;

Access::logged();
$request = Request::get('random');
if (UserInfo::getAccessLevel($_SESSION['username']) >= AccessLevel::ADMINISTRATOR) {
    UserInfo::updateRandomLevel($request['random'], AccessLevel::USER);
    return;
}
Access::requireLevelEquals(AccessLevel::NOT_CONFIRMED);

if (UserInfo::getRandom($_SESSION['name']) != $request['random']) throw ConfirmException::wrongRandom();

UserInfo::updateRandomLevel($request['random'], AccessLevel::USER);
