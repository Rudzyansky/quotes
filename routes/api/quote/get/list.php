<?php

use Config\AccessLevel;
use Config\Quotes;
use Database\MySQLi;
use Database\QuoteInfo;
use Helper\Access;
use Helper\Search;

Access::requireLevelGreaterEquals(AccessLevel::CORRUPT);

$request = json_decode(file_get_contents("php://input"), true);

$array = explode(' ', $request['search']);

$characters = array();
$words = array();
$tags = array();
foreach ($array as $item) {
    if (preg_match('/^@[\d\wа-яё]{3,}$/iu', $item)) {
        $characters[] = MySQLi::escape(mb_strtolower(substr($item, 1)));
    } else if (preg_match('/^#[\d\wа-яё]{3,}$/iu', $item)) {
        $tags[] = MySQLi::escape(mb_strtolower(substr($item, 1)));
    } else if (preg_match('/^.+$/iu', $item)) {
        $words[] = MySQLi::escape(mb_strtolower($item));
    }
}

$condition = Search::sqlConditionFormer($words, $tags, $characters);

$index = $request['index'] ?? 0;
$limit = $request['limit'] ?? Quotes::QUOTES_ON_PAGE;
$offset = $index * $limit;

$count = QuoteInfo::searchCount($condition);
$quotes = QuoteInfo::search($condition, $offset, $limit);

print json_encode([
    'index' => $index,
    'limit' => $limit,
    'found' => $count,
    'quotes' => $quotes
]);
