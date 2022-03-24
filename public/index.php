<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

// on démarre les sessions
session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);

// CATEGORIES :
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-list'
);
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-add'
);
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-create'
);
$router->map(
    'GET',
    '/category/update/[i:categoryId]',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-edit'
);
$router->map(
    'POST',
    '/category/update/[i:categoryId]',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-update'
);
$router->map(
    'GET',
    '/category/delete/[i:categoryId]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
    ],
    'category-delete'
);

// PRODUCT :
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-list'
);
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-add'
);
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-create'
);
$router->map(
    'GET',
    '/product/update/[i:productId]',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-edit'
);
$router->map(
    'POST',
    '/product/update/[i:productId]',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-update'
);
$router->map(
    'GET',
    '/product/delete/[i:productId]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-delete'
);

// SECURITY
$router->map(
    'GET',
    '/login',
    [
        'method' => 'showLoginForm',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-login-form'
);
$router->map(
    'POST',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-login'
);
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-logout'
);

// USERS
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController' // On indique le FQCN de la classe
    ],
    'user-list'
);
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\UserController' // On indique le FQCN de la classe
    ],
    'user-add'
);
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\UserController' // On indique le FQCN de la classe
    ],
    'user-create'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();