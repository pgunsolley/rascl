<?php
declare(strict_types=1);

namespace App\Controller\Logs;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class LogsController extends AppController
{
	protected ?string $modelClass = 'DatabaseLog.DatabaseLogs';

	protected ?string $defaultTable = 'DatabaseLog.DatabaseLogs';

    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->disable(['add', 'edit']);
        if ($this->Crud->isActionMapped()) {
            $action = $this->Crud->action();
            $action->setConfig('scaffold.sidebar_navigation', false);
        }
        $this->Authorization->skipAuthorization();
    }

    public function index()
    {
        $this->Crud->on('afterPaginate', function (EventInterface $event) {
            if($event->getSubject()->entities->count() > 0) {
                $this->Crud->action()->setConfig('scaffold.actions', [
                    'view',
                    'delete',
                    'clear' => [
                        'link_title' => 'Clear Logs',
                        'url' => ['_name' => 'logs:clear'],
                        'scope' => 'table',
                    ],
                ]);
            }
        });
        $this->Crud->execute();
    }

    public function view()
    {
        $this->Crud->action()->setConfig('scaffold.actions', ['index', 'delete']);
        $this->Crud->execute();
    }

    public function clear()
    {
        $this->DatabaseLogs->truncate();
        $this->Flash->success(__('Logs cleared'));
        $this->redirect(['_name' => 'logs:index']);
    }
}
