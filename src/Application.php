<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use App\Service\JwtService;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Identifier\Resolver\OrmResolver;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Http\ServerRequest;
use Crud\Error\ExceptionRenderer;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI !== 'cli') {
            // The bake plugin requires fallback table classes to work properly
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(['exceptionRenderer' => ExceptionRenderer::class] + Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        $container->add(JwtService::class);
    }
    
    /**
     * App-wide authentication service configuration and registration.
     * If concerns become more complex, separate concerns into individual
     * AuthenticationServiceProvider instances and leverage Router middleware.
     *
     * @param  ServerRequestInterface|ServerRequest $request
     * @return AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];

        $prefix = $request->getParam('prefix');

        if ($prefix && str_contains($prefix, 'Api')) {
            $service->loadAuthenticator('Authentication.Jwt', [
                'identifier' => 'Authentication.JwtSubject',
                'secretKey' => Configure::read('Authentication.Authenticators.Jwt.publicKey', null),
                'algorithm' => Configure::read('Authentication.Authenticators.Jwt.algorithm', 'RS256'),
            ]);
            $service->loadAuthenticator('Authentication.Form', [
                'identifier' => [
                    'Authentication.Password' => [
                        'fields' => $fields,
                    ],
                ],
                'fields' => $fields,
                'loginUrl' => Router::url([
                    '_name' => 'api:v1:authenticate',
                ]),
            ]);

            return $service;
        }

        $passwordIdentifier = [
            'Authentication.Password' => [
                'resolver' => [
                    'className' => OrmResolver::class,
                    'finder' => 'forSuperuserAuthentication',
                ],
                'fields' => $fields,
            ],
        ];
        $service->loadAuthenticator('Authentication.Session', [
            'identifier' => $passwordIdentifier,
        ]);
        $loginUrl = Router::url([
            'prefix' => false,
            'plugin' => null,
            '_name' => 'login',
        ]);
        $service->setConfig([
            'loginRedirect' => Router::url(['_name' => 'policies:view']),
            'unauthenticatedRedirect' => $loginUrl,
            'queryParam' => 'redirect',
        ]);
        $service->loadAuthenticator('Authentication.Form', [
            'identifier' => $passwordIdentifier,
            'fields' => $fields,
            'loginUrl' => $loginUrl,
        ]);

        return $service;
    }
}
