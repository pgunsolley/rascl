<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TagsUsers Controller
 *
 */
class TagsUsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }
}
