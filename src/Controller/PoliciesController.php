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

    public function resource()
    {
        // TODO: Handle auth and request to resource
        dd($this->request->getParam('pass'));
    }
}
