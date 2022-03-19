<?php

namespace Helper;

use Config\AccessLevel;

class Page
{
    public static function printDefaultWoLoader(string $title, array $data = [])
    {
        self::print($title, Route::target(), $data, ['common'], ['common'], ["common_loader", Route::routes()[0]]);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public static function print(string $title, string $template, array $data = [], array $styles = ['common'],
                                 array  $scripts = ['common'], array $scriptsBody = ['common_loader'])
    {
        $head = '';
        $path = __DIR__ . "/../templates/$template.html";
        $page = __DIR__ . "/../templates/page.html";
//        if (!is_file($path) || !is_readable($path)) throw NotFoundException::empty();
//        if (!is_file($page) || !is_readable($page)) throw NotFoundException::empty();

        $body = '';
        $body .= file_get_contents(__DIR__ . '/../templates/header.html');
        $body .= file_get_contents($path);

        if (Access::levelLowerEquals(AccessLevel::CORRUPT)) {
            $right = '<a href="' . Route::root() . "/profile/${_SESSION['username']}\">${_SESSION['username']}</a>";
        } else if (Access::levelGreaterEquals(AccessLevel::NOT_CONFIRMED)) {
            $right = '<a href="' . Route::root() . "/profile/${_SESSION['username']}\">${_SESSION['username']}</a>, <a id=\"logout\">logout</a>";
        } else {
            $right = '<a id="login">login</a>';
        }
        $data = array_merge([
            'root' => Route::root(),
            'left' => '<a onclick="window.history.back()">back</a>',
            'center' => '<a href="' . Route::root() . '">Quotes</a>',
            'right' => $right
        ], $data);

        foreach ($styles as $style)
            $head .= "    <link rel=\"stylesheet\" href=\"${data['root']}/assets/css/$style.css\">\n";
        foreach ($scripts as $script)
            $head .= "    <script src=\"${data['root']}/assets/js/$script.js\"></script>\n";
        foreach ($scriptsBody as $script)
            $body .= "<script src=\"${data['root']}/assets/js/$script.js\"></script>\n";

        foreach ($data as $key => $value) {
            $body = str_replace("%$key%", $value, $body);
        }
        include $page;
    }

    public static function printDefault(string $title, array $data = [])
    {
        self::print($title, Route::target(), $data, ['common'], ['common'], ["common_loader", Route::routes()[0], Route::routes()[0] . "_loader"]);
    }
}