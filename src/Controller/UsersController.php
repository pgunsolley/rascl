<?php
declare(strict_types=1);

namespace App\Controller;

use App\View\AppView;

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
    }

    public function index()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.fields_blacklist', ['password']);
        $action->findMethod('index');
        $this->Crud->execute();
    }

    public function add()
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->viewBuilder()->setClassName(AppView::class);
        }
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
