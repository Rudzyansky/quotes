<?php

namespace Helper;

class Search
{
    public static function sqlConditionFormer(array $words, array $tags, array $characters): string
    {
        $array = array();
        $a = "lower(text) regexp '";
        $b = "'";
        foreach ($words as $item) $array[] = $a . $item . $b;
        $a = "lower(text) regexp '(^|\n| )#";
        $b = "( |\n|$)'";
        foreach ($tags as $item) $array[] = $a . $item . $b;
        $a = "lower(text) regexp '((^|\n)";
        $b = ": |(^|\n)&lt;";
        $c = "&gt; |(^|\n| )\\\\((c|с)\\\\) ";
        $d = "(\n|$))'";
        foreach ($characters as $item) $array[] = $a . $item . $b . $item . $c . $item . $d;
        return empty($array) ? "" : "where " . implode(" and ", $array);
    }
}