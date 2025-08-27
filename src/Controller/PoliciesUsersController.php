<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PoliciesUsers Controller
 *
 */
class PoliciesUsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }
}
