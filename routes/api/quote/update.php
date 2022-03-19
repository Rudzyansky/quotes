<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Quote;
use Helper\Request;

Access::logged();
Access::requireLevelGreaterEquals(AccessLevel::MODERATOR);

$request = Request::get('id', 'text');

if (QuoteInfo::checkForExists($request['id']))
    QuoteInfo::update($request['id'], Quote::format($request['text']));
else throw NotFoundException::quote($request['id']);
