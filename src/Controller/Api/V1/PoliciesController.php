<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use Cake\Event\EventInterface;

/**
 * Policies Controller
 *
 * @property \App\Model\Table\PoliciesTable $Policies
 */
class PoliciesController extends ApiController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }

    public function view()
    {
        $this->Crud->on('beforeRender', function (EventInterface $event) {
            $entity = $event->getSubject()->entity;
            $entity->descriptor = json_decode($entity->descriptor);
        });
        $this->Crud->execute();
    }
}
