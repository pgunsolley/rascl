<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);
    $routes->scope('/', static function (RouteBuilder $builder): void {
        $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httponly' => true,
        ]));
        $builder->applyMiddleware('csrf');
        $builder->redirect('/', ['_name' => 'viewPolicies']);
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
        $builder->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], static function (RouteBuilder $builder): void {
            $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
            $actions = ['view', 'add', 'edit', 'delete'];
            foreach ($actions as $action) {
                $builder->connect('/' . $action, ['action' => $action], ['_name' => $action]);
            }
        });
        $builder->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], static function (RouteBuilder $builder): void {
            $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
            $actions = ['view', 'add', 'edit', 'delete'];
            foreach ($actions as $action) {
                $builder->connect('/' . $action, ['action' => $action], ['_name' => $action]);
            }
        });
    });
    $routes->prefix('Api', ['_namePrefix' => 'api:'], static function (RouteBuilder $builder): void {
        $builder->prefix('V1', ['_namePrefix' => 'v1:'], static function (RouteBuilder $builder): void {
            $builder->post('/authenticate', ['controller' => 'Users', 'action' => 'authenticate'], 'authenticate');
            $builder->scope('/users', ['_namePrefix' => 'users:', 'controller' => 'Users'], static function (RouteBuilder $builder): void {
                $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
                $actions = ['view', 'add', 'edit', 'delete'];
                foreach ($actions as $action) {
                    $builder->connect('/' . $action, ['action' => $action], ['_name' => $action]);
                }
            });
            $builder->scope('/policies', ['_namePrefix' => 'policies:', 'controller' => 'Policies'], static function (RouteBuilder $builder): void {
                $builder->connect('/', ['action' => 'index'], ['_name' => 'index']);
                $actions = ['view', 'add', 'edit', 'delete'];
                foreach ($actions as $action) {
                    $builder->connect('/' . $action, ['action' => $action], ['_name' => $action]);
                }
            });
        });
    });
    $routes->fallbacks();
};
