<?php /** @noinspection PhpUnhandledExceptionInspection */

use Config\AccessLevel;
use Database\UserInfo;
use Exception\LoginException;
use Exception\SignupException;
use Helper\Mail;
use Helper\Random;
use Helper\Request;

$accessLevel = AccessLevel::GUEST;

if (isset($_SESSION['username'])) {
    $accessLevel = UserInfo::getAccessLevel($_SESSION['username']);
    if ($accessLevel < AccessLevel::ADMINISTRATOR) throw LoginException::logged();
}

$request = Request::get('name', 'username', 'email', 'password');

$name = $request['name'];
$username = $request['username'];
$email = $request['email'];
$password = password_hash($request['password'], PASSWORD_DEFAULT);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw SignupException::wrongEmail();

if (UserInfo::checkNameExist($name)) throw SignupException::nameExist();
if (UserInfo::checkUsernameExist($username)) throw SignupException::usernameExist();
if (UserInfo::checkEmailExist($email)) throw SignupException::emailExist();

UserInfo::add($name, $username, $email, $password);
UserInfo::updateLastLogin($username);

if ($accessLevel >= AccessLevel::ADMINISTRATOR) return;

$_SESSION['username'] = $username;

$random = Random::generate();
UserInfo::updateRandom($name, $random);
Mail::confirm($username, $email, $random);
