<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login', 'add']);
        $this->Authorization->skipAuthorization();
    }

    public function index()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.fields_blacklist', ['id', 'password']);
        $action->findMethod('index');
        $this->Crud->execute();
    }

    public function add()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.sidebar_navigation', false);
        $action->setConfig('scaffold.utility_navigation', []);
        $this->Crud->execute();
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            return $this->redirect(['_name' => 'policies:index']);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        return $this->redirect($this->Authentication->logout());
    }
}
