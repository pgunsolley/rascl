<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PoliciesTagsFixture
 */
class PoliciesTagsFixture extends TestFixture
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
                'id' => '3859aa37-5338-4be3-a3a4-f3a612ed8e30',
                'policy_id' => 'bccf76be-0208-4ce8-a51b-7ab9c8d161e3',
                'tag_id' => 'b1a41c14-66aa-41e3-b7f3-140aa36bf20a',
                'created' => '2025-09-04 12:14:32',
                'modified' => '2025-09-04 12:14:32',
            ],
        ];
        parent::init();
    }
}
