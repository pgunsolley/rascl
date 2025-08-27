<?php

declare(strict_types=1);

namespace App\Listener;

use Crud\Listener\BaseListener;
use CrudView\Menu\MenuItem;

class CrudViewListener extends BaseListener
{
    public function beforeFilter()
    {
        $crud = $this->_controller->Crud;
        if ($crud->isActionMapped()) {
            $action = $crud->action();
            if ($this->_controller->Authentication->getResult()->isValid()) {
                $action->setConfig('scaffold.utility_navigation', [
                    new MenuItem('Log Out', ['_name' => 'logout']),
                ]);
            }
            if (in_array($this->_controller->getRequest()->getParam('action'), ['add', 'edit'])) {
                $action->setConfig('scaffold.fields_blacklist', ['created', 'modified']);
            }
        }
    }

    public function beforeRender()
    {
        $viewBuilder = $this->_controller->viewBuilder();
        if ($this->_controller->Crud->isActionMapped() && $viewBuilder->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
        }
    }
}