<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }

    public function index()
    {
        $this->Crud->action()->setConfig('scaffold.fields_blacklist', ['id']);
        $this->Crud->execute();
    }
}
