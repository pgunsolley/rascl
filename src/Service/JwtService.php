<?php

namespace App\Service;

use Cake\Core\Configure;
use Firebase\JWT\JWT;

class JwtService
{
    public function sign(string $id, string $host): null|string
    {
        $key = Configure::read('Authentication.Authenticators.Jwt.privateKey', null);
        $alg = Configure::read('Authentication.Authenticators.Jwt.algorithm', 'RS256');
        if (!$key) {
            return null;
        }
        $payload = [
            'iss' => $host,
            'aud' => $host,
            'sub' => $id,
            'iat' => 1356999524,
            'nbf' => 1357000000,
        ];
        return JWT::encode($payload, $key, $alg);
    }
}