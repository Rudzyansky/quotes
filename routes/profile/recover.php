<?php

use Database\UserInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Page;
use Helper\Route;

Access::unLogged();

$random = Route::over()[0];

if (!UserInfo::checkRandom($random)) throw NotFoundException::recover();

Page::print("Restoring Account", Route::target(), ['random' => $random], ['common'], ['common'], [Route::target()]);
