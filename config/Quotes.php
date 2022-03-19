<?php

namespace Config;

class Quotes
{
    const QUOTES_ON_PAGE = 10;

    const ROUTES = [
        'api' => [
            'quote' => [
                'add' => [],
                'ai' => [],
                'get' => [
//                    'default_route' => true,
                    'list' => []
                ],
                'remove' => [],
                'update' => []
            ],
            'user' => [
                'confirm' => [],
                'login' => [],
                'logout' => [],
                'signup' => [],
                'recover' => [
                    'request' => []
                ]
            ]
        ],
        'assets' => [
            'js' => [
                'default_route' => true
            ]
        ],
        'index' => [
            'default_route' => true
        ],
        'quote' => [
            'default_route' => true,
            'add' => []
        ],
        'login' => [],
        'signup' => [],
        'recover' => [],
        'profile' => [
            'default_route' => true,
            'confirm' => [
                'default_route' => true
            ],
            'recover' => [
                'default_route' => true
            ]
        ]
    ];
}