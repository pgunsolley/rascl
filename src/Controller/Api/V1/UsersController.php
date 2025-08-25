<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use App\Service\JwtService;
use Cake\Http\Exception\UnauthorizedException;

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

    public function authenticate(JwtService $jwt)
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $user = $result->getData();
            $id = $user->get('id');
            if ($id !== null) {
                $host = $this->request->host();
                $token = $jwt->sign($id, $host);
                if ($token !== null) {
                    $response = ['token' => $token];
                    $this->set(compact('response'));
                    $this->viewBuilder()->setOption('serialize', 'response');
                    return;
                }
            }
        }
        throw new UnauthorizedException();
    }
}
