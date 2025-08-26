<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Crud\Controller\ControllerTrait;

class AppController extends Controller
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => ['controller' => 'Users', 'action' => 'login'],
        ]);
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Flash');
        $this->loadComponent('FormProtection');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
            ],
            'listeners' => [
                'CrudView.View',
                'Crud.Redirect',
                'Crud.RelatedModels',
            ],
        ]);
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        $viewBuilder = $this->viewBuilder();
        if ($this->Crud->isActionMapped() && $this->viewBuilder()->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
            if (in_array($this->request->getParam('action'), ['add', 'edit'])) {
                $this->Crud->action()->setConfig('scaffold.fields_blacklist', ['created', 'modified']);
            }
        }
        $viewBuilder->addHelper('ViteHelper.ViteScripts');
    }
}
