<?php

declare(strict_types=1);

namespace App\Authentication;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class ApiAuthenticationServiceProvider implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];
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
}