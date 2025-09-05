<?php

use App\Authentication\ApiAuthenticationServiceProvider;
use App\Authentication\SuperuserAuthenticationServiceProvider;
use App\Authorization\ApiAuthorizationServiceProvider;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\Middleware\AuthorizationMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Utility\Inflector;

/** Define named routes for Crud actions. */
$crud = fn(array $ignore = []) => static function (RouteBuilder $builder) use ($ignore) {
    if (!in_array('index', $ignore)) {
        $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
    }
    foreach (array_filter(['view', 'add', 'edit', 'delete'], fn($action) => !in_array($action, $ignore)) as $action) {
        $builder->connect("/$action/*", ['action' => $action], ['_name' => $action]);
    }
};

return static function (RouteBuilder $routes) use ($crud) {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', static function (RouteBuilder $routes) use ($crud) {
        $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httponly' => true,
        ]));
        $routes->registerMiddleware('superuser-authentication', new AuthenticationMiddleware(new SuperuserAuthenticationServiceProvider()));
        $routes->applyMiddleware('csrf');
        $routes->applyMiddleware('superuser-authentication');
        $routes->redirect('/', ['_name' => 'policies:index']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
        $routes->connect('/register', ['controller' => 'Users', 'action' => 'add'], ['_name' => 'register']);

        foreach ([
            'endpoints',
            'endpoints-methods',
            'endpoints-policies',
            'endpoints-tags',
            'endpoints-users',
            'policies',
            'policies-tags',
            'services',
            'services-tags',
            'tags',
            'tags-users',
            'users',
        ] as $crudScope) {
            $routes->scope('/' . $crudScope, [
                '_namePrefix' => $crudScope . ':', 
                'controller' => Inflector::camelize(Inflector::underscore($crudScope)),
            ],
            $crud());
        }

        $routes->scope('/methods', ['_namePrefix' => 'methods:', 'controller' => 'Methods'], $crud(ignore: ['add', 'edit', 'delete']));
        $routes->prefix('Logs', ['_namePrefix' => 'logs:'], static function (RouteBuilder $routes) use ($crud) {
            $routes->scope('/', ['controller' => 'Logs'], static function (RouteBuilder $routes) use ($crud) {
                $crud(ignore: ['add', 'edit'])($routes);
                $routes->connect('/clear', ['action' => 'clear'], ['_name' => 'clear']);
            });
        });
    });

    $routes->prefix('Api', ['_namePrefix' => 'api:'], static function (RouteBuilder $routes) {
        $routes->registerMiddleware('api-authentication', new AuthenticationMiddleware(new ApiAuthenticationServiceProvider()));
        $routes->registerMiddleware('api-authorization', new AuthorizationMiddleware(new ApiAuthorizationServiceProvider()));
        $routes->applyMiddleware('api-authentication');
        $routes->applyMiddleware('api-authorization');
        $routes->prefix('V1', ['_namePrefix' => 'v1:'], static function (RouteBuilder $routes) {
            $routes->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate');
            $routes->resources('Policies');
        });
    });  
};
