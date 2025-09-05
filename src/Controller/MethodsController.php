<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Methods Controller
 *
 * @property \App\Model\Table\MethodsTable $Methods
 */
class MethodsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->disable(['add', 'edit', 'delete']);
    }
}
