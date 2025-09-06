<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Services Controller
 *
 * @property \App\Model\Table\ServicesTable $Services
 */
class ServicesController extends AppController
{
    public function view()
    {
        $this->Crud->on('beforeFind', function (EventInterface $event) {
            $event->getSubject()->query->contain(['Endpoints.Methods']);
        });
        $this->Crud->execute();
    }

    public function edit()
    {
        // TODO: Load same associations as view; consider finder method
        $this->Crud->execute();
    }
}
