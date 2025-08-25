<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\View\JsonView;
use Crud\Controller\ControllerTrait;

class ApiController extends Controller
{
    use ControllerTrait;

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
            ],
            'listeners' => [
                'Crud.Api',
            ],
        ]);
    }
}
