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
                'id' => 1,
                'policy_id' => 'f1d31015-9dcc-4906-a111-f13ee0de9224',
                'tag_id' => 'e4f2c06c-4e6a-445c-8045-8ff01d8c81cc',
            ],
        ];
        parent::init();
    }
}
