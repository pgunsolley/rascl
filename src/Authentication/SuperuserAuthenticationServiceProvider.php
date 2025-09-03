<?php

declare(strict_types=1);

namespace App\Authentication;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Identifier\Resolver\OrmResolver;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class SuperuserAuthenticationServiceProvider implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];
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