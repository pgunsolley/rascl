<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PoliciesUsersFixture
 */
class PoliciesUsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'policy_id' => '7f4e351c-5266-4f5f-b281-0d98b47c59e3',
                'user_id' => 'fa717a9c-ca9c-4ee8-b95f-2a34316d9f1d',
            ],
        ];
        parent::init();
    }
}
