<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Request;

Access::logged();
Access::requireLevelGreaterEquals(AccessLevel::MODERATOR);

$id = Request::get('id')['id'];

if (QuoteInfo::checkForExists($id))
    QuoteInfo::remove($id);
else throw NotFoundException::quote($id);
