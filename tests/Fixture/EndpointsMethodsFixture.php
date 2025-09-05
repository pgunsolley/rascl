<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EndpointsMethodsFixture
 */
class EndpointsMethodsFixture extends TestFixture
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
                'id' => 'a6712fcf-94f1-4ef3-ba6d-c3e588ade65f',
                'endpoint_id' => '2a8f66ff-2f18-4dc5-a7e1-7742d0f674b0',
                'method_id' => 1,
                'created' => '2025-09-05 01:19:02',
                'modified' => '2025-09-05 01:19:02',
            ],
        ];
        parent::init();
    }
}
