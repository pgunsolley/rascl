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

return static function (RouteBuilder $routes) use ($crud) {
    $routes->setRouteClass(DashedRoute::class);
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httponly' => true,
    ]));

    $routes->scope('/', static function (RouteBuilder $routes) use ($crud) {
        $routes->applyMiddleware('csrf');
        $routes->redirect('/', ['_name' => 'policies:index']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
        $routes->connect('/register', ['controller' => 'Users', 'action' => 'add'], ['_name' => 'register']);
        $routes->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], $crud);
        $routes->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], $crud);
        $routes->scope('/tags', ['_namePrefix' => 'tags:', 'controller' => 'Tags'], $crud);
    });

    $routes->prefix('Api', ['_namePrefix' => 'api:'], static function (RouteBuilder $routes) {
        $routes->prefix('V1', ['_namePrefix' => 'v1:'], static function (RouteBuilder $routes) {
            $routes->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate');
            $routes->resources('Users');
            $routes->resources('Policies');
        });
    });

    $routes->prefix('Log', ['_namePrefix' => 'log:'], static function (RouteBuilder $routes) use ($crud) {
        $routes->applyMiddleware('csrf');
        $routes->scope('/', ['controller' => 'DatabaseLog'], $crud);
    });
  
    $routes->fallbacks();
};
