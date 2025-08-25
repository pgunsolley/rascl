<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use Cake\Core\Configure;
use Cake\Http\Exception\UnauthorizedException;
use Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends ApiController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['authenticate']);
        $this->Authorization->skipAuthorization();
    }

    public function authenticate()
    {
        $result = $this->Authentication->getResult();
        $key = Configure::read('Authentication.Authenticators.Jwt.privateKey', null);
        $alg = Configure::read('Authentication.Authenticators.Jwt.algorithm', 'RS256');

        if ($key !== null && $result->isValid()) {
            $user = $result->getData();
            $id = $user->get('id');
            
            if ($id !== null) {
                $host = $this->request->host();
                $payload = [
                    'iss' => $host,
                    'aud' => $host,
                    'sub' => $id,
                    'iat' => 1356999524,
                    'nbf' => 1357000000,
                ];
                $token = JWT::encode($payload, $key, $alg);
                $this->set(compact('token'));
                $this->viewBuilder()->setOption('serialize', 'token');
                return;
            }
        }

        throw new UnauthorizedException();
    }
}
