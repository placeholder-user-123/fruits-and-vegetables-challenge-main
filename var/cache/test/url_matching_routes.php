<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/process' => [[['_route' => 'api_process_json', '_controller' => 'App\\Controller\\ProduceController::processJson'], null, ['POST' => 0], null, false, false, null]],
        '/api/fruits' => [[['_route' => 'api_list_fruits', '_controller' => 'App\\Controller\\ProduceController::listFruits'], null, ['GET' => 0], null, false, false, null]],
        '/api/vegetables' => [[['_route' => 'api_list_vegetables', '_controller' => 'App\\Controller\\ProduceController::listVegetables'], null, ['GET' => 0], null, false, false, null]],
        '/api/fruit' => [[['_route' => 'api_add_fruit', '_controller' => 'App\\Controller\\ProduceController::addFruit'], null, ['POST' => 0], null, false, false, null]],
        '/api/vegetable' => [[['_route' => 'api_add_vegetable', '_controller' => 'App\\Controller\\ProduceController::addVegetable'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/(?'
                    .'|fruits/([^/]++)(*:30)'
                    .'|vegetables/([^/]++)(*:56)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        30 => [[['_route' => 'api_remove_fruit', '_controller' => 'App\\Controller\\ProduceController::removeFruit'], ['id'], ['DELETE' => 0], null, false, true, null]],
        56 => [
            [['_route' => 'api_remove_vegetable', '_controller' => 'App\\Controller\\ProduceController::removeVegetable'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
