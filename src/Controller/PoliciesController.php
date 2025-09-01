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
    public function index()
    {
        $action = $this->Crud->action();
        $action->setConfig('scaffold.fields_blacklist', ['id', 'descriptor']);
        $action->findMethod('index');
        $this->Crud->execute();
    }
}
