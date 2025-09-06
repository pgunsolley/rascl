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
            $this->manageTitle();
            $this->manageFieldsBlacklist();
            $this->manageUtilityNavigation();
            $this->manageSidebarNavigation();
        }
    }

    public function beforeRender()
    {
        if ($this->_crud()->isActionMapped()) {
            $this->manageCrudViewClass();
        }
    }

    public function beforeRedirect()
    {
        if ($this->_crud()->isActionMapped()) {
            $this->handleDeleteRedirect();
        }
    }

    protected function manageTitle()
    {
        $this->_action()->setConfig('scaffold.site_title_image', 'wifi.png');
        $this->_action()->setConfig('scaffold.site_title', 'rascl');
    }

    protected function manageSidebarNavigation()
    {
        $this->_action()->setConfig('scaffold.sidebar_navigation', [
            new MenuItem('Users', ['_name' => 'users:index']),
            new MenuItem('Policies', ['_name' => 'policies:index']),
            new MenuItem('Services', ['_name' => 'services:index']),
        ]);
    }

    protected function manageUtilityNavigation()
    {
        if (!$this->_controller()->Authentication->getResult()->isValid()) return;

        $items = [new MenuItem('Log Out', ['_name' => 'logout'])];
        if ($this->_request()->getParam('prefix') === 'Logs') {
            array_unshift($items, new MenuItem('Policies', ['_name' => 'policies:index']));
        } else {
            array_unshift($items, new MenuItem('Logs', ['_name' => 'logs:index']));
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

    protected function manageCrudViewClass()
    {
        $viewBuilder = $this->_controller()->viewBuilder();
        if ($viewBuilder->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
        }
    }

    protected function handleDeleteRedirect()
    {
        if ($this->_request()->getParam('action') === 'delete') {
            $this->_controller->redirect(['action' => 'index']);
        }
    }
}