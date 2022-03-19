<?php

use Config\AccessLevel;
use Helper\Access;
use Helper\Page;

Access::requireLevelGreaterEquals(AccessLevel::CORRUPT);

Page::printDefault("Quotes", [
    'left' => '<a id="add">add</a>',
    'center' => '<input id="search" placeholder="Search">'
]);
