<?php
declare(strict_types=1);

namespace App\Controller\Log;

use App\Controller\AppController;

class DatabaseLogController extends AppController
{
	protected ?string $modelClass = 'DatabaseLog.DatabaseLogs';

	protected ?string $defaultTable = 'DatabaseLog.DatabaseLogs';

    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->action()->setConfig('scaffold.sidebar_navigation', false);
        $this->Authentication->allowUnauthenticated([$this->request->getParam('action')]);
        $this->Authorization->skipAuthorization();
    }
}
