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
                'id' => 1,
                'tag_id' => 'c6653af8-7ae1-4abc-b4f9-a7528f0d73d3',
                'user_id' => 'c61803c3-7022-4a6d-8104-46b657a5f884',
            ],
        ];
        parent::init();
    }
}
