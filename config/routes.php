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

return fn(RouteBuilder $r) => 
    $chain($r)
    (fn(RouteBuilder $r) => $r->setRouteClass(DashedRoute::class))
    (fn(RouteBuilder $r) => $r->scope('/', fn(RouteBuilder $r) => 
        $chain($r)
        (fn(RouteBuilder $r) => $r->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httponly' => true,
        ])))
        (fn(RouteBuilder $r) => $r->applyMiddleware('csrf'))
        (fn(RouteBuilder $r) => $r->redirect('/', ['_name' => 'policies:index']))
        (fn(RouteBuilder $r) => $r->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']))
        (fn(RouteBuilder $r) => $r->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']))
        (fn(RouteBuilder $r) => $r->connect('/register', ['controller' => 'Users', 'action' => 'add'], ['_name' => 'register']))
        (fn(RouteBuilder $r) => $r->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], $crud))
        (fn(RouteBuilder $r) => $r->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], $crud))
        (fn(RouteBuilder $r) => $r->scope('/tags', ['_namePrefix' => 'tags:', 'controller' => 'Tags'], $crud))
    ))
    (fn(RouteBuilder $r) => $r->prefix('Api', ['_namePrefix' => 'api:'], fn(RouteBuilder $r) => 
        $chain($r)
        (fn(RouteBuilder $r) => $r->prefix('V1', ['_namePrefix' => 'v1:'], fn(RouteBuilder $r) => 
            $chain($r)
            (fn(RouteBuilder $r) => $r->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate'))
            (fn(RouteBuilder $r) => $r->resources('Users')->resources('Policies'))
        ))
    ))
    (fn(RouteBuilder $r) => $r->fallbacks())
;