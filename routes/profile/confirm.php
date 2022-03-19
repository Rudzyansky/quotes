<?php

use Config\AccessLevel;
use Database\UserInfo;
use Exception\ConfirmException;
use Helper\Access;
use Helper\Page;
use Helper\Route;

$random = Route::over()[0];

Access::logged();
if (UserInfo::getAccessLevel($_SESSION['name']) >= AccessLevel::ADMINISTRATOR) {
    UserInfo::updateRandomLevel($random, AccessLevel::NOT_CONFIRMED);
    return;
}
Access::requireLevelEquals(AccessLevel::GUEST);

if (UserInfo::getRandom($_SESSION['name']) != $random) throw ConfirmException::wrongRandom();

UserInfo::updateRandomLevel($random, AccessLevel::NOT_CONFIRMED);

Page::print("E-mail Confirmation", Route::target(), [
    'username' => $_SESSION['name']
]);
