<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsUsersFixture
 */
class TagsUsersFixture extends TestFixture
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
                'id' => '4e6a2c77-a5d9-4ea7-82aa-3de12f8ce675',
                'tag_id' => '971aefd1-68dc-48f5-914b-3f68187deb21',
                'user_id' => 'd9d88a5c-5477-461e-aecb-6cce5f27ec69',
                'created' => '2025-09-04 12:14:41',
                'modified' => '2025-09-04 12:14:41',
            ],
        ];
        parent::init();
    }
}
