<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Policies Controller
 *
 * @property \App\Model\Table\PoliciesTable $Policies
 */
class PoliciesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }

    public function index()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.fields_blacklist', ['descriptor']);
        $action->setConfig('scaffold.fields', [
            'id',
            'url',
            'user_id' => [
                'formatter' => 'element',
                'element' => 'fields/policies/user_id_item',
                'action' => 'index',
            ],
        ]);
        $action->findMethod('index');
        $this->Crud->execute();
    }

    public function view()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.fields', [
            'user_id',
            'id',
            'url',
            'user_id' => [
                'formatter' => 'element',
                'element' => 'fields/policies/user_id_item',
                'action' => 'index',
            ],
            'descriptor',
            'created',
            'modified',
        ]);
        $this->Crud->execute();
    }
}
