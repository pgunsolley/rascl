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

    public function index()
    {
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
        $this->Crud->on('beforeRender', static function (EventInterface $event) {
            /** @var \App\Model\Entity\Policy $entity */
            $entity = $event->getSubject()->entity;
            if ($entity->descriptor) {
                $entity->descriptor = json_decode($entity->descriptor, true);
            }
        });
        $this->Crud->execute();
    }

    public function edit()
    {
        $data = $this->request->getData();
        if (array_key_exists('descriptor', $data)) {
            $this->setRequest($this->request->withData('descriptor', json_encode($data['descriptor'])));
        }

        $this->Crud->execute();
    }
}
