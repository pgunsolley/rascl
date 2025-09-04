<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersEndpointsFixture
 */
class UsersEndpointsFixture extends TestFixture
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
                'id' => '7b7a8377-95a5-4208-b7fe-166d8d912fe2',
                'user_id' => '802bc817-7ca6-4797-b6a1-a85e361d9cc2',
                'endpoint_id' => '2034bf07-0bfc-4610-929e-625e28094313',
                'created' => '2025-09-04 12:15:31',
                'modified' => '2025-09-04 12:15:31',
            ],
        ];
        parent::init();
    }
}
