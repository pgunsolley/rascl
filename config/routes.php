<?php

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** Define named routes for Crud actions */
$crud = static function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
    foreach (['view', 'add', 'edit', 'delete'] as $action) {
        $builder->connect("/$action/*", ['action' => $action], ['_name' => $action]);
    }
};

/** Chain calls to a RouteBuilder to allow use of closure expressions (to avoid nested closure 'use' references) */
$chain = static function (RouteBuilder $builder) {
    $connect = static function ($handler) use (&$connect, $builder) {
        $handler($builder);
        return $connect;
    };
    return $connect;
};

return fn(RouteBuilder $r) => $chain($r)
    (fn($r) => $r->setRouteClass(DashedRoute::class))
    (fn($r) => $r->scope('/', fn(RouteBuilder $r) => $chain($r)
        (fn($r) => $r->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httponly' => true,
        ])))
        (fn($r) => $r->applyMiddleware('csrf'))
        (fn($r) => $r->connect('/', ['_name' => 'policies:view']))
        (fn($r) => $r->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']))
        (fn($r) => $r->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']))
        (fn($r) => $r->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], $crud))
        (fn($r) => $r->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], $crud))
    ))
    (fn($r) => $r->prefix('Api', ['_namePrefix' => 'api:'], fn(RouteBuilder $r) => $chain($r)
        (fn($r) => $r->prefix('V1', ['_namePrefix' => 'v1:'], fn(RouteBuilder $r) => $chain($r)
            (fn($r) => $r->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate'))
            (fn($r) => $r->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], $crud))
            (fn($r) => $r->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], $crud))
        ))
    ))
    (fn($r) => $r->fallbacks());
