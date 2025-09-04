<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EndpointsPoliciesFixture
 */
class EndpointsPoliciesFixture extends TestFixture
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
                'id' => '9235769d-355b-4721-a39a-5cbcedace77d',
                'endpoint_id' => '76766b27-0a84-4432-9c33-d3c0cb213525',
                'policy_id' => '09d47531-6a1e-4463-a40f-623c966c4b20',
                'created' => '2025-09-04 12:15:09',
                'modified' => '2025-09-04 12:15:09',
            ],
        ];
        parent::init();
    }
}
