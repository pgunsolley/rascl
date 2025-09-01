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
    public function index()
    {
        // TODO: Only return policies connected to user identity or have a descriptor that allows users to be added?
        $this->Crud->on('beforeRender', static function (EventInterface $event) {
            /** @var \App\Model\Entity\Policy $entity */
            foreach ($event->getSubject()->entities as $entity) {
                if ($entity->descriptor) {
                    $entity->descriptor = json_decode($entity->descriptor, true);
                }
            }
        });
        $this->Crud->execute();
    }

    public function view()
    {
        // TODO: Add authorization check after find
        $this->Crud->on('beforeRender', static function (EventInterface $event) {
            /** @var \App\Model\Entity\Policy $entity */
            $entity = $event->getSubject()->entity;
            if ($entity->descriptor) {
                $entity->descriptor = json_decode($entity->descriptor, true);
            }
        });
        $this->Crud->execute();
    }
}
