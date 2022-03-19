<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Helper\Access;
use Helper\Quote;
use Helper\Request;

Access::logged();
Access::requireLevelGreaterEquals(AccessLevel::USER);

$id = QuoteInfo::add(Quote::format(Request::get('text')['text']));
print json_encode(QuoteInfo::get($id));
