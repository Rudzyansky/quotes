<?php

namespace Helper;

class Quote
{
    public static function format(string $quote): string
    {
//        return preg_replace('#&lt;(/?[biu])&gt;#', '<\1>', htmlspecialchars($quote));
//        return preg_replace('#&lt;(/?(?:b|i|u))&gt;#', '<\1>', htmlspecialchars($quote));
        return preg_replace('#&lt;(/?[biu])&gt;#', '<\1>', htmlspecialchars($quote));
    }

    public static function genControls(array $controls): string
    {
        $output = '';
        foreach ($controls as $control) $output .= "<a class=\"$control\">$control</a>";
        return $output;
    }
}