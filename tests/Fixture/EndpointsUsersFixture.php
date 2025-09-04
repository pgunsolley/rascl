<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EndpointsUsersFixture
 */
class EndpointsUsersFixture extends TestFixture
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
                'id' => '2f08d28d-bf29-42dd-86bd-ad70291adcbc',
                'endpoint_id' => '9a63e4d6-5d29-43b8-a026-f6d71769c51d',
                'user_id' => '55ebf337-61f9-465d-be4d-37c9862eb4fa',
                'created' => '2025-09-04 12:20:07',
                'modified' => '2025-09-04 12:20:07',
            ],
        ];
        parent::init();
    }
}
