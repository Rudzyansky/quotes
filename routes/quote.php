<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Helper\Access;
use Helper\Page;
use Helper\Quote;
use Helper\Route;

Access::requireLevelGreaterEquals(AccessLevel::CORRUPT);

$controls = [];
if (Access::levelGreaterEquals(AccessLevel::MODERATOR)) $controls = array_merge($controls, ['edit', 'remove']);

$quote = Route::over()[0] === 'n' ? QuoteInfo::getLast() : QuoteInfo::get(Route::over()[0]);
$data = [
    'id' => $quote['id'],
    'text' => $quote['text'],
    'timestamp' => $quote['timestamp'],
    'controls' => Quote::genControls($controls)
];
Page::print("Quote #${quote['id']}", Route::target(), $data, ['common'], ['common'], ["common_loader", "index", Route::target()]);
