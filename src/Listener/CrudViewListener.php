<?php

declare(strict_types=1);

namespace App\Listener;

use Crud\Listener\BaseListener;
use CrudView\Menu\MenuItem;

class CrudViewListener extends BaseListener
{
    public function beforeFilter()
    {
        if ($this->_crud()->isActionMapped()) {
            $this->manageFieldsBlacklist();
            $this->manageUtilityNavigation();
        }
    }

    public function beforeRender()
    {
        $this->manageCrudView();
    }

    protected function manageUtilityNavigation()
    {
        if (!$this->_controller()->Authentication->getResult()->isValid()) return true;

        $items = [new MenuItem('Log Out', ['_name' => 'logout'])];
        if ($this->_request()->getParam('prefix') === 'Log') {
            array_unshift($items, new MenuItem('Policies', ['_name' => 'policies:index']));
        } else {
            array_unshift($items, new MenuItem('Logs', ['_name' => 'log:index']));
        }
        $this->_action()->setConfig('scaffold.utility_navigation', $items);
    }

    protected function manageFieldsBlacklist()
    {
        $actionName = $this->_request()->getParam('action');
        if (in_array($actionName, ['add', 'edit'])) {
            $this->_action()->setConfig('scaffold.fields_blacklist', ['created', 'modified']);
        }
    }

    protected function manageCrudView()
    {
        $viewBuilder = $this->_controller()->viewBuilder();
        if ($viewBuilder->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
        }
    }
}