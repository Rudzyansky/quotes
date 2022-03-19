<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Exception\NotFoundException;
use Helper\Access;
use Helper\Request;

Access::requireLevelGreaterEquals(AccessLevel::CORRUPT);

$id = Request::get('id')['id'];
$quote = QuoteInfo::get($id);
if ($quote) print json_encode($quote);
else throw NotFoundException::quote($id);
