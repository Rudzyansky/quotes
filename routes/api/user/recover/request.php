<?php /** @noinspection PhpUnhandledExceptionInspection */

use Database\UserInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Mail;
use Helper\Random;
use Helper\Request;

Access::unLogged();

$username = Request::get('username')['username'];
if (!UserInfo::checkUsernameExist($username)) throw NotFoundException::default();

$user = UserInfo::get($username);
$random = Random::generate();

UserInfo::updateRandom($username, $random);
Mail::recover($user['name'], $user['email'], $random);
