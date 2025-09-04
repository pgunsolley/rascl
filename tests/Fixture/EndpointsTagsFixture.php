<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EndpointsTagsFixture
 */
class EndpointsTagsFixture extends TestFixture
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
                'id' => '50dbf003-ca1a-4108-83bd-05525acf61d9',
                'endpoint_id' => 'a69e8811-bf95-4b83-bbd0-b8e5b2007d7c',
                'tag_id' => '4aeae6a7-801a-43e6-89c3-9290f6479c4a',
                'created' => '2025-09-04 12:15:26',
                'modified' => '2025-09-04 12:15:26',
            ],
        ];
        parent::init();
    }
}
