<?php

use App\Authentication\ApiAuthenticationServiceProvider;
use App\Authentication\SuperuserAuthenticationServiceProvider;
use App\Authorization\ApiAuthorizationServiceProvider;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\Middleware\AuthorizationMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** Define named routes for Crud actions. Index is always applied. Other actions may be opt out with ignore */
$crud = fn(array $ignore = []) => static function (RouteBuilder $builder) use ($ignore) {
    $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
    foreach (array_filter(['view', 'add', 'edit', 'delete'], fn($action) => !in_array($action, $ignore)) as $action) {
        $builder->connect("/$action/*", ['action' => $action], ['_name' => $action]);
    }
};

return static function (RouteBuilder $routes) use ($crud) {
    $routes->setRouteClass(DashedRoute::class);
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httponly' => true,
    ]));
    $routes->registerMiddleware('superuser-authentication', new AuthenticationMiddleware(new SuperuserAuthenticationServiceProvider()));
    $routes->registerMiddleware('api-authentication', new AuthenticationMiddleware(new ApiAuthenticationServiceProvider()));
    $routes->registerMiddleware('api-authorization', new AuthorizationMiddleware(new ApiAuthorizationServiceProvider()));

    $routes->scope('/', static function (RouteBuilder $routes) use ($crud) {
        $routes->applyMiddleware('csrf');
        $routes->applyMiddleware('superuser-authentication');
        $routes->redirect('/', ['_name' => 'policies:index']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
        $routes->connect('/register', ['controller' => 'Users', 'action' => 'add'], ['_name' => 'register']);
        $routes->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], $crud());
        $routes->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], $crud());
        $routes->scope('/tags', ['_namePrefix' => 'tags:', 'controller' => 'Tags'], $crud());
        // TODO: Add routes for relationship views
    });

    $routes->prefix('Api', ['_namePrefix' => 'api:'], static function (RouteBuilder $routes) {
        $routes->applyMiddleware('api-authorization');
        $routes->prefix('V1', ['_namePrefix' => 'v1:'], static function (RouteBuilder $routes) {
            $routes->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate');
            $routes->resources('Policies');
        });
    });

    $routes->prefix('Logs', ['_namePrefix' => 'logs:'], static function (RouteBuilder $routes) use ($crud) {
        $routes->applyMiddleware('csrf');
        $routes->applyMiddleware('superuser-authentication');
        $routes->scope('/', ['controller' => 'Logs'], static function (RouteBuilder $routes) use ($crud) {
            $crud(ignore: ['add', 'edit'])($routes);
            $routes->connect('/clear', ['action' => 'clear'], ['_name' => 'clear']);
        });
    });
  
    $routes->fallbacks();
};
