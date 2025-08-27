<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PoliciesTags Controller
 *
 */
class PoliciesTagsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }
}
