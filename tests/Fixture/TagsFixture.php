<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsFixture
 */
class TagsFixture extends TestFixture
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
                'id' => '989ca49b-5939-441c-9721-df87fb3ee66f',
                'title' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-08-27 11:17:23',
                'modified' => '2025-08-27 11:17:23',
            ],
        ];
        parent::init();
    }
}
