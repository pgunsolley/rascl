<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PoliciesFixture
 */
class PoliciesFixture extends TestFixture
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
                'id' => 'b73f1f57-da7a-48b5-a840-5b93bf86d6c2',
                'user_id' => 'eb55477d-3e0d-46d3-9fe3-1010d8c02817',
                'url' => 'Lorem ipsum dolor sit amet',
                'descriptor' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-08-25 00:08:24',
                'modified' => '2025-08-25 00:08:24',
            ],
        ];
        parent::init();
    }
}
