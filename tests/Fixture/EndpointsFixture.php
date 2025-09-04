<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EndpointsFixture
 */
class EndpointsFixture extends TestFixture
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
                'id' => '69917035-0147-4571-8687-dcc1a0a80ed1',
                'service_id' => '681c0edd-6bdd-47ed-b47e-373d9a13df2b',
                'description' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-09-04 12:15:00',
                'modified' => '2025-09-04 12:15:00',
            ],
        ];
        parent::init();
    }
}
