<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ServicesTagsFixture
 */
class ServicesTagsFixture extends TestFixture
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
                'id' => '080b3f92-8312-4f72-8d46-82ccbccf4e4c',
                'service_id' => '8254828e-ef43-4690-8420-8e1a4d88a9ec',
                'tag_id' => 'a3b85031-c1f0-470a-b9fe-11cddc30d264',
                'created' => '2025-09-04 12:15:20',
                'modified' => '2025-09-04 12:15:20',
            ],
        ];
        parent::init();
    }
}
